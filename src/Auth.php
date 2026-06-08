<?php
declare(strict_types=1);

class Auth
{
    private string $email;
    private string $passwordHash;

    public function __construct(string $email, string $passwordHash)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function login(string $email, string $password): bool
    {
        if ($email !== $this->email) {
            return false;
        }

        if (!password_verify($password, $this->passwordHash)) {
            return false;
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION[ADMIN_SESSION_KEY] = true;
        return true;
    }

    public function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return !empty($_SESSION[ADMIN_SESSION_KEY]);
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        unset($_SESSION[ADMIN_SESSION_KEY]);
    }
}
