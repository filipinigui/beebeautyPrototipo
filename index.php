<?php
require_once __DIR__ . '/includes/bootstrap.php';

$services = get_list('services');
$byCat = [];
foreach ($services as $s) { $byCat[$s['category']][] = $s; }
$featured = array_filter($services, fn($s) => !empty($s['featured']));
$team     = get_list('team');
$gallery  = get_list('gallery');
$reviews  = get_list('reviews');
?>
<!DOCTYPE html>
<html lang="en-AU">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e(SITE_NAME) ?> | Hair, brows and lashes in Buderim</title>
  <meta name="description" content="BeeBeauty is a Buderim salon for haircuts, colour, keratin, brows, lashes and makeup.">
  <meta name="csrf" content="<?= e(csrf_token()) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="nav" id="nav">
  <a href="#top" class="brand">
    <!-- Trocar pelo logo da cliente: <img src="assets/img/logo.svg" alt="BeeBeauty"> -->
    <?= e(SITE_NAME) ?>
  </a>
  <button class="nav-toggle" aria-label="Menu" aria-expanded="false"><span></span><span></span></button>
  <nav class="nav-links">
    <a href="#services">Services</a>
    <a href="#results">Results</a>
    <a href="#team">Team</a>
    <a href="#reviews">Reviews</a>
    <a href="#contact">Contact</a>
    <a href="#book" class="btn btn-sm">Book online</a>
  </nav>
</header>

<main id="top">

  <!-- HERO: resultados logo no início (pedido da cliente) -->
  <section class="hero">
    <div class="hero-text">
      <h1>Quality you can see, a team you’ll love.</h1>
      <p>Hair, brows and lashes by qualified stylists in a friendly Buderim salon.</p>
      <a href="#book" class="btn">Book your appointment</a>
      <p class="hero-meta"><?= e(SITE_HOURS) ?></p>
    </div>
    <div class="ba" data-ba aria-label="Before and after comparison">
      <div class="ba-img ba-after"><span>Photo: after</span></div>
      <div class="ba-img ba-before"><span>Photo: before</span></div>
      <div class="ba-handle" role="slider" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" tabindex="0"></div>
    </div>
  </section>

  <!-- SERVICES -->
  <section id="services" class="section">
    <h2>Services</h2>
    <?php if ($featured): ?>
    <div class="featured">
      <?php foreach ($featured as $s): ?>
        <a href="#book" class="feat" data-service="<?= e($s['name']) ?>">
          <strong><?= e($s['name']) ?></strong>
          <span>Most requested, <?= e($s['price']) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="menu">
      <?php foreach ($byCat as $cat => $items): ?>
        <div class="menu-col">
          <h3><?= e($cat) ?></h3>
          <ul>
            <?php foreach ($items as $s): ?>
              <li><span><?= e($s['name']) ?></span><em><?= e($s['price']) ?></em></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- GALERIA / ANTES E DEPOIS -->
  <section id="results" class="section section-alt">
    <h2>Results</h2>
    <div class="grid grid-3">
      <?php foreach ($gallery as $g): ?>
        <figure class="tile">
          <div class="ph"><?= $g['after'] ? '<img src="' . e($g['after']) . '" alt="' . e($g['title']) . '" loading="lazy">' : 'Photo' ?></div>
          <figcaption><?= e($g['title']) ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- EQUIPE -->
  <section id="team" class="section">
    <h2>Meet the team</h2>
    <div class="grid grid-3">
      <?php foreach ($team as $m): ?>
        <article class="person">
          <div class="ph ph-round"><?= $m['photo'] ? '<img src="' . e($m['photo']) . '" alt="' . e($m['name']) . '" loading="lazy">' : '' ?></div>
          <h3><?= e($m['name']) ?></h3>
          <p><?= e($m['role']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- DEPOIMENTOS -->
  <section id="reviews" class="section section-alt">
    <h2>What clients say</h2>
    <div class="grid grid-3">
      <?php foreach ($reviews as $r): ?>
        <blockquote class="review">
          <div class="stars" aria-label="<?= (int)$r['stars'] ?> out of 5 stars"><?= str_repeat('★', (int)$r['stars']) ?></div>
          <p><?= e($r['text']) ?></p>
          <cite><?= e($r['author']) ?></cite>
        </blockquote>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- SOBRE -->
  <section id="about" class="section about">
    <h2>About BeeBeauty</h2>
    <p>One year in Buderim, built on qualified professionals and a relaxed, friendly atmosphere. Texto definitivo a ser enviado pela cliente.</p>
  </section>

  <!-- AGENDAMENTO ONLINE -->
  <section id="book" class="section section-alt">
    <h2>Book online</h2>
    <form id="booking-form" class="form" novalidate>
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true"><!-- anti-spam -->
      <label>Name<input type="text" name="name" required></label>
      <label>Phone<input type="tel" name="phone" required></label>
      <label>Email<input type="email" name="email" required></label>
      <label>Service
        <select name="service" required>
          <option value="">Choose a service</option>
          <?php foreach ($byCat as $cat => $items): ?>
            <optgroup label="<?= e($cat) ?>">
              <?php foreach ($items as $s): ?><option><?= e($s['name']) ?></option><?php endforeach; ?>
            </optgroup>
          <?php endforeach; ?>
        </select>
      </label>
      <label>Preferred date<input type="date" name="date" required></label>
      <label>Preferred time<input type="time" name="time" min="09:00" max="17:30" step="1800" required></label>
      <label class="full">Notes<textarea name="notes" rows="3"></textarea></label>
      <button type="submit" class="btn full">Request appointment</button>
      <p class="form-msg full" role="status" aria-live="polite"></p>
    </form>
  </section>

  <!-- CONTATO -->
  <section id="contact" class="section">
    <h2>Find us</h2>
    <div class="contact">
      <div>
        <p><?= e(SITE_ADDRESS) ?></p>
        <p><?= e(SITE_HOURS) ?></p>
        <p><a href="tel:<?= e(preg_replace('/\s+/', '', SITE_PHONE)) ?>"><?= e(SITE_PHONE) ?></a></p>
        <p><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></p>
        <p><a href="#">Instagram</a>, <a href="#">Facebook</a></p>
      </div>
      <div class="map ph">Google Map (embed depois)</div>
    </div>
  </section>
</main>

<footer class="footer">
  <p>© <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
