<?php
/**
 * =============================================================================
 * ConstantMVC — Small helper functions
 * =============================================================================
 *
 * A handful of tiny functions used throughout the views and controllers. They
 * keep the templates readable and safe. Nothing here holds state or opens a
 * database connection — that job belongs to core/Database.php.
 */

/**
 * Escape a value for safe output in HTML. ALWAYS use this when printing data
 * that came from a user or the database — it prevents XSS attacks.
 *
 *   <td><?= e($person['email']) ?></td>
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Build a URL relative to wherever the app is installed. This is why the
 * framework works whether it lives at http://localhost/ or
 * http://localhost/ConstantMVC/ — no hardcoded paths or IP addresses.
 *
 *   header('Location: ' . base_url());          // back to the list
 *   <base href="<?= base_url() ?>">              // makes every relative link resolve
 */
function base_url(string $path = ''): string
{
    // The folder index.php is served from, e.g. "" or "/ConstantMVC".
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    return $dir . '/' . ltrim($path, '/');
}

/**
 * Read a POST value, trimmed, with a fallback default.
 */
function post(string $key, string $default = ''): string
{
    return trim((string) ($_POST[$key] ?? $default));
}

/**
 * Send the browser back to a route and stop. Used after create/update/delete
 * (the "Post/Redirect/Get" pattern, which prevents duplicate form submissions).
 */
function redirect(string $path = ''): never
{
    header('Location: ' . base_url($path));
    exit;
}

/**
 * Flash messages: store a short message now, read it once on the next request.
 * Used to show "Person added" / validation errors after a redirect.
 *
 *   flash('success', 'Person added.');   // set
 *   $msg = flash('success');             // get (and clear)
 */
function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $value;
}

/**
 * Remember the form values and validation errors of a failed submission, so the
 * modal can re-open pre-filled instead of losing everything. Read once, cleared.
 */
function remember_input(array $data, array $errors): void
{
    $_SESSION['old']    = $data;
    $_SESSION['errors'] = $errors;
}

function old(string $key): string
{
    return (string) ($_SESSION['old'][$key] ?? '');
}

function errors(): array
{
    return $_SESSION['errors'] ?? [];
}

/**
 * Clear the remembered input/errors. Called once the view has rendered them.
 */
function clear_remembered(): void
{
    unset($_SESSION['old'], $_SESSION['errors']);
}

/**
 * Render a page. This is the framework's tiny "template engine":
 *   1. it runs the page template ($template) capturing its HTML,
 *   2. then drops that HTML into the shared layout (nav + footer + <head>).
 *
 * So every page shares one layout and no <head> is ever duplicated.
 *
 *   view('people/index', ['people' => $people]);
 */
function view(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);

    // 1. Render just the page body into $content.
    ob_start();
    require __DIR__ . '/../app/Views/' . $template . '.php';
    $content = ob_get_clean();

    // 2. Wrap it in the shared HTML shell.
    require __DIR__ . '/../app/Views/layout.php';
}
