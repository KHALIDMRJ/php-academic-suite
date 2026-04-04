/* ══════════════════════════════════════════════════
   FPK PHP Exercices — main.js  v2.1
   ══════════════════════════════════════════════════ */

'use strict';

// ── TAB NAVIGATION ──────────────────────────────────────────────
function switchTab(id, btn) {
  // Deactivate every panel and tab button
  document.querySelectorAll('.panel').forEach(p => {
    p.classList.remove('active');
  });
  document.querySelectorAll('.nav-tab').forEach(t => {
    t.classList.remove('active');
    t.setAttribute('aria-selected', 'false');
  });

  // Activate the requested panel
  const panel = document.getElementById(id);
  if (panel) panel.classList.add('active');

  // Activate the clicked / matched button
  if (btn) {
    btn.classList.add('active');
    btn.setAttribute('aria-selected', 'true');
  }

  sessionStorage.setItem('fpk_active_tab', id);
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// On load: restore tab from URL param → sessionStorage → default 'ex1'
document.addEventListener('DOMContentLoaded', () => {
  const urlTab   = new URLSearchParams(window.location.search).get('tab');
  const storedTab = sessionStorage.getItem('fpk_active_tab');
  const targetTab = urlTab || storedTab || 'ex1';

  const targetBtn = document.querySelector(`.nav-tab[onclick*="'${targetTab}'"]`);
  switchTab(targetTab, targetBtn);

  // If there's a result block on the page (after form submit), scroll to it smoothly
  const resultEl = document.getElementById('result') || document.getElementById('result2');
  if (resultEl && (document.referrer.includes('index.php') || urlTab)) {
    setTimeout(() => resultEl.scrollIntoView({ behavior: 'smooth', block: 'start' }), 350);
  }
});

// ── LANGUAGE SWITCHER ────────────────────────────────────────────
const i18n = {
  fr: {
    'badge-fpk':        'FPK — Faculté Polydisciplinaire Khouribga',
    'header-subtitle':  'Collection structurée de travaux pratiques PHP — Exercices 1 à 4',
    'nav-ex1':          'Étudiant & Notes',
    'nav-ex2':          'Patterns',
    'nav-ex3':          'Fibonacci',
    'nav-ex4':          'Code Source',
    'label-nom':        'Nom',
    'label-prenom':     'Prénom',
    'label-age':        'Âge',
    'label-note1':      'Note PHP',
    'label-note2':      'Note HTML',
    'label-note3':      'Note CSS',
    'btn-calc':         'Calculer les résultats',
    'label-entier':     'Entier N',
    'label-hauteur':    'Hauteur du pattern',
    'btn-gen':          'Générer',
    'section-title-1':  "Gestion d'un Étudiant",
    'section-desc-1':   'Saisie des informations, calcul de la moyenne, mention académique et boucles PHP.',
    'section-title-2':  'Patterns & Multiplication',
    'section-desc-2':   "Table de multiplication, triangles, carrés, nombres pairs et somme de Gauss.",
    'section-title-3':  'Suite de Fibonacci',
    'section-desc-3':   'Les 100 premiers termes par méthode itérative optimale — O(n).',
    'section-title-4':  'Architecture du Projet',
    'section-desc-4':   'Structure modulaire, concepts couverts et extraits de code annotés.',
  },
  en: {
    'badge-fpk':        'FPK — Polydisciplinary Faculty of Khouribga',
    'header-subtitle':  'Structured PHP practical exercises collection — Exercises 1 to 4',
    'nav-ex1':          'Student & Grades',
    'nav-ex2':          'Patterns',
    'nav-ex3':          'Fibonacci',
    'nav-ex4':          'Source Code',
    'label-nom':        'Last Name',
    'label-prenom':     'First Name',
    'label-age':        'Age',
    'label-note1':      'PHP Grade',
    'label-note2':      'HTML Grade',
    'label-note3':      'CSS Grade',
    'btn-calc':         'Calculate Results',
    'label-entier':     'Integer N',
    'label-hauteur':    'Pattern Height',
    'btn-gen':          'Generate',
    'section-title-1':  'Student Management',
    'section-desc-1':   'Enter student info, compute average, academic grade and PHP loop demos.',
    'section-title-2':  'Patterns & Multiplication',
    'section-desc-2':   'Multiplication tables, star triangles, squares, even numbers and Gaussian sum.',
    'section-title-3':  'Fibonacci Sequence',
    'section-desc-3':   'First 100 terms via optimal iterative algorithm — O(n) complexity.',
    'section-title-4':  'Project Architecture',
    'section-desc-4':   'Modular structure, PHP concepts covered and annotated code excerpts.',
  }
};

let currentLang = localStorage.getItem('fpk_lang') || 'fr';

function switchLang(lang) {
  if (!i18n[lang]) return;
  currentLang = lang;
  localStorage.setItem('fpk_lang', lang);
  document.documentElement.lang = lang;

  // Update all translatable elements
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.dataset.i18n;
    if (i18n[lang][key] !== undefined) el.textContent = i18n[lang][key];
  });

  // Update button aria-pressed states
  document.querySelectorAll('.lang-btn').forEach(btn => {
    const isActive = btn.dataset.lang === lang;
    btn.classList.toggle('active', isActive);
    btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
  });
}

