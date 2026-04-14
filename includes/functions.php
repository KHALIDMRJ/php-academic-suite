<?php
/**
 * FPK PHP Exercices — Functions Library
 *
 * Reusable, sanitized, and documented helper functions
 * for all exercises in this project.
 *
 * @package  FPK-Exercices
 * @version  2.0.0
 */

// ══════════════════════════════════════════════════════════════
//  INPUT SANITIZATION & VALIDATION
// ══════════════════════════════════════════════════════════════

/**
 * Sanitize a string input from POST/GET — prevents XSS.
 *
 * @param  string $key     The POST key to retrieve
 * @param  string $default Fallback value if key not set
 * @return string          Sanitized, trimmed string
 */
function sanitizeString(string $key, string $default = ''): string
{
    if (!isset($_POST[$key])) return $default;
    return htmlspecialchars(trim((string)$_POST[$key]), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize and retrieve an integer from POST.
 *
 * @param  string $key     POST key
 * @param  int    $default Fallback
 * @param  int    $min     Minimum allowed value
 * @param  int    $max     Maximum allowed value (0 = no limit)
 * @return int
 */
function sanitizeInt(string $key, int $default = 0, int $min = 0, int $max = 0): int
{
    if (!isset($_POST[$key])) return $default;
    $val = (int)$_POST[$key];
    if ($val < $min) return $min;
    if ($max > 0 && $val > $max) return $max;
    return $val;
}

/**
 * Sanitize and retrieve a float from POST.
 *
 * @param  string $key     POST key
 * @param  float  $default Fallback
 * @param  float  $min     Minimum allowed value
 * @param  float  $max     Maximum allowed value (0 = no limit)
 * @return float
 */
function sanitizeFloat(string $key, float $default = 0.0, float $min = 0.0, float $max = 0.0): float
{
    if (!isset($_POST[$key])) return $default;
    $val = (float)$_POST[$key];
    if ($val < $min) return $min;
    if ($max > 0 && $val > $max) return $max;
    return $val;
}

/**
 * Validate a set of required POST fields.
 * Returns an associative array of field => error message, or [] if all valid.
 *
 * @param  array $fields  ['fieldName' => 'Label']
 * @return array          Errors array
 */
function validateRequired(array $fields): array
{
    $errors = [];
    foreach ($fields as $field => $label) {
        if (!isset($_POST[$field]) || trim((string)$_POST[$field]) === '') {
            $errors[$field] = "Le champ « $label » est requis.";
        }
    }
    return $errors;
}

/**
 * Validate that a numeric POST value is within range.
 *
 * @param  string $key
 * @param  float  $min
 * @param  float  $max
 * @param  string $label  Human-readable field name for error messages
 * @return string|null    Error message or null if valid
 */
function validateRange(string $key, float $min, float $max, string $label): ?string
{
    if (!isset($_POST[$key])) return null;
    $val = (float)$_POST[$key];
    if ($val < $min || $val > $max) {
        return "$label doit être entre $min et $max.";
    }
    return null;
}

// ══════════════════════════════════════════════════════════════
//  ACADEMIC LOGIC
// ══════════════════════════════════════════════════════════════

/**
 * Compute the average of an array of notes.
 *
 * @param  float[] $notes
 * @return float          Rounded to 2 decimal places
 */
function calculerMoyenne(array $notes): float
{
    if (empty($notes)) return 0.0;
    return round(array_sum($notes) / count($notes), 2);
}

/**
 * Get the academic mention and associated metadata.
 *
 * @param  float $moyenne
 * @return array {mention, classe, message, icon, color}
 */
function getMention(float $moyenne): array
{
    return match(true) {
        $moyenne >= 16 => [
            'mention' => 'Excellente',
            'classe'  => 'excellent',
            'message' => 'Félicitations ! Résultats remarquables.',
            'icon'    => '🏆',
            'color'   => '#34d399',
        ],
        $moyenne >= 14 => [
            'mention' => 'Bien',
            'classe'  => 'bien',
            'message' => 'Bon travail ! Continuez sur cette lancée.',
            'icon'    => '⭐',
            'color'   => 'var(--jade)',
        ],
        $moyenne >= 12 => [
            'mention' => 'Assez bien',
            'classe'  => 'assez',
            'message' => 'Efforts satisfaisants, encore quelques efforts.',
            'icon'    => '👍',
            'color'   => 'var(--violet)',
        ],
        $moyenne >= 10 => [
            'mention' => 'Passable',
            'classe'  => 'passable',
            'message' => 'Peut mieux faire, des efforts sont nécessaires.',
            'icon'    => '📘',
            'color'   => 'var(--amber)',
        ],
        default => [
            'mention' => 'Échec',
            'classe'  => 'echec',
            'message' => 'Doit redoubler d\'effort pour progresser.',
            'icon'    => '📉',
            'color'   => 'var(--rose)',
        ],
    };
}

/**
 * Determine if a student is admitted (moyenne >= 10).
 *
 * @param  float $moyenne
 * @return bool
 */
function estAdmis(float $moyenne): bool { return $moyenne >= 10.0; }

/**
 * Determine if a person is a legal adult.
 *
 * @param  int $age
 * @return bool
 */
function estMajeur(int $age): bool { return $age >= 18; }

// ══════════════════════════════════════════════════════════════
//  FIBONACCI
// ══════════════════════════════════════════════════════════════

/**
 * Generate the Fibonacci sequence up to $n terms.
 * Uses iterative method — O(n) time, O(n) space.
 *
 * @param  int   $n  Number of terms (default 100)
 * @return int[]
 */
function generateFibonacci(int $n = 100): array
{
    if ($n <= 0) return [];
    if ($n === 1) return [0];
    $seq = [0, 1];
    for ($i = 2; $i < $n; $i++) {
        $seq[] = $seq[$i - 1] + $seq[$i - 2];
    }
    return $seq;
}

// ══════════════════════════════════════════════════════════════
//  MATHEMATICS
// ══════════════════════════════════════════════════════════════

/**
 * Compute the sum 1 + 2 + ... + n using Gauss formula.
 *
 * @param  int $n
 * @return int
 */
function sommeTo(int $n): int
{
    return ($n * ($n + 1)) / 2;
}

/**
 * Get all even numbers in range [1, n].
 *
 * @param  int $n
 * @return int[]
 */
function nombresPairs(int $n): array
{
    return array_filter(range(1, max(1, $n)), fn($i) => $i % 2 === 0);
}

/**
 * Check if a number is even.
 *
 * @param  int $n
 * @return bool
 */
function estPair(int $n): bool { return $n % 2 === 0; }

// ══════════════════════════════════════════════════════════════
//  PATTERN GENERATORS
// ══════════════════════════════════════════════════════════════

/**
 * Generate a centered triangle pattern of stars.
 * Returns an array of HTML rows (already escaped).
 *
 * @param  int $hauteur
 * @return string[]
 */
function genererTriangle(int $hauteur): array
{
    $rows    = [];
    $maxWidth = 2 * $hauteur - 1; // widest row (bottom)
    for ($i = 1; $i <= $hauteur; $i++) {
        $stars   = str_repeat('*', 2 * $i - 1);
        $padding = ($maxWidth - strlen($stars)) / 2; // exact centering
        $rows[]  = str_repeat(' ', (int)$padding) . $stars;
    }
    return $rows;
}

/**
 * Generate a square pattern of stars.
 *
 * @param  int $hauteur
 * @return string[]
 */
function genererCarre(int $hauteur): array
{
    return array_fill(0, $hauteur, str_repeat('*', $hauteur));
}

/**
 * Generate multiplication table for $n (1 to 10).
 *
 * @param  int $n
 * @return array[]  Each item: [multiplicand, multiplier, result]
 */
function tableMultiplication(int $n): array
{
    return array_map(fn($i) => [$n, $i, $n * $i], range(1, 10));
}

// ══════════════════════════════════════════════════════════════
//  SESSION UTILITIES
// ══════════════════════════════════════════════════════════════

/**
 * Ensure a PHP session is started.
 */
function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Set a flash message in the session.
 *
 * @param  string $message
 * @param  string $type    'success' | 'error' | 'warn'
 */
function setFlash(string $message, string $type = 'success'): void
{
    startSession();
    $_SESSION['flash'] = ['msg' => $message, 'type' => $type];
}

/**
 * Retrieve and clear the current flash message.
 *
 * @return array|null  ['msg'=>..., 'type'=>...] or null
 */
function getFlash(): ?array
{
    startSession();
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Persist the last valid form submission to session.
 *
 * @param  string $formKey  Unique key (e.g. 'etudiant', 'pattern')
 * @param  array  $data
 */
function saveToSession(string $formKey, array $data): void
{
    startSession();
    $_SESSION['forms'][$formKey] = $data;
    $_SESSION['forms'][$formKey]['timestamp'] = date('H:i:s');
}

/**
 * Retrieve previously saved form data from session.
 *
 * @param  string $formKey
 * @return array|null
 */
function getFromSession(string $formKey): ?array
{
    startSession();
    return $_SESSION['forms'][$formKey] ?? null;
}

// ══════════════════════════════════════════════════════════════
//  HTML HELPERS
// ══════════════════════════════════════════════════════════════

/**
 * Render a stat card.
 *
 * @param  string $label
 * @param  string $value
 * @param  string $colorClass  CSS class: c-jade, c-violet, c-amber, c-rose, c-sky
 * @param  string $sub         Optional sub-label (e.g. formula)
 */
function renderStatCard(string $label, string $value, string $colorClass = 'c-jade', string $sub = ''): void
{
    echo '<div class="stat-card">';
    echo '  <div class="stat-label">' . htmlspecialchars($label) . '</div>';
    echo '  <div class="stat-value ' . $colorClass . '">' . htmlspecialchars($value) . '</div>';
    if ($sub) echo '  <div class="stat-sub">' . htmlspecialchars($sub) . '</div>';
    echo '</div>';
}

/**
 * Render an alert box.
 *
 * @param  string $message
 * @param  string $type   'error' | 'success' | 'warn'
 */
function renderAlert(string $message, string $type = 'error'): void
{
    $icons = [
        'error'   => '<svg class="alert-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        'success' => '<svg class="alert-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5 8l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'warn'    => '<svg class="alert-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 2L14.5 14H1.5L8 2z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 7v3M8 12v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
    ];
    echo '<div class="alert alert-' . $type . '">';
    echo $icons[$type] ?? $icons['error'];
    echo '<span>' . htmlspecialchars($message) . '</span>';
    echo '</div>';
}

/**
 * Render a note progress bar item.
 *
 * @param  string $subject
 * @param  float  $note
 * @param  float  $max
 * @param  string $colorClass  bar-fill-jade | bar-fill-violet | bar-fill-amber
 */
function renderNoteBar(string $subject, float $note, float $max = 20, string $colorClass = 'bar-fill-jade'): void
{
    $pct = $max > 0 ? round(($note / $max) * 100, 1) : 0;
    echo '<div class="note-item">';
    echo '  <div class="note-top">';
    echo '    <span class="note-subject">' . htmlspecialchars($subject) . '</span>';
    echo '    <span class="note-score">' . $note . '<span style="color:var(--text-ghost);font-size:11px;">/20</span></span>';
    echo '  </div>';
    echo '  <div class="note-bar"><div class="note-bar-fill ' . $colorClass . '" data-width="' . $pct . '" style="width:0"></div></div>';
    echo '</div>';
}
