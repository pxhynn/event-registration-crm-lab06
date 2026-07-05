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

        $_SESSION = []; 
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params(); 
            setcookie(session_name(), '', time() - 42000, $params['path']); 
        }
        session_destroy(); 
        session_start();
        flash('success', 'Bạn đã đăng xuất tài khoản an toàn.');
        redirect('/login'); 
    }
}