// Apply saved language on load
document.addEventListener('DOMContentLoaded', () => switchLang(currentLang));

// ── CLIENT-SIDE FORM VALIDATION ──────────────────────────────────
function validateField(input) {
  const val  = input.value.trim();
  const name = input.name;
  const errEl = document.getElementById(name + '-err');
  let msg = '';

  if (input.required && val === '') {
    msg = currentLang === 'fr' ? 'Ce champ est requis.' : 'This field is required.';
  } else if (name === 'Age' && val !== '') {
    const n = parseInt(val);
    if (isNaN(n) || n < 0 || n > 120)
      msg = currentLang === 'fr' ? 'Âge invalide (0–120).' : 'Invalid age (0–120).';
  } else if (['Note1','Note2','Note3'].includes(name) && val !== '') {
    const n = parseFloat(val);
    if (isNaN(n) || n < 0 || n > 20)
      msg = currentLang === 'fr' ? 'Note entre 0 et 20.' : 'Grade between 0 and 20.';
  } else if (name === 'hauteur' && val !== '') {
    const n = parseInt(val);
    if (isNaN(n) || n < 1 || n > 20)
      msg = currentLang === 'fr' ? 'Hauteur entre 1 et 20.' : 'Height between 1 and 20.';
  } else if (name === 'entier' && val !== '') {
    const n = parseInt(val);
    if (isNaN(n) || n < 0)
      msg = currentLang === 'fr' ? 'Entier positif requis.' : 'Positive integer required.';
  }

  input.classList.toggle('error', msg !== '');
  input.classList.toggle('valid', msg === '' && val !== '');
  if (errEl) {
    errEl.textContent = msg;
    errEl.classList.toggle('show', msg !== '');
  }
  return msg === '';
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.field-input').forEach(input => {
    input.addEventListener('blur',  () => validateField(input));
    input.addEventListener('input', () => { if (input.classList.contains('error')) validateField(input); });
  });

  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', e => {
      let valid = true;
      form.querySelectorAll('.field-input').forEach(input => {
        if (!validateField(input)) valid = false;
      });
      if (!valid) e.preventDefault();
    });
  });
});

// ── NOTE BAR ANIMATIONS (IntersectionObserver) ───────────────────
document.addEventListener('DOMContentLoaded', () => {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const bar = entry.target;
        bar.style.width = bar.dataset.width + '%';
        observer.unobserve(bar);
      }
    });
  }, { threshold: 0.3 });

  document.querySelectorAll('.note-bar-fill').forEach(bar => {
    bar.style.width = '0';
    observer.observe(bar);
  });
});

// ── PROGRESS RINGS ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.progress-ring-fill').forEach(circle => {
    const pct          = parseFloat(circle.dataset.pct || 0);
    const r            = parseFloat(circle.getAttribute('r'));
    const circumference = 2 * Math.PI * r;
    circle.style.strokeDasharray  = circumference;
    circle.style.strokeDashoffset = circumference;
    // Slight delay so the animation is visible
    requestAnimationFrame(() => {
      setTimeout(() => {
        circle.style.strokeDashoffset = circumference * (1 - pct / 100);
      }, 200);
    });
  });
});

// ── COPY CODE BUTTON ──────────────────────────────────────────────
function copyCode(btn) {
  const pre = btn.closest('.code-block').querySelector('pre.code-body');
  if (!pre) return;
  const text = pre.innerText;
  navigator.clipboard.writeText(text).then(() => {
    btn.textContent = '✓ Copied!';
    btn.style.color = 'var(--jade)';
    setTimeout(() => { btn.textContent = 'Copy'; btn.style.color = ''; }, 2200);
  }).catch(() => {
    btn.textContent = 'Error';
    setTimeout(() => { btn.textContent = 'Copy'; }, 2000);
  });
}

// ── STAGGER ENTRY ANIMATION ───────────────────────────────────────
// Only animate items that are inside the currently visible panel
function animateVisibleItems() {
  const activePanel = document.querySelector('.panel.active');
  if (!activePanel) return;
  const items = activePanel.querySelectorAll('.stat-card, .fib-cell');
  items.forEach((el, i) => {
    el.style.opacity   = '0';
    el.style.transform = 'translateY(8px)';
    el.style.transition = `opacity 0.35s ease ${i * 0.03}s, transform 0.35s ease ${i * 0.03}s`;
    requestAnimationFrame(() => {
      setTimeout(() => {
        el.style.opacity   = '1';
        el.style.transform = 'translateY(0)';
      }, 30 + i * 30);
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  setTimeout(animateVisibleItems, 100);
});

// Re-run stagger when switching tabs
const _originalSwitchTab = switchTab;
window.switchTab = function(id, btn) {
  _originalSwitchTab(id, btn);
  setTimeout(animateVisibleItems, 50);
};

// ── KEYBOARD SHORTCUTS  Alt+1 … Alt+4 ────────────────────────────
document.addEventListener('keydown', e => {
  if (!e.altKey) return;
  const map = { '1': 'ex1', '2': 'ex2', '3': 'ex3', '4': 'ex4' };
  if (map[e.key]) {
    e.preventDefault();
    const btn = document.querySelector(`.nav-tab[onclick*="'${map[e.key]}'"]`);
    switchTab(map[e.key], btn);
  }
});
