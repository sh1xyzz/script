<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

session_start();
$auth = new Auth(ADMIN_EMAIL, ADMIN_PASSWORD_HASH);
$controller = AdminController::fromConfig($auth);
$controller->handleRequest();

$errors = $controller->getErrors();
$success = $controller->getSuccess();
$tracks = $controller->getTracks();
$applications = $controller->getApplications();
$csrf = $controller->getCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin · <?= h(APP_TITLE) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="admin-shell container">
    <?php if (!$auth->check()): ?>
      <section class="admin-panel login-panel">
        <h1>Admin login</h1>
        <p>Enter the credentials to manage tracks and applications.</p>

        <?php if ($errors): ?>
          <div class="alert alert-error"><?= h(implode(' ', $errors)) ?></div>
        <?php endif; ?>

        <form action="admin.php" method="post" class="admin-form">
          <input type="hidden" name="action" value="login">
          <label><span>Email</span><input type="email" name="email" value="<?= h(ADMIN_EMAIL) ?>" required></label>
          <label><span>Password</span><input type="password" name="password" required></label>
          <button class="button button-primary" type="submit">Sign in</button>
        </form>
      </section>
    <?php else: ?>
      <header class="admin-header">
        <div>
          <h1>Admin dashboard</h1>
          <p>Manage dynamic course offers and application workflow.</p>
        </div>
        <a class="button button-secondary" href="admin.php?logout=1">Sign out</a>
      </header>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= h($success) ?></div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert alert-error"><?= h(implode(' ', $errors)) ?></div>
      <?php endif; ?>

      <section class="admin-section">
        <h2>Course tracks</h2>
        <div class="admin-grid">
          <div class="admin-card">
            <h3>Create / update track</h3>
            <form action="admin.php" method="post" class="admin-form" id="trackForm">
              <input type="hidden" name="action" value="save-track">
              <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
              <input type="hidden" name="track_id" id="trackIdField" value="0">
              <label><span>Track title</span><input type="text" name="title" id="trackTitleField" required></label>
              <label><span>Short description</span><textarea name="short_description" id="trackShortField" rows="3" required></textarea></label>
              <label><span>Level note</span><input type="text" name="level_description" id="trackLevelField" required></label>
              <button class="button button-primary" type="submit">Save track</button>
            </form>
          </div>

          <div class="admin-card">
            <h3>Current tracks</h3>
            <?php if (empty($tracks)): ?>
              <p class="muted">No tracks yet. Create the first track in the form.</p>
            <?php else: ?>
              <div class="track-list">
                <?php foreach ($tracks as $track): ?>
                  <div class="track-item">
                    <div>
                      <strong><?= h($track->title) ?></strong>
                      <p><?= h($track->shortDescription) ?></p>
                    </div>
                    <div class="action-row">
                    <button class="button button-secondary js-edit-track" type="button"
                      data-id="<?= h((string) $track->id) ?>"
                      data-title="<?= h($track->title) ?>"
                      data-short="<?= h($track->shortDescription) ?>"
                      data-level="<?= h($track->levelDescription) ?>">
                      Edit
                    </button>
                    <form action="admin.php" method="post" class="inline-form">
                      <input type="hidden" name="action" value="delete-track">
                      <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                      <input type="hidden" name="track_id" value="<?= h((string) $track->id) ?>">
                      <button class="button button-danger" type="submit">Delete</button>
                    </form>
                  </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="admin-section">
        <h2>Applications</h2>
        <?php if (empty($applications)): ?>
          <p class="muted">No applications submitted yet.</p>
        <?php else: ?>
          <div class="application-list">
            <?php foreach ($applications as $application): ?>
              <article class="application-card">
                <div class="application-head">
                  <div>
                    <span class="badge"><?= h($application->reference) ?></span>
                    <strong><?= h($application->name) ?></strong>
                  </div>
                  <span class="status status-<?= h($application->status) ?>"><?= h($application->status) ?></span>
                </div>
                <div class="application-body">
                  <p><strong>Track:</strong> <?= h($application->language) ?></p>
                  <p><strong>Contact:</strong> <?= h($application->contact) ?></p>
                  <?php if ($application->message !== ''): ?>
                    <p><strong>Note:</strong> <?= h($application->message) ?></p>
                  <?php endif; ?>
                  <p class="muted">Submitted at <?= h($application->createdAt) ?></p>
                </div>
                <div class="application-actions">
                  <form action="admin.php" method="post" class="action-row">
                    <input type="hidden" name="action" value="update-status">
                    <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                    <input type="hidden" name="application_id" value="<?= h((string) $application->id) ?>">
                    <select name="status">
                      <option value="new" <?= $application->status === 'new' ? 'selected' : '' ?>>new</option>
                      <option value="reviewed" <?= $application->status === 'reviewed' ? 'selected' : '' ?>>reviewed</option>
                      <option value="archived" <?= $application->status === 'archived' ? 'selected' : '' ?>>archived</option>
                    </select>
                    <button class="button button-primary" type="submit">Update</button>
                  </form>
                  <form action="admin.php" method="post" class="action-row">
                    <input type="hidden" name="action" value="delete-application">
                    <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                    <input type="hidden" name="application_id" value="<?= h((string) $application->id) ?>">
                    <button class="button button-danger" type="submit">Delete</button>
                  </form>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>
    <?php endif; ?>
  </div>
</body>
</html>
