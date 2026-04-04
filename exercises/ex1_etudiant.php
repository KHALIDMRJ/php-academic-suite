<?php
/**
 * FPK — Exercice 1 & 2 : Gestion d'un étudiant
 *
 * Covers: define(), sanitization, validation, moyenne,
 * getMention(), estAdmis(), estMajeur(), for/while/foreach loops,
 * session persistence, flash messages.
 */

require_once __DIR__ . '/../includes/functions.php';
startSession();

$errors = [];
$result = null;
$prev   = getFromSession('etudiant'); // restore previous result from session

// ── DEFINE constant (only once, safely) ──────────────────────
if (!defined('ETABLISSEMENT')) {
    define('ETABLISSEMENT', 'FPK');
}

// ── FORM PROCESSING ──────────────────────────────────────────
if (isset($_POST['valider1'])) {

    // 1. Required-field check
    $errors = validateRequired([
        'nom'    => 'Nom',
        'prenom' => 'Prénom',
        'Age'    => 'Âge',
        'Note1'  => 'Note PHP',
        'Note2'  => 'Note HTML',
        'Note3'  => 'Note CSS',
    ]);

    // 2. Numeric range checks
    foreach ([
        ['Age',   0, 120, 'Âge'],
        ['Note1', 0,  20, 'Note PHP'],
        ['Note2', 0,  20, 'Note HTML'],
        ['Note3', 0,  20, 'Note CSS'],
    ] as [$key, $min, $max, $label]) {
        $rangeErr = validateRange($key, $min, $max, $label);
        if ($rangeErr && !isset($errors[$key])) {
            $errors[$key] = $rangeErr;
        }
    }

    // 3. Compute results if valid
    if (empty($errors)) {
        $nom    = sanitizeString('nom');
        $prenom = sanitizeString('prenom');
        $age    = sanitizeInt('Age',   0, 0, 120);
        $note1  = sanitizeFloat('Note1', 0.0, 0, 20);
        $note2  = sanitizeFloat('Note2', 0.0, 0, 20);
        $note3  = sanitizeFloat('Note3', 0.0, 0, 20);
        $notes  = [$note1, $note2, $note3];

        $moyenne = calculerMoyenne($notes);
        $somme   = $note1 + $note2 + $note3;
        $mention = getMention($moyenne);
        $admis   = estAdmis($moyenne);
        $majeur  = estMajeur($age);

        $result = compact(
            'nom','prenom','age',
            'note1','note2','note3','notes',
            'moyenne','somme','mention','admis','majeur'
        );

        saveToSession('etudiant', $result);
        setFlash("Résultats calculés pour {$prenom} {$nom} ✓", 'success');
    }

} elseif ($prev) {
    // Restore last valid result from session
    $result = $prev;
}

$matieres  = ['PHP', 'HTML', 'CSS'];
$barColors = ['bar-fill-jade', 'bar-fill-violet', 'bar-fill-amber'];
?>

