<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

$tracks = [];
$connectionError = '';

try {
    $database = new Database(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
    $trackRepository = new TrackRepository($database->getConnection());
    $tracks = $trackRepository->findAll();
} catch (Throwable $exception) {
    $connectionError = 'Database is not available. Displaying sample programs.';
}

if (empty($tracks)) {
    $tracks = [
        new Track([
            'id' => 0,
            'title' => 'English FastTalk',
            'slug' => 'english-fasttalk',
            'short_description' => 'Boost spoken fluency for interviews, travel, and everyday conversations.',
            'level_description' => 'A1–C1 trajectory',
            'created_at' => date('Y-m-d H:i:s'),
        ]),
        new Track([
            'id' => 0,
            'title' => 'German StartKraft',
            'slug' => 'german-startkraft',
            'short_description' => 'Learn practical German with clear structure, conversation tasks, and coach support.',
            'level_description' => 'A1–B2 trajectory',
            'created_at' => date('Y-m-d H:i:s'),
        ]),
        new Track([
            'id' => 0,
            'title' => 'Spanish VivaVoice',
            'slug' => 'spanish-vivavoice',
            'short_description' => 'Move from passive vocabulary to active conversations with daily speaking practice.',
            'level_description' => 'A1–B1 trajectory',
            'created_at' => date('Y-m-d H:i:s'),
        ]),
    ];
}

$contentSections = SiteContent::getContentSections();
$trackCompare = SiteContent::getTrackCompare();
$quizQuestions = SiteContent::getQuizQuestions();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h(APP_TITLE) ?> — Language Lab</title>
  <meta name="description" content="A polished PHP web app for language learning with dynamic course cards, admin tools, and a responsive interface.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="scroll-progress"><div class="scroll-progress__fill"></div></div>
<div class="site-shell">

  <header class="page-header container" id="top">
    <a class="logo" href="#top"><?= h(APP_TITLE) ?></a>
    <button class="nav-toggle" aria-label="Open navigation" aria-expanded="false">
      <span></span>
      <span></span>
    </button>
    <nav class="nav-links">
      <a href="#about">About</a>
      <a href="#features">Features</a>
      <a href="#tracks">Programs</a>
      <a href="#testimonials">Testimonials</a>
      <a href="#faq">FAQ</a>
      <a class="button button-secondary" href="#contact">Apply</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-bg"><span>LEARN</span></div>
    <div class="hero-inner container">
      <div class="hero-copy">
        <p class="eyebrow">Minimal · Modern · PHP</p>
        <h1 class="hero-title">Launch a sleek language lab with clean PHP architecture.</h1>
        <span class="hero-subtitle">Semester project made real</span>
        <p>Scriptovation is a polished web prototype with dynamic program cards, secure admin workflows, and a fast responsive interface.</p>
        <div class="hero-actions">
          <a class="button button-primary" href="#tracks">See programs</a>
          <a class="button button-secondary" href="#contact">Apply now</a>
        </div>
        <?php if ($connectionError !== ''): ?>
          <div class="alert alert-error"><?= h($connectionError) ?></div>
        <?php endif; ?>
      </div>
      <div class="hero-panel">
        <div>
          <p class="panel-label">Project snapshot</p>
          <h2>OOP PHP + MySQL</h2>
          <p>A semester-ready application built with clear structure, secure data handling and an engaging UI — no framework required.</p>
        </div>
        <div class="panel-meta">
          <div class="panel-stat">
            <span>Architecture</span>
            <strong>OOP</strong>
          </div>
          <div class="panel-stat">
            <span>Stack</span>
            <strong>PHP 8</strong>
          </div>
          <div class="panel-stat">
            <span>Database</span>
            <strong>MySQL</strong>
          </div>
          <div class="panel-stat">
            <span>Framework</span>
            <strong>None</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="ticker-row">
    <div class="ticker-track" aria-hidden="true">
      <div class="ticker-item">Live lessons</div>
      <div class="ticker-item">Speaking drills</div>
      <div class="ticker-item">Weekly feedback</div>
      <div class="ticker-item">Personal track plan</div>
      <div class="ticker-item">Secure PHP backend</div>
      <div class="ticker-item">Fast responsive UI</div>
      <div class="ticker-item">Real conversation focus</div>
      <div class="ticker-item">Live lessons</div>
      <div class="ticker-item">Speaking drills</div>
      <div class="ticker-item">Weekly feedback</div>
      <div class="ticker-item">Personal track plan</div>
      <div class="ticker-item">Secure PHP backend</div>
      <div class="ticker-item">Fast responsive UI</div>
      <div class="ticker-item">Real conversation focus</div>
    </div>
  </div>

  <main>
    <section class="section container" id="tracks">
      <div class="section-heading">
        <div>
          <p class="eyebrow">Program tracks</p>
          <h2>Courses designed to build speaking confidence.</h2>
        </div>
        <p>Three language tracks, each engineered for rapid spoken fluency — structured progression from first lesson to real conversation.</p>
      </div>
      <div class="language-grid">
        <?php foreach ($tracks as $index => $track): ?>
          <article class="language-card">
            <div class="card-topline"><?= h($track->title) ?></div>
            <h3><?= h($track->shortDescription) ?></h3>
            <p><?= h($track->levelDescription) ?></p>
            <span class="card-num"><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section container" id="compare">
      <div class="section-heading">
        <div>
          <p class="eyebrow">Compare</p>
          <h2>Pick the right track for your goal</h2>
        </div>
        <p>Compare structure, level support and pace for each language program.</p>
      </div>
      <div class="compare-table-wrap">
        <table class="compare-table">
          <thead>
            <tr>
              <th>Track</th>
              <th>Format</th>
              <th>Level</th>
              <th>Intensity</th>
              <th>Duration</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($trackCompare as $title => $item): ?>
              <tr>
                <td><?= h($title) ?></td>
                <td><?= h($item['format']) ?></td>
                <td><?= h($item['level']) ?></td>
                <td><?= h($item['intensity']) ?></td>
                <td><?= h($item['duration']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="section container" id="about">
      <div class="section-heading">
        <div>
          <p class="eyebrow">About</p>
          <h2>Why Scriptovation exists</h2>
        </div>
        <p>We create short, practical speaking-focused courses that help learners use language from day one. The approach is lean, clear, and action-oriented.</p>
      </div>
      <div class="language-grid">
        <?php foreach ($contentSections['about'] as $item): ?>
          <article class="language-card">
            <div class="card-topline"><?= h($item['topline']) ?></div>
            <h3><?= h($item['title']) ?></h3>
            <p><?= h($item['description']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section container" id="features">
      <div class="section-heading">
        <div>
          <p class="eyebrow">Features</p>
          <h2>Built-in tools for consistent practice.</h2>
        </div>
        <p>Tools and flows baked into every lesson to support retention and keep learners moving forward.</p>
      </div>
      <div class="language-grid">
        <?php foreach ($contentSections['features'] as $item): ?>
          <article class="language-card">
            <div class="card-topline"><?= h($item['topline']) ?></div>
            <h3><?= h($item['title']) ?></h3>
            <p><?= h($item['description']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section container" id="testimonials">
      <div class="section-heading">
        <div>
          <p class="eyebrow">Testimonials</p>
          <h2>What students say</h2>
        </div>
        <p>Results from people who completed Scriptovation tracks across different languages and levels.</p>
      </div>
      <div class="language-grid">
        <?php foreach ($contentSections['testimonials'] as $item): ?>
          <article class="language-card">
            <div class="card-topline"><?= h($item['topline']) ?></div>
            <h3><?= h($item['title']) ?></h3>
            <p><?= h($item['description']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section container" id="faq">
      <div class="section-heading">
        <div>
          <p class="eyebrow">FAQ</p>
          <h2>Quick answers</h2>
        </div>
        <p>Common questions about format, levels, and getting started.</p>
      </div>
      <div class="faq-list" role="list">
        <?php foreach ($contentSections['faq'] as $index => $item): ?>
          <article class="faq-item" data-index="<?= $index ?>">
            <button type="button" class="faq-question" aria-expanded="false">
              <span><?= h($item['title']) ?></span>
              <span class="faq-toggle">+</span>
            </button>
            <div class="faq-answer" hidden>
              <p><?= h($item['description']) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section container" id="quiz">
      <div class="section-heading">
        <div>
          <p class="eyebrow">Quiz</p>
          <h2>Find your ideal learning track</h2>
        </div>
        <p>Answer three quick prompts and see the best track match.</p>
      </div>
      <div class="quiz-card">
        <form id="trackQuiz" class="quiz-form">
          <?php foreach ($quizQuestions as $qIndex => $question): ?>
            <fieldset>
              <legend><?= h($question['question']) ?></legend>
              <div class="quiz-options">
                <?php foreach ($question['options'] as $optionIndex => $option): ?>
                  <label>
                    <input type="radio" name="question_<?= $qIndex ?>" value="<?= h($option) ?>" required>
                    <?= h($option) ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </fieldset>
          <?php endforeach; ?>
          <button class="button button-primary" type="submit">Show best match</button>
        </form>
        <div class="quiz-result" id="quizResult" aria-live="polite"></div>
      </div>
    </section>

    <section class="section container" id="contact">
      <div class="contact-layout">
        <div class="contact-copy">
          <p class="eyebrow">Apply for a trial</p>
          <h2>Send a short application and we will respond within one business day.</h2>
          <p>Pick the track that matches your goals, and the team will help you start at the right level.</p>
        </div>
        <form class="contact-form" id="contactForm" action="api/contact.php" method="post">
          <label><span>Name</span><input type="text" name="name" placeholder="Your name" required></label>
          <label><span>Phone or Telegram</span><input type="text" name="contact" placeholder="@username or phone" required></label>
          <label>
            <span>Language track</span>
            <div class="select-wrap">
              <select name="language" required>
                <option value="">Choose a track</option>
                <?php foreach ($tracks as $track): ?>
                  <option value="<?= h($track->title) ?>"><?= h($track->title) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </label>
          <label><span>Message</span><textarea name="message" rows="4" placeholder="A short note about your goals"></textarea></label>
          <button class="button button-primary button-full" type="submit">Send application</button>
          <p class="form-status" id="formStatus" aria-live="polite"></p>
        </form>
      </div>
    </section>
  </main>

  <footer class="footer container">
    <div class="footer-grid">
      <div class="footer-col">
        <span class="logo"><?= h(APP_TITLE) ?></span>
        <p>Scriptovation combines polished PHP logic, a lean learning flow and fast application management for a modern semester project.</p>
      </div>
      <div class="footer-col">
        <h3>Explore</h3>
        <nav class="footer-links">
          <a href="#about">About</a>
          <a href="#features">Features</a>
          <a href="#tracks">Programs</a>
          <a href="#contact">Apply</a>
        </nav>
      </div>
      <div class="footer-col">
        <h3>Contact</h3>
        <p>Email: <a class="footer-link" href="mailto:admin@scriptovation.local">admin@scriptovation.local</a></p>
        <p><a class="footer-link" href="admin.php">Admin dashboard</a></p>
      </div>
    </div>
    <div class="footer-note">
      <span>© 2025 Scriptovation. Clean PHP, no frameworks, no CMS.</span>
      <span>OOP · MySQL · Responsive</span>
    </div>
  </footer>
</div>
<script src="script.js"></script>
</body>
</html>
