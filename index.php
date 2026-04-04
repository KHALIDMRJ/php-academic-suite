<?php
/**
 * FPK PHP Exercices — index.php
 * Main entry point — assembles all modules.
 *
 * @package  FPK-Exercices
 * @version  2.0.0
 */

// Handle POST redirects to restore active tab
$activePanelOnLoad = 'ex1';
if (isset($_GET['tab'])) {
    $allowed = ['ex1', 'ex2', 'ex3', 'ex4'];
    $tab = $_GET['tab'];
    if (in_array($tab, $allowed, true)) {
        $activePanelOnLoad = $tab;
    }
}

// ── Include header (starts session, loads CSS, renders <header> + <nav>) ──
require_once __DIR__ . '/includes/header.php';
?>

<!-- ══════════════════════════════════════════════════
     MAIN CONTENT
     ══════════════════════════════════════════════════ -->
<main class="site-main" role="main">
  <div class="container">

    <!-- Exercise Panels — each is a <section class="panel"> -->
    <?php require_once __DIR__ . '/exercises/ex1_etudiant.php'; ?>
    <?php require_once __DIR__ . '/exercises/ex2_patterns.php'; ?>
    <?php require_once __DIR__ . '/exercises/ex3_fibonacci.php'; ?>
    <?php require_once __DIR__ . '/exercises/ex4_architecture.php'; ?>

  </div>
</main>

<!-- ── Include footer (renders <footer>, loads JS) ── -->
<?php require_once __DIR__ . '/includes/footer.php'; ?>
