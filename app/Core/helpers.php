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
        return;
    }

    $timeout_duration = 900; 

    if (isset($_SESSION['last_activity'])) {
        $elapsed_time = time() - $_SESSION['last_activity'];

        if ($elapsed_time > $timeout_duration) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['last_activity']);
            session_destroy(); 

            session_start();
            $_SESSION['flash_errors'] = 'Phiên đăng nhập đã hết hạn. Vui lòng thử lại';

            header("Location: /login");
            exit;
        }
    }

    $_SESSION['last_activity'] = time();
}