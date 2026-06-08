<?php
declare(strict_types=1);

class AdminController
{
    private Auth $auth;
    private ?TrackRepository $trackRepository;
    private ?ApplicationRepository $applicationRepository;
    private array $errors = [];
    private string $success = '';
    private string $dbError = '';
    private string $csrfToken;

    public function __construct(Auth $auth, ?TrackRepository $trackRepository = null, ?ApplicationRepository $applicationRepository = null, string $dbError = '')
    {
        $this->auth = $auth;
        $this->trackRepository = $trackRepository;
        $this->applicationRepository = $applicationRepository;
        $this->dbError = $dbError;
        $this->csrfToken = getCsrfToken();
    }

    public static function fromConfig(Auth $auth): self
    {
        try {
            $database = new Database(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
            $connection = $database->getConnection();
            return new self(
                $auth,
                new TrackRepository($connection),
                new ApplicationRepository($connection)
            );
        } catch (Throwable $exception) {
            return new self($auth, null, null, 'Database connection failed. Please check config.php and run db-schema.sql.');
        }
    }

    public function handleRequest(): void
    {
        if ($this->isLogout()) {
            $this->auth->logout();
            $this->redirect('admin.php');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $action = $_POST['action'] ?? '';

        if ($action === 'login') {
            $this->handleLogin($_POST);
            return;
        }

        if (!$this->auth->check()) {
            return;
        }

        if ($this->dbError !== '') {
            $this->errors[] = $this->dbError;
            return;
        }

        if (!verifyCsrfToken($_POST['csrf'] ?? null)) {
            $this->errors[] = 'Invalid request token.';
            return;
        }

        switch ($action) {
            case 'save-track':
                $this->handleSaveTrack($_POST);
                break;
            case 'delete-track':
                $this->handleDeleteTrack($_POST);
                break;
            case 'update-status':
                $this->handleUpdateStatus($_POST);
                break;
            case 'delete-application':
                $this->handleDeleteApplication($_POST);
                break;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccess(): string
    {
        return $this->success;
    }

    public function getTracks(): array
    {
        if ($this->trackRepository === null) {
            return [];
        }

        return $this->trackRepository->findAll();
    }

    public function getApplications(): array
    {
        if ($this->applicationRepository === null) {
            return [];
        }

        return $this->applicationRepository->findAll();
    }

    public function getCsrfToken(): string
    {
        return $this->csrfToken;
    }

    public function isAuthenticated(): bool
    {
        return $this->auth->check();
    }

    private function handleLogin(array $input): void
    {
        $email = trim((string) ($input['email'] ?? ''));
        $password = trim((string) ($input['password'] ?? ''));

        if (!$this->auth->login($email, $password)) {
            $this->errors[] = 'Login failed. Check your credentials.';
            return;
        }

        $this->redirect('admin.php');
    }

    private function handleSaveTrack(array $input): void
    {
        $data = [
            'id' => isset($input['track_id']) ? (int) $input['track_id'] : 0,
            'title' => trim((string) ($input['title'] ?? '')),
            'short_description' => trim((string) ($input['short_description'] ?? '')),
            'level_description' => trim((string) ($input['level_description'] ?? '')),
        ];

        $errors = $this->validateTrackData($data);
        if ($errors !== []) {
            $this->errors = array_merge($this->errors, $errors);
            return;
        }

        $this->trackRepository->save($data);
        $this->success = $data['id'] > 0 ? 'Track updated successfully.' : 'Track created successfully.';
    }

    private function handleDeleteTrack(array $input): void
    {
        $id = isset($input['track_id']) ? (int) $input['track_id'] : 0;
        if ($id <= 0) {
            $this->errors[] = 'Invalid track selected for deletion.';
            return;
        }

        $this->trackRepository->delete($id);
        $this->success = 'Track removed successfully.';
    }

    private function handleUpdateStatus(array $input): void
    {
        $id = isset($input['application_id']) ? (int) $input['application_id'] : 0;
        $status = (string) ($input['status'] ?? 'new');

        if ($id <= 0) {
            $this->errors[] = 'Invalid application selected.';
            return;
        }

        $this->applicationRepository->updateStatus($id, $status);
        $this->success = 'Application status updated.';
    }

    private function handleDeleteApplication(array $input): void
    {
        $id = isset($input['application_id']) ? (int) $input['application_id'] : 0;

        if ($id <= 0) {
            $this->errors[] = 'Invalid application selected for deletion.';
            return;
        }

        $this->applicationRepository->delete($id);
        $this->success = 'Application deleted successfully.';
    }

    private function validateTrackData(array $data): array
    {
        $errors = [];

        if ($data['title'] === '') {
            $errors[] = 'Track title is required.';
        }
        if ($data['short_description'] === '') {
            $errors[] = 'Short description is required.';
        }
        if ($data['level_description'] === '') {
            $errors[] = 'Level description is required.';
        }

        return $errors;
    }

    private function isLogout(): bool
    {
        return isset($_GET['logout']);
    }

    private function redirect(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
