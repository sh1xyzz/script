<?php
declare(strict_types=1);

class ApplicationRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM applications ORDER BY id DESC');
        return array_map(static fn(array $item) => new Application($item), $statement->fetchAll());
    }

    public function findById(int $id): ?Application
    {
        $statement = $this->pdo->prepare('SELECT * FROM applications WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $data = $statement->fetch();

        return $data === false ? null : new Application($data);
    }

    public function create(array $data): Application
    {
        $reference = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        $statement = $this->pdo->prepare(
            'INSERT INTO applications (reference, name, contact, language, message) VALUES (:reference, :name, :contact, :language, :message)'
        );
        $statement->execute([
            'reference' => $reference,
            'name' => $data['name'],
            'contact' => $data['contact'],
            'language' => $data['language'],
            'message' => $data['message'],
        ]);

        return $this->findById((int) $this->pdo->lastInsertId());
    }

    public function updateStatus(int $id, string $status): void
    {
        $allowed = ['new', 'reviewed', 'archived'];
        if (!in_array($status, $allowed, true)) {
            throw new InvalidArgumentException('Invalid application status.');
        }

        $statement = $this->pdo->prepare('UPDATE applications SET status = :status WHERE id = :id');
        $statement->execute(['status' => $status, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM applications WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
