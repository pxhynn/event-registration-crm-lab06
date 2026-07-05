<?php
class HomeController
{
    public function index(): void
    {
        if (isset($_SESSION['user_id'])) {
            redirect('/dashboard');
        }
        render('auth/login', ['title' => 'Đăng nhập hệ thống CRM Event', 'errors' => []]);
    }
}