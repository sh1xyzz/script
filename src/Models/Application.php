<?php
declare(strict_types=1);

class Application
{
    public int $id;
    public string $reference;
    public string $name;
    public string $contact;
    public string $language;
    public string $message;
    public string $status;
    public string $createdAt;

    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? 0);
        $this->reference = (string) ($data['reference'] ?? '');
        $this->name = (string) ($data['name'] ?? '');
        $this->contact = (string) ($data['contact'] ?? '');
        $this->language = (string) ($data['language'] ?? '');
        $this->message = (string) ($data['message'] ?? '');
        $this->status = (string) ($data['status'] ?? 'new');
        $this->createdAt = (string) ($data['created_at'] ?? '');
    }
}
