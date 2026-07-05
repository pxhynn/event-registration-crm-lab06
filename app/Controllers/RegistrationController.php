<?php
class RegistrationController
{
    public function __construct(private RegistrationService $service) {}

    public function index(): void
    {
        require_login(); 
        $data = $this->service->getList($_GET);
        render('registrations/index', ['title' => 'Quản lý Vé & Đơn đặt chỗ'] + $data);
    }

    public function create(): void
    {
        require_login(); 
        render('registrations/create', ['title' => 'Xuất đơn đăng ký vé mới', 'errors' => []]);
    }

    public function store(): void
    {
        require_login(); 
        $result = $this->service->createOrder($_POST);

        if (!$result['success']) {
            render('registrations/create', [
                'title' => 'Xuất đơn đăng ký vé mới',
                'errors' => $result['errors']
            ]);
            return;
        }

        flash('success', 'Đơn đặt chỗ và hoá đơn vé sự kiện đã được lập thành công.');
        redirect('/registrations');
    }

    public function edit(): void
    {
        require_login();
        $id = (int)($_GET['id'] ?? 0);
        $registration = $this->service->getById($id);

        if (!$registration) {
            flash('error', 'Hệ thống không tìm thấy đơn đặt vé yêu cầu.');
            redirect('/registrations');
        }

        render('registrations/edit', [
            'title' => 'Cập nhật hóa đơn vé #' . $id,
            'registration' => $registration,
            'errors' => []
        ]);
    }

    public function update(): void
    {
        require_login();
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->service->updateOrder($id, $_POST);

        if (!$result['success']) {
            $registration = $this->service->getById($id) ?: $_POST;
            render('registrations/edit', [
                'title' => 'Cập nhật hóa đơn vé #' . $id,
                'registration' => $registration,
                'errors' => $result['errors']
            ]);
            return;
        }

        flash('success', 'Thông tin đơn đặt vé đã được cập nhật thành công.');
        redirect('/registrations');
    }

    public function delete(): void
    {
        require_login();
        $id = (int)($_POST['id'] ?? 0);
        $dbConfig = require __DIR__ . '/../../config/database.php';
        $pdo = Database::connect($dbConfig);
        $stmt = $pdo->prepare("DELETE FROM registrations WHERE id = :id");
        $stmt->execute(['id' => $id]);

        flash('success', 'Đơn đặt vé đã được loại bỏ thành công khỏi hệ thống.');
        redirect('/registrations');
    }
}