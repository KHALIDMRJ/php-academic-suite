<?php
/**
 * FPK — Exercice 3 : Patterns & Table de multiplication
 *
 * Covers: nested for loops, pattern generation, multiplication table,
 * even numbers, Gaussian sum formula, parity check.
 */

require_once __DIR__ . '/../includes/functions.php';
startSession();

$errors = [];
$result = null;
$prev   = getFromSession('pattern');

if (isset($_POST['valider2'])) {

    $errors = validateRequired([
        'entier'  => 'Entier N',
        'hauteur' => 'Hauteur',
    ]);

    if (!isset($errors['entier'])) {
        $e = validateRange('entier', 0, 999, 'Entier N');
        if ($e) $errors['entier'] = $e;
    }
    if (!isset($errors['hauteur'])) {
        $e = validateRange('hauteur', 1, 20, 'Hauteur');
        if ($e) $errors['hauteur'] = $e;
    }

    if (empty($errors)) {
        $entier  = sanitizeInt('entier',  0, 0, 999);
        $hauteur = sanitizeInt('hauteur', 1, 1,  20);

        $triangle = genererTriangle($hauteur);
        $carre    = genererCarre($hauteur);
        $table    = tableMultiplication($entier);
        $pairs    = array_values(array_filter(range(0, $entier), fn($x) => $x > 0 && $x % 2 === 0));
        $somme    = sommeTo($entier);
        $paire    = estPair($entier);

        $result = compact('entier','hauteur','triangle','carre','table','pairs','somme','paire');
        saveToSession('pattern', $result);
        setFlash("Patterns générés — N = {$entier}, hauteur = {$hauteur} ✓", 'success');
    }

} elseif ($prev) {
    $result = $prev;
}
?>

<section class="panel" id="ex2" role="tabpanel">
  <div class="section-header">
    <div class="section-eyebrow">Exercice 03 · Boucles imbriquées &amp; Algorithmes</div>
    <h2 class="section-title" data-i18n="section-title-2">Patterns &amp; Multiplication</h2>
    <p class="section-desc" data-i18n="section-desc-2">
      Table de multiplication, triangles d'étoiles centrés, carré, nombres pairs et somme de Gauss.
    </p>
  </div>

  <?php if (!empty($errors)): ?>
    <?php renderAlert(implode(' &nbsp;·&nbsp; ', $errors), 'error'); ?>
  <?php endif; ?>

  <!-- ═══ FORM ═══ -->
  <div class="card mb-lg">
    <div class="card-header">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
        <path d="M1 7h12M7 1v12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Paramètres de génération
    </div>
    <div class="card-body">
      <form method="POST" action="" novalidate>
        <div class="form-grid" style="max-width:500px;">

          <div class="field">
            <label class="field-label" for="entier">
              <span data-i18n="label-entier">Entier N</span>
              <span class="required" aria-hidden="true">*</span>
            </label>
            <input class="field-input <?= isset($errors['entier']) ? 'error' : '' ?>"
              type="number" name="entier" id="entier"
              placeholder="ex : 7" min="0" max="999" required
              value="<?= htmlspecialchars((string)($_POST['entier'] ?? $result['entier'] ?? '')) ?>"
              aria-describedby="entier-err">
            <span class="field-hint">Pour la table ×, pairs, somme</span>
            <span class="field-error <?= isset($errors['entier']) ? 'show' : '' ?>"
              id="entier-err" role="alert"><?= $errors['entier'] ?? '' ?></span>
          </div>

          <div class="field">
            <label class="field-label" for="hauteur">
              <span data-i18n="label-hauteur">Hauteur du pattern</span>
              <span class="required" aria-hidden="true">*</span>
            </label>
            <input class="field-input <?= isset($errors['hauteur']) ? 'error' : '' ?>"
              type="number" name="hauteur" id="hauteur"
              placeholder="ex : 5" min="1" max="20" required
              value="<?= htmlspecialchars((string)($_POST['hauteur'] ?? $result['hauteur'] ?? '')) ?>"
              aria-describedby="hauteur-err">
            <span class="field-hint">Taille triangle &amp; carré (1–20)</span>
            <span class="field-error <?= isset($errors['hauteur']) ? 'show' : '' ?>"
              id="hauteur-err" role="alert"><?= $errors['hauteur'] ?? '' ?></span>
          </div>

        </div>
        <button type="submit" name="valider2" class="btn btn-primary">
          <svg class="btn-icon" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <rect x="1" y="1" width="14" height="14" rx="3" stroke="currentColor" stroke-width="1.5"/>
            <path d="M5 8h6M8 5v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
          <span data-i18n="btn-gen">Générer</span>
        </button>
      </form>
    </div>
  </div>

  <!-- ═══ RESULTS ═══ -->
  <?php if ($result): ?>
  <div id="result2" class="card">
    <div class="card-header">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true">
        <circle cx="7" cy="7" r="3"/>
        <circle cx="7" cy="7" r="6.5" stroke="currentColor" stroke-width="1" fill="none" opacity=".3"/>
      </svg>
      Résultats — N = <?= (int)$result['entier'] ?>, Hauteur = <?= (int)$result['hauteur'] ?>
    </div>
    <div class="card-body">

      <!-- ── Patterns side by side ── -->
      <div class="divider-label"><span>Patterns géométriques</span></div>
      <div class="grid-2 mb-lg">

        <div>
          <div class="pattern-label">▲ Triangle — Hauteur <?= (int)$result['hauteur'] ?></div>
