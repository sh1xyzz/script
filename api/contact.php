<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

require_once __DIR__ . '/../bootstrap.php';

function clean(string $value): string
{
    $value = strip_tags(trim($value));
    return preg_replace('/\s+/u', ' ', $value) ?? '';
}

$name = clean($_POST['name'] ?? '');
$contact = clean($_POST['contact'] ?? '');
$language = clean($_POST['language'] ?? '');
$message = clean($_POST['message'] ?? '');

if ($name === '' || $contact === '' || $language === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please fill in name, contact and track selection.']);
    exit;
}

$database = new Database(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
$applicationRepository = new ApplicationRepository($database->getConnection());

try {
    $application = $applicationRepository->create([
        'name' => $name,
        'contact' => $contact,
        'language' => $language,
        'message' => $message,
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Application submitted successfully. We will contact you soon.',
        'reference' => $application->reference,
    ]);
} catch (Throwable $exception) {
    http_response_code(500);
    error_log($exception->getMessage());
    echo json_encode(['success' => false, 'message' => 'Could not save your application. Please try again later.']);
}
