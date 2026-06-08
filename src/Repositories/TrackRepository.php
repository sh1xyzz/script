<?php
declare(strict_types=1);

class TrackRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM tracks ORDER BY id DESC');
        return array_map(static fn(array $item) => new Track($item), $statement->fetchAll());
    }

    public function findById(int $id): ?Track
    {
        $statement = $this->pdo->prepare('SELECT * FROM tracks WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $data = $statement->fetch();

        return $data === false ? null : new Track($data);
    }

    public function save(array $data): Track
    {
        $slug = $this->buildSlug((string) ($data['title'] ?? ''));

        if (!empty($data['id'])) {
            $statement = $this->pdo->prepare(
                'UPDATE tracks SET title = :title, slug = :slug, short_description = :short_description, level_description = :level_description WHERE id = :id'
            );
            $statement->execute([
                'title' => $data['title'],
                'slug' => $slug,
                'short_description' => $data['short_description'],
                'level_description' => $data['level_description'],
                'id' => $data['id'],
            ]);

            return $this->findById((int) $data['id']);
        }

        $statement = $this->pdo->prepare(
            'INSERT INTO tracks (title, slug, short_description, level_description) VALUES (:title, :slug, :short_description, :level_description)'
        );
        $statement->execute([
            'title' => $data['title'],
            'slug' => $slug,
            'short_description' => $data['short_description'],
            'level_description' => $data['level_description'],
        ]);

        return $this->findById((int) $this->pdo->lastInsertId());
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM tracks WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    private function buildSlug(string $title): string
    {
        $slug = mb_strtolower(trim($title), 'UTF-8');
        $slug = preg_replace('/[^a-z0-9\s-]/u', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        return trim($slug, '-');
    }
}
