<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

spl_autoload_register(static function (string $class): void {
    $src = __DIR__ . DIRECTORY_SEPARATOR . 'src';
    $classPath = $src . DIRECTORY_SEPARATOR . $class . '.php';
    $modelPath = $src . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . $class . '.php';
    $repositoryPath = $src . DIRECTORY_SEPARATOR . 'Repositories' . DIRECTORY_SEPARATOR . $class . '.php';

    foreach ([$classPath, $modelPath, $repositoryPath] as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function getCsrfToken(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION[CSRF_SESSION_KEY])) {
        $_SESSION[CSRF_SESSION_KEY] = bin2hex(random_bytes(16));
    }

    return $_SESSION[CSRF_SESSION_KEY];
}

function verifyCsrfToken(?string $token): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION[CSRF_SESSION_KEY]) || $token === null) {
        return false;
    }

    return hash_equals($_SESSION[CSRF_SESSION_KEY], $token);
}
