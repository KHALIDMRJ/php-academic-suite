<?php
/**
 * FPK — Site Header & Navigation
 * Included at the top of every page.
 *
 * @expects string $activePanelOnLoad  set in index.php before this include
 */

require_once __DIR__ . '/functions.php';
startSession();

$flash = getFlash();
$activePanelOnLoad = $activePanelOnLoad ?? 'ex1';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Travaux pratiques PHP — Faculté Polydisciplinaire de Khouribga. Formulaires, boucles, patterns, algorithmes.">
  <meta name="author" content="FPK">
  <title>PHP Exercices — FPK</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%2352e8a2'/><text x='4' y='24' font-size='20' font-weight='bold' fill='%23070710'>P</text></svg>">
</head>
<body>

<!-- ── FLASH TOAST ── -->
<?php if ($flash): ?>
<div id="flash" class="flash flash-<?= htmlspecialchars($flash['type']) ?> show" role="alert" aria-live="polite">
  <?php if ($flash['type'] === 'success'): ?>
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
      <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
      <path d="M5 8l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  <?php else: ?>
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
      <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
      <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
    </svg>
  <?php endif; ?>
  <span class="flash-msg"><?= htmlspecialchars($flash['msg']) ?></span>
</div>
<script>setTimeout(() => { const f = document.getElementById('flash'); if (f) f.classList.remove('show'); }, 4500);</script>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════
     SITE HEADER
     ══════════════════════════════════════════════════ -->
<header class="site-header" role="banner">
  <div class="container">
    <div class="header-brand">
      <div class="header-badge" aria-label="FPK — Faculté Polydisciplinaire Khouribga">
        <span class="badge-dot" aria-hidden="true"></span>
        <span data-i18n="badge-fpk">FPK — Faculté Polydisciplinaire Khouribga</span>
      </div>
      <h1 class="header-title">PHP <em>Exercices</em></h1>
      <p class="header-subtitle" data-i18n="header-subtitle">
        Collection structurée de travaux pratiques PHP — Exercices 1 à 4
      </p>
    </div>

    <div class="header-meta" aria-label="Métadonnées du projet">
      <div class="header-stat">PHP 8.x</div>
      <div class="header-stat">4 Exercices · Modulaire</div>
      <div class="header-stat">Boucles · Formulaires · Algorithmes</div>
      <div class="lang-switcher" role="group" aria-label="Choix de langue">
        <button class="lang-btn active" data-lang="fr" onclick="switchLang('fr')" aria-pressed="true">FR</button>
        <button class="lang-btn"        data-lang="en" onclick="switchLang('en')" aria-pressed="false">EN</button>
      </div>
    </div>
  </div>
</header>

<!-- ══════════════════════════════════════════════════
     NAVIGATION TABS
     ══════════════════════════════════════════════════ -->
<nav class="site-nav" role="tablist" aria-label="Navigation des exercices">
  <div class="nav-inner">
    <button class="nav-tab" onclick="switchTab('ex1', this)" role="tab" aria-controls="ex1" title="Alt+1">
      <span class="tab-chip">01</span>
      <span data-i18n="nav-ex1">Étudiant &amp; Notes</span>
    </button>
    <button class="nav-tab" onclick="switchTab('ex2', this)" role="tab" aria-controls="ex2" title="Alt+2">
      <span class="tab-chip">02</span>
      <span data-i18n="nav-ex2">Patterns</span>
    </button>
    <button class="nav-tab" onclick="switchTab('ex3', this)" role="tab" aria-controls="ex3" title="Alt+3">
      <span class="tab-chip">03</span>
      <span data-i18n="nav-ex3">Fibonacci</span>
    </button>
    <button class="nav-tab" onclick="switchTab('ex4', this)" role="tab" aria-controls="ex4" title="Alt+4">
      <span class="tab-chip">04</span>
      <span data-i18n="nav-ex4">Code Source</span>
    </button>
  </div>
</nav>
<!-- /HEADER -->
