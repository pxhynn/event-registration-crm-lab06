<?php
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header("Location: " . $path);
    exit;
}

function render(string $view, array $data = [], string $layout = 'layouts/main'): void
{
    extract($data);
    ob_start();
    require __DIR__ . '/../../Views/' . $view . '.php';
    $content = ob_get_clean();
    require __DIR__ . '/../../Views/' . $layout . '.php';
}

function partial(string $name, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../../Views/partials/' . $name . '.php';
}

function flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function get_flash(string $key): ?string
{
    if (empty($_SESSION['flash'][$key])) return null;
    $message = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $message;
}

function old(string $key, $default = '')
{
    return (string)($_POST[$key] ?? $_GET[$key] ?? $default);
}

function require_login(): void
{
    if (!isset($_SESSION['user_id'])) {
        flash('error', 'Vui lòng đăng nhập để truy cập chức năng này.');
        redirect('/login');
    };

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 900)) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path']);
        session_destroy();
        session_start();
        flash('error', 'Phiên làm việc đã hết hạn. Vui lòng đăng nhập lại.');
        redirect('/login');
    };
    $_SESSION['last_activity'] = time();
}