<section class="panel" id="ex1" role="tabpanel">
  <div class="section-header">
    <div class="section-eyebrow">Exercice 01–02 · Formulaire &amp; Structures de contrôle</div>
    <h2 class="section-title" data-i18n="section-title-1">Gestion d'un Étudiant</h2>
    <p class="section-desc" data-i18n="section-desc-1">
      Saisie des informations, calcul de la moyenne, mention académique et démonstration des trois types de boucles PHP.
    </p>
  </div>

  <?php if (!empty($errors)): ?>
    <?php renderAlert(implode(' &nbsp;·&nbsp; ', $errors), 'error'); ?>
  <?php endif; ?>

  <!-- ═══ FORM ═══ -->
  <div class="card mb-lg">
    <div class="card-header">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
        <path d="M7 1a6 6 0 110 12A6 6 0 017 1z" stroke="currentColor" stroke-width="1.5"/>
        <path d="M7 4v3l2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Informations de l'étudiant
    </div>
    <div class="card-body">
      <form method="POST" action="" novalidate>

        <div class="form-grid">
          <?php foreach ([
            ['nom',    'label-nom',    'Nom',    'Alaoui',  'family-name'],
            ['prenom', 'label-prenom', 'Prénom', 'Yassine', 'given-name'],
          ] as [$fname, $i18n, $label, $ph, $ac]):
            $fval = htmlspecialchars($_POST[$fname] ?? $result[$fname] ?? '');
          ?>
          <div class="field">
            <label class="field-label" for="<?= $fname ?>">
              <span data-i18n="<?= $i18n ?>"><?= $label ?></span>
              <span class="required" aria-hidden="true">*</span>
            </label>
            <input class="field-input <?= isset($errors[$fname]) ? 'error' : '' ?>"
              type="text" name="<?= $fname ?>" id="<?= $fname ?>"
              placeholder="ex : <?= $ph ?>" required autocomplete="<?= $ac ?>"
              value="<?= $fval ?>" aria-describedby="<?= $fname ?>-err">
            <span class="field-error <?= isset($errors[$fname]) ? 'show' : '' ?>"
              id="<?= $fname ?>-err" role="alert"><?= $errors[$fname] ?? '' ?></span>
          </div>
          <?php endforeach; ?>

          <div class="field">
            <label class="field-label" for="Age">
              <span data-i18n="label-age">Âge</span>
              <span class="required" aria-hidden="true">*</span>
            </label>
            <input class="field-input <?= isset($errors['Age']) ? 'error' : '' ?>"
              type="number" name="Age" id="Age"
              placeholder="ex : 20" min="0" max="120" required
              value="<?= htmlspecialchars((string)($_POST['Age'] ?? $result['age'] ?? '')) ?>"
              aria-describedby="Age-err">
            <span class="field-hint">0 – 120 ans</span>
            <span class="field-error <?= isset($errors['Age']) ? 'show' : '' ?>"
              id="Age-err" role="alert"><?= $errors['Age'] ?? '' ?></span>
          </div>
        </div>

        <div class="divider-label"><span>Notes par matière (sur 20)</span></div>

        <div class="form-grid">
          <?php foreach ([
            ['Note1', 'label-note1', 'Note PHP',  'note1'],
            ['Note2', 'label-note2', 'Note HTML', 'note2'],
            ['Note3', 'label-note3', 'Note CSS',  'note3'],
          ] as [$fname, $i18n, $label, $rkey]):
            $fval = htmlspecialchars((string)($_POST[$fname] ?? $result[$rkey] ?? ''));
          ?>
          <div class="field">
            <label class="field-label" for="<?= $fname ?>">
              <span data-i18n="<?= $i18n ?>"><?= $label ?></span>
              <span class="required" aria-hidden="true">*</span>
            </label>
            <input class="field-input <?= isset($errors[$fname]) ? 'error' : '' ?>"
              type="number" name="<?= $fname ?>" id="<?= $fname ?>"
              placeholder="0 – 20" min="0" max="20" step="0.5" required
              value="<?= $fval ?>" aria-describedby="<?= $fname ?>-err">
            <span class="field-error <?= isset($errors[$fname]) ? 'show' : '' ?>"
              id="<?= $fname ?>-err" role="alert"><?= $errors[$fname] ?? '' ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <button type="submit" name="valider1" class="btn btn-primary">
          <svg class="btn-icon" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span data-i18n="btn-calc">Calculer les résultats</span>
        </button>

      </form>
    </div>
  </div>

  <!-- ═══ RESULTS ═══ -->
  <?php if ($result): ?>
  <div id="result" class="card">
    <div class="card-header">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true">
        <circle cx="7" cy="7" r="3"/>
        <circle cx="7" cy="7" r="6.5" stroke="currentColor" stroke-width="1" fill="none" opacity=".3"/>
      </svg>
      Résultats — <?= htmlspecialchars($result['prenom'] . ' ' . $result['nom']) ?>
      <?php if (isset($_SESSION['forms']['etudiant']['timestamp'])): ?>
        <span style="margin-left:auto;font-size:11px;color:var(--text-ghost);font-family:var(--font-mono);">
          calculé à <?= $_SESSION['forms']['etudiant']['timestamp'] ?>
        </span>
      <?php endif; ?>
    </div>
    <div class="card-body">

      <!-- Stat cards -->
      <div class="stat-grid mb-lg">
        <?php
        renderStatCard('Moyenne',         $result['moyenne'] . ' / 20', 'c-jade');
        renderStatCard('Somme totale',    $result['somme']   . ' / 60', 'c-violet');
        renderStatCard('Âge',             $result['age']     . ' ans',  'c-sky');
        renderStatCard('Établissement',   ETABLISSEMENT,                'c-amber');
        ?>
      </div>

      <!-- Mention hero -->
      <?php $m = $result['mention']; ?>
      <div class="mention-hero <?= $m['classe'] ?>">
        <div class="mention-icon" aria-hidden="true"><?= $m['icon'] ?></div>
        <div>
          <div class="mention-name" style="color:<?= $m['color'] ?>"><?= htmlspecialchars($m['mention']) ?></div>
          <div class="mention-msg"><?= htmlspecialchars($m['message']) ?></div>
        </div>
        <div style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
          <span class="pill <?= $result['admis'] ? 'pill-jade' : 'pill-rose' ?>">
            <?= $result['admis'] ? '✓ Admis' : '✗ Non admis' ?>
          </span>
          <span class="pill <?= $result['majeur'] ? 'pill-sky' : 'pill-violet' ?>">
            <?= $result['majeur'] ? 'Majeur' : 'Mineur' ?>
          </span>
        </div>
      </div>

      <!-- Note bars -->
      <div class="divider-label"><span>Notes par matière</span></div>
      <div class="notes-list mb-lg">
        <?php foreach ($matieres as $i => $matiere): ?>
          <?php renderNoteBar($matiere, $result['notes'][$i], 20, $barColors[$i]); ?>
        <?php endforeach; ?>
      </div>

      <!-- Progress ring -->
      <div class="divider-label"><span>Progression vers la moyenne maximale</span></div>
      <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;margin-bottom:1.75rem;">
        <div class="progress-ring-wrapper" role="img" aria-label="Moyenne <?= $result['moyenne'] ?> sur 20">
          <svg class="progress-ring" width="80" height="80" viewBox="0 0 80 80">
            <circle class="progress-ring-bg"   cx="40" cy="40" r="34"/>
            <circle class="progress-ring-fill" cx="40" cy="40" r="34"
              data-pct="<?= round(($result['moyenne'] / 20) * 100) ?>"/>
          </svg>
          <div class="ring-label">
            <span class="ring-num"><?= $result['moyenne'] ?></span>
            <span class="ring-unit">/20</span>
          </div>
        </div>
        <div>
          <p style="font-size:13px;color:var(--text-secondary);margin-bottom:6px;">
            Taux de réussite :
            <strong style="color:var(--jade);"><?= round(($result['moyenne'] / 20) * 100) ?>%</strong>
          </p>
          <p style="font-size:13px;color:var(--text-secondary);">
            Points manquants pour <em>Excellente</em> :
            <strong style="color:var(--amber);"><?= max(0, round(16 - $result['moyenne'], 2)) ?> pts</strong>
          </p>
        </div>
      </div>

      <!-- ─── LOOP DEMONSTRATION ─── -->
      <div class="divider-label"><span>Démonstration des boucles PHP</span></div>
      <?php
        $n1 = $result['note1'];
        $n2 = $result['note2'];
        $n3 = $result['note3'];
      ?>
      <div class="code-block">
        <div class="code-header">
          <div class="code-dots">
            <span class="code-dot"></span><span class="code-dot"></span><span class="code-dot"></span>
          </div>
          <span class="code-lang">PHP — Les 3 types de boucles</span>
          <button class="btn-copy" onclick="copyCode(this)" aria-label="Copier le code">Copy</button>
        </div>
