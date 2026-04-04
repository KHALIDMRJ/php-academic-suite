<?php
/**
 * FPK — Site Footer
 * Included at the bottom of every page.
 */
?>

<!-- ══════════════════════════════════════════════════
     SITE FOOTER
     ══════════════════════════════════════════════════ -->
<footer class="site-footer" role="contentinfo">
  <div class="footer-inner">
    <div class="footer-copy">
      &copy; <?= date('Y') ?> &nbsp;·&nbsp;
      <span style="color:var(--jade);">FPK</span>
      &nbsp;·&nbsp; Travaux Pratiques PHP
      &nbsp;·&nbsp; <span class="text-mono" style="font-size:11px;">PHP <?= PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION ?></span>
    </div>
    <nav class="footer-links" aria-label="Footer links">
      <a class="footer-link" href="https://www.php.net/docs.php" target="_blank" rel="noopener">PHP Docs</a>
      <a class="footer-link" href="https://github.com/" target="_blank" rel="noopener">GitHub</a>
      <a class="footer-link" href="#" onclick="switchTab('ex4', document.querySelector('[onclick*=ex4]'))">Architecture</a>
    </nav>
  </div>
</footer>

<script src="assets/js/main.js"></script>
</body>
</html>
