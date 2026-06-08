<?php
declare(strict_types=1);

class Track
{
    public int $id;
    public string $title;
    public string $slug;
    public string $shortDescription;
    public string $levelDescription;
    public string $createdAt;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->title = (string) ($data['title'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->shortDescription = (string) ($data['short_description'] ?? '');
        $this->levelDescription = (string) ($data['level_description'] ?? '');
        $this->createdAt = (string) ($data['created_at'] ?? '');
    }
}