<pre class="code-body"><span class="token-cmt">// ── Données ──────────────────────────────────────────────────────</span>
<span class="token-var">$notes</span>    = [<span class="token-num"><?= $n1 ?></span>, <span class="token-num"><?= $n2 ?></span>, <span class="token-num"><?= $n3 ?></span>];
<span class="token-var">$matieres</span> = [<span class="token-str">"PHP"</span>, <span class="token-str">"HTML"</span>, <span class="token-str">"CSS"</span>];

<span class="token-cmt">// ── Boucle for ───────────────────────────────────────────────────</span>
<span class="token-kw">for</span> (<span class="token-var">$i</span> = <span class="token-num">0</span>; <span class="token-var">$i</span> &lt; <span class="token-fn">count</span>(<span class="token-var">$notes</span>); <span class="token-var">$i</span>++) {
    <span class="token-fn">echo</span> <span class="token-str">"Note "</span> . <span class="token-var">$matieres</span>[<span class="token-var">$i</span>] . <span class="token-str">" : "</span> . <span class="token-var">$notes</span>[<span class="token-var">$i</span>] . <span class="token-str">"\n"</span>;
}
<span class="token-cmt">// → Note PHP : <?= $n1 ?>  |  Note HTML : <?= $n2 ?>  |  Note CSS : <?= $n3 ?></span>

<span class="token-cmt">// ── Boucle while ─────────────────────────────────────────────────</span>
<span class="token-var">$i</span> = <span class="token-num">0</span>;
<span class="token-kw">while</span> (<span class="token-var">$i</span> &lt; <span class="token-fn">count</span>(<span class="token-var">$notes</span>)) {
    <span class="token-fn">echo</span> <span class="token-str">"Note_"</span> . (<span class="token-var">$i</span> + <span class="token-num">1</span>) . <span class="token-str">" : "</span> . <span class="token-var">$notes</span>[<span class="token-var">$i</span>] . <span class="token-str">"\n"</span>;
    <span class="token-var">$i</span>++;
}

<span class="token-cmt">// ── Boucle foreach ───────────────────────────────────────────────</span>
<span class="token-kw">foreach</span> (<span class="token-var">$notes</span> <span class="token-kw">as</span> <span class="token-var">$index</span> =&gt; <span class="token-var">$note</span>) {
    <span class="token-fn">echo</span> <span class="token-var">$matieres</span>[<span class="token-var">$index</span>] . <span class="token-str">" : "</span> . <span class="token-var">$note</span> . <span class="token-str">"\n"</span>;
}</pre>
      </div>

      <!-- Natural number sequence -->
      <div class="divider-label"><span>Entiers naturels de 0 à <?= $result['age'] ?></span></div>
      <div class="number-strip">
        <?php for ($i = 0; $i <= $result['age']; $i++): ?>
          <span class="ns-num <?= $i % 2 === 0 ? 'ns-even' : 'ns-odd' ?>"><?= $i ?></span><?php
          if ($i < $result['age']) echo '<span class="ns-sep">,</span> ';
        endfor; ?>
      </div>

    </div><!-- /card-body -->
  </div><!-- /result card -->
  <?php endif; ?>

</section>
