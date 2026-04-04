<?php
/**
 * FPK — Exercise 4: Fibonacci Sequence
 * Iterative method, O(n) complexity, 100 terms.
 */

require_once __DIR__ . '/../includes/functions.php';

$fib  = generateFibonacci(100);
$last = end($fib);
?>

<section class="panel" id="ex3" role="tabpanel" aria-labelledby="tab-ex3">
  <div class="section-header">
    <div class="section-eyebrow">Exercice 04 · Algorithme itératif — O(n)</div>
    <h2 class="section-title" data-i18n="section-title-3">Suite de Fibonacci</h2>
    <p class="section-desc" data-i18n="section-desc-3">
      Les 100 premiers termes de la suite (F&#8320; &#x2192; F&#8329;&#8329;) calculés par méthode itérative optimale. Complexité temporelle O(n).
    </p>
  </div>

  <!-- Overview Stats -->
  <div class="stat-grid mb-lg">
    <?php renderStatCard('Termes calculés', '100', 'c-jade', 'F₀ → F₉₉'); ?>
    <?php renderStatCard('F₀ (premier)', '0', 'c-sky'); ?>
    <?php renderStatCard('F₁₀', (string)$fib[10], 'c-violet', 'F₁₀ = 55'); ?>
    <?php renderStatCard('Complexité', 'O(n)', 'c-amber', 'Itératif'); ?>
  </div>

  <!-- Algorithm Pseudocode -->
  <div class="code-block mb-lg">
    <div class="code-header">
      <div class="code-dots"><span class="code-dot"></span><span class="code-dot"></span><span class="code-dot"></span></div>
      <span class="code-lang">Pseudo-code — Algorithme Fibonacci_100</span>
      <button class="btn-ghost" style="padding:4px 10px;font-size:11px;" onclick="copyCode(this)">Copy</button>
    </div>
<pre class="code-body"><span class="token-kw">Algorithme</span> Fibonacci_100

<span class="token-kw">Variables :</span>
    <span class="token-fn">entier</span> i
    <span class="token-fn">entier</span> F_precedent, F_courant, F_suivant

<span class="token-kw">Début</span>
    F_precedent <span class="token-op">←</span> <span class="token-num">0</span>
    F_courant   <span class="token-op">←</span> <span class="token-num">1</span>

    <span class="token-fn">Afficher</span> <span class="token-str">"F0 = "</span>, F_precedent
    <span class="token-fn">Afficher</span> <span class="token-str">"F1 = "</span>, F_courant

    <span class="token-kw">Pour</span> i <span class="token-kw">allant de</span> <span class="token-num">2</span> <span class="token-kw">à</span> <span class="token-num">99</span> <span class="token-kw">faire</span>

        F_suivant   <span class="token-op">←</span> F_precedent <span class="token-op">+</span> F_courant

        <span class="token-fn">Afficher</span> <span class="token-str">"F"</span>, i, <span class="token-str">" = "</span>, F_suivant

        F_precedent <span class="token-op">←</span> F_courant
        F_courant   <span class="token-op">←</span> F_suivant

    <span class="token-kw">Fin Pour</span>
<span class="token-kw">Fin</span></pre>
  </div>

  <!-- PHP Implementation -->
  <div class="code-block mb-lg">
    <div class="code-header">
      <div class="code-dots"><span class="code-dot"></span><span class="code-dot"></span><span class="code-dot"></span></div>
      <span class="code-lang">PHP — Implémentation itérative</span>
      <button class="btn-ghost" style="padding:4px 10px;font-size:11px;" onclick="copyCode(this)">Copy</button>
    </div>
<pre class="code-body"><span class="token-var">$f0</span> = <span class="token-num">0</span>;
<span class="token-var">$f1</span> = <span class="token-num">1</span>;

<span class="token-fn">echo</span> <span class="token-str">"F0 = <span class="token-var">$f0</span>"</span>;
<span class="token-fn">echo</span> <span class="token-str">"F1 = <span class="token-var">$f1</span>"</span>;

<span class="token-kw">for</span> (<span class="token-var">$i</span> = <span class="token-num">2</span>; <span class="token-var">$i</span> &lt; <span class="token-num">100</span>; <span class="token-var">$i</span>++) {

    <span class="token-var">$fn</span> = <span class="token-var">$f0</span> + <span class="token-var">$f1</span>;

    <span class="token-fn">echo</span> <span class="token-str">"F<span class="token-var">$i</span> = <span class="token-var">$fn</span>"</span>;

    <span class="token-var">$f0</span> = <span class="token-var">$f1</span>;
    <span class="token-var">$f1</span> = <span class="token-var">$fn</span>;
}</pre>
  </div>

  <!-- F99 highlight -->
  <div class="card mb-lg" style="border-color:rgba(82,232,162,0.2); background:rgba(82,232,162,0.03);">
    <div class="card-body" style="display:flex; align-items:flex-start; gap:1.5rem; flex-wrap:wrap;">
      <div>
        <div class="stat-label">F₉₉ — Dernier terme calculé</div>
        <div style="font-family:var(--font-mono); font-size:1rem; color:var(--jade); word-break:break-all; line-height:1.4; margin-top:6px; max-width:500px;">
          <?= number_format($last, 0, ',', ' ') ?>
        </div>
      </div>
      <div style="margin-left:auto;">
        <div class="stat-label">Chiffres</div>
        <div class="stat-value c-amber"><?= strlen((string)$last) ?></div>
      </div>
    </div>
  </div>

  <!-- All 100 Terms Grid -->
  <div class="divider-label"><span>Tous les 100 termes — F₀ à F₉₉</span></div>
  <div class="fib-grid" role="list" aria-label="Séquence de Fibonacci de F0 à F99">
    <?php foreach ($fib as $idx => $val): ?>
    <div class="fib-cell" role="listitem">
      <div class="fib-idx">F<?= $idx ?></div>
      <div class="fib-val"><?= $val ?></div>
    </div>
    <?php endforeach; ?>
  </div>

  <div style="margin-top:1rem; font-size:12px; color:var(--text-ghost); font-family:var(--font-mono); text-align:right;">
    Méthode récursive disponible dans Fibonacci.php (commentée — complexité O(2ⁿ))
  </div>

</section>