<pre class="pattern-display" role="img" aria-label="Triangle centré de <?= (int)$result['hauteur'] ?> lignes"><?php
foreach ($result['triangle'] as $row) {
    echo htmlspecialchars($row) . "\n";
}
?></pre>
        </div>

        <div>
          <div class="pattern-label">■ Carré — <?= (int)$result['hauteur'] ?>×<?= (int)$result['hauteur'] ?></div>
<pre class="pattern-display" role="img" aria-label="Carré de <?= (int)$result['hauteur'] ?> lignes"><?php
foreach ($result['carre'] as $row) {
    echo htmlspecialchars($row) . "\n";
}
?></pre>
        </div>

      </div>

      <!-- ── Summary stats ── -->
      <div class="stat-grid mb-lg">
        <?php
        renderStatCard('Somme 1→' . $result['entier'], (string)$result['somme'],  'c-jade',   'N×(N+1)/2');
        renderStatCard('Parité',  $result['paire'] ? 'Pair' : 'Impair',           $result['paire'] ? 'c-jade' : 'c-violet');
        renderStatCard('Pairs trouvés', count($result['pairs']) . ' nombres',     'c-amber');
        renderStatCard('Table ×', '1 → 10', 'c-sky');
        ?>
      </div>

      <!-- ── Multiplication table ── -->
      <div class="divider-label"><span>Table de multiplication — <?= (int)$result['entier'] ?></span></div>
      <div class="card mb-lg" style="padding:0;">
        <table class="mult-table" aria-label="Table de multiplication de <?= (int)$result['entier'] ?>">
          <?php foreach ($result['table'] as [$n, $i, $res]): ?>
          <tr>
            <td><?= $n ?> &times; <?= $i ?></td>
            <td>=</td>
            <td><?= $res ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>

      <!-- ── Even numbers ── -->
      <div class="divider-label"><span>Nombres pairs entre 1 et <?= (int)$result['entier'] ?></span></div>
      <div class="number-strip">
        <?php if (empty($result['pairs'])): ?>
          <span style="color:var(--text-ghost);">Aucun nombre pair dans cet intervalle.</span>
        <?php else: ?>
          <?php foreach ($result['pairs'] as $idx => $p): ?>
            <span class="ns-num ns-even"><?= $p ?></span><?php
            if ($idx < count($result['pairs']) - 1) echo '<span class="ns-sep">,</span> ';
          endforeach; ?>
        <?php endif; ?>
      </div>

    </div>
  </div>
  <?php endif; ?>

</section>
