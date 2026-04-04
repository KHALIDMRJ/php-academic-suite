<?php
/**
 * FPK — Exercise 4: Project Architecture & Source Code Panel
 */

require_once __DIR__ . '/../includes/functions.php';
?>

<section class="panel" id="ex4" role="tabpanel" aria-labelledby="tab-ex4">
  <div class="section-header">
    <div class="section-eyebrow">Projet · Structure modulaire PHP</div>
    <h2 class="section-title" data-i18n="section-title-4">Architecture du Projet</h2>
    <p class="section-desc" data-i18n="section-desc-4">
      Structure modulaire, séparation des responsabilités, fonctions réutilisables et extraits de code annotés.
    </p>
  </div>

  <!-- File Tree -->
  <div class="card mb-lg">
    <div class="card-header">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 2h4l2 2h4v8H2V2z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/></svg>
      Structure du projet
    </div>
    <div class="card-body">
<pre class="file-tree" role="tree" aria-label="Project file structure"><span class="tree-dir">fpk-php/</span>
├── <span class="tree-main">index.php</span>                 <span class="tree-note">← Point d'entrée principal</span>
│
├── <span class="tree-dir">includes/</span>
│   ├── <span class="tree-main">functions.php</span>         <span class="tree-note">← Fonctions réutilisables + helpers HTML</span>
│   ├── <span class="tree-file">header.php</span>            <span class="tree-note">← En-tête + navigation (sticky)</span>
│   └── <span class="tree-file">footer.php</span>            <span class="tree-note">← Pied de page + scripts JS</span>
│
├── <span class="tree-dir">exercises/</span>
│   ├── <span class="tree-file">ex1_etudiant.php</span>      <span class="tree-note">← Exercices 1 &amp; 2 (étudiant, boucles)</span>
│   ├── <span class="tree-file">ex2_patterns.php</span>      <span class="tree-note">← Exercice 3 (patterns, multiplication)</span>
│   ├── <span class="tree-file">ex3_fibonacci.php</span>     <span class="tree-note">← Exercice 4 (suite de Fibonacci)</span>
│   └── <span class="tree-file">ex4_architecture.php</span>  <span class="tree-note">← Panel architecture &amp; code source</span>
│
└── <span class="tree-dir">assets/</span>
    ├── <span class="tree-dir">css/</span>
    │   └── <span class="tree-file">main.css</span>          <span class="tree-note">← Variables CSS, thème, composants</span>
    └── <span class="tree-dir">js/</span>
        └── <span class="tree-file">main.js</span>           <span class="tree-note">← Navigation, validation, i18n, animations</span></pre>
    </div>
  </div>

  <!-- Feature Matrix -->
  <div class="card mb-lg">
    <div class="card-header">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.2"/><path d="M4 7l2 2 4-4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Fonctionnalités implémentées
    </div>
    <div class="card-body">
      <div class="grid-2">
        <?php
        $features = [
          ['✓', 'Séparation Header/Footer', 'Partials réutilisables inclus via require_once', 'c-jade'],
          ['✓', 'Fonctions réutilisables', 'Bibliothèque functions.php — sanitize, validate, render', 'c-jade'],
          ['✓', 'Validation & Sanitisation', 'XSS prevention, range checks, required fields', 'c-jade'],
          ['✓', 'Gestion de session', 'Flash messages, persistance des formulaires', 'c-jade'],
          ['✓', 'Architecture modulaire', 'Exercises séparés, includes, assets organisés', 'c-jade'],
          ['✓', 'CSS professionnel', 'Variables CSS, animations, responsive, dark theme', 'c-jade'],
          ['✓', 'JavaScript interactif', 'Tabs, validation client, i18n, stagger animations', 'c-jade'],
          ['✓', 'Bilingue FR/EN', 'Système de traduction JS avec localStorage', 'c-jade'],
          ['✓', 'Accessibilité', 'ARIA roles, labels, keyboard navigation (Alt+1-4)', 'c-jade'],
          ['✓', 'Code source annoté', 'Docblocks PHPDoc, commentaires inline', 'c-jade'],
        ];
        foreach ($features as [$icon, $title, $desc, $col]):
        ?>
        <div class="stat-card" style="display:flex; gap:12px; align-items:flex-start;">
          <span class="<?= $col ?>" style="font-size:14px; flex-shrink:0; margin-top:1px;"><?= $icon ?></span>
          <div>
            <div style="font-size:13px; font-weight:600; margin-bottom:2px;"><?= $title ?></div>
            <div style="font-size:12px; color:var(--text-muted);"><?= $desc ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- PHP Concepts -->
  <div class="divider-label"><span>Concepts PHP couverts</span></div>
  <div class="concept-cloud mb-lg">
    <?php
    $concepts = [
      '$_POST & formulaires', 'define() constantes', 'match() expression',
      'htmlspecialchars()', 'session_start()', '$_SESSION', 'require_once',
      'Conditions if/elseif', 'switch/case', 'Boucle for', 'Boucle while',
      'Boucle foreach', 'Tableaux indexés', 'Fonctions typées', 'PHPDoc',
      'Opérateur modulo %', 'Algorithme itératif',
      'Récursivité (commentée)', 'array_filter()', 'array_sum()', 'array_map()',
      'range()', 'count()', 'str_repeat()', 'round()', 'end()', 'compact()',
    ];
    foreach ($concepts as $c):
    ?>
    <span class="concept-tag"><?= htmlspecialchars($c) ?></span>
    <?php endforeach; ?>
  </div>

  <!-- Sample functions.php extract -->
  <div class="divider-label"><span>Extrait — includes/functions.php</span></div>
  <div class="code-block">
    <div class="code-header">
      <div class="code-dots"><span class="code-dot"></span><span class="code-dot"></span><span class="code-dot"></span></div>
      <span class="code-lang">PHP — Fonctions typées (PHP 8)</span>
      <button class="btn-ghost" style="padding:4px 10px;font-size:11px;" onclick="copyCode(this)">Copy</button>
    </div>
