<?php
class AuthController
{
    public function __construct(private AuthService $authService) {}

    public function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            redirect('/dashboard');
        }

        $oldEmail = $_SESSION['old_email'] ?? '';
        unset($_SESSION['old_email']);

        render('auth/login', [
            'title' => 'Đăng nhập hệ thống CRM Event',
            'old' => ['email' => $oldEmail]
        ]);
    }

    public function handleLogin(): void
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $result = $this->authService->authenticate($email, $password);

        if (!$result['success']) {
            flash('error', $result['message']);
            $_SESSION['old_email'] = $email;

            redirect('/login');
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION['user_name'] = $result['user']['name'];
        $_SESSION['last_activity'] = time();

        flash('success', 'Đăng nhập thành công.');
        redirect('/dashboard');
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['last_activity']);

        flash('success', 'Bạn đã đăng xuất khỏi hệ thống CRM thành công.');

        redirect('/login');
    }
}