<pre class="code-body"><span class="token-cmt">/**
 * Get academic mention from average.
 *
 * @param  float $moyenne
 * @return array {mention, classe, message, icon, color}
 */</span>
<span class="token-kw">function</span> <span class="token-fn">getMention</span>(<span class="token-fn">float</span> <span class="token-var">$moyenne</span>): <span class="token-fn">array</span>
{
    <span class="token-kw">return</span> <span class="token-fn">match</span>(<span class="token-kw">true</span>) {
        <span class="token-var">$moyenne</span> &gt;= <span class="token-num">16</span> <span class="token-op">=&gt;</span> [<span class="token-str">'mention'</span> <span class="token-op">=&gt;</span> <span class="token-str">'Excellente'</span>, <span class="token-str">'icon'</span> <span class="token-op">=&gt;</span> <span class="token-str">'🏆'</span>, <span class="token-str">'classe'</span> <span class="token-op">=&gt;</span> <span class="token-str">'excellent'</span>],
        <span class="token-var">$moyenne</span> &gt;= <span class="token-num">14</span> <span class="token-op">=&gt;</span> [<span class="token-str">'mention'</span> <span class="token-op">=&gt;</span> <span class="token-str">'Bien'</span>,       <span class="token-str">'icon'</span> <span class="token-op">=&gt;</span> <span class="token-str">'⭐'</span>, <span class="token-str">'classe'</span> <span class="token-op">=&gt;</span> <span class="token-str">'bien'</span>      ],
        <span class="token-var">$moyenne</span> &gt;= <span class="token-num">12</span> <span class="token-op">=&gt;</span> [<span class="token-str">'mention'</span> <span class="token-op">=&gt;</span> <span class="token-str">'Assez bien'</span>, <span class="token-str">'icon'</span> <span class="token-op">=&gt;</span> <span class="token-str">'👍'</span>, <span class="token-str">'classe'</span> <span class="token-op">=&gt;</span> <span class="token-str">'assez'</span>     ],
        <span class="token-var">$moyenne</span> &gt;= <span class="token-num">10</span> <span class="token-op">=&gt;</span> [<span class="token-str">'mention'</span> <span class="token-op">=&gt;</span> <span class="token-str">'Passable'</span>,   <span class="token-str">'icon'</span> <span class="token-op">=&gt;</span> <span class="token-str">'📘'</span>, <span class="token-str">'classe'</span> <span class="token-op">=&gt;</span> <span class="token-str">'passable'</span>  ],
        <span class="token-kw">default</span>         <span class="token-op">=&gt;</span> [<span class="token-str">'mention'</span> <span class="token-op">=&gt;</span> <span class="token-str">'Échec'</span>,      <span class="token-str">'icon'</span> <span class="token-op">=&gt;</span> <span class="token-str">'📉'</span>, <span class="token-str">'classe'</span> <span class="token-op">=&gt;</span> <span class="token-str">'echec'</span>     ],
    };
}

<span class="token-cmt">// ── Session flash helper ─────────────────────────────</span>
<span class="token-kw">function</span> <span class="token-fn">setFlash</span>(<span class="token-fn">string</span> <span class="token-var">$message</span>, <span class="token-fn">string</span> <span class="token-var">$type</span> = <span class="token-str">'success'</span>): <span class="token-fn">void</span>
{
    <span class="token-fn">startSession</span>();
    <span class="token-var">$_SESSION</span>[<span class="token-str">'flash'</span>] = [<span class="token-str">'msg'</span> <span class="token-op">=&gt;</span> <span class="token-var">$message</span>, <span class="token-str">'type'</span> <span class="token-op">=&gt;</span> <span class="token-var">$type</span>];
}</pre>
  </div>

</section>
