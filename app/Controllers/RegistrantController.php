<?php
class RegistrantController
{
    public function __construct(private RegistrantService $service) {}

    public function index(): void
    {
        require_login();
        $data = $this->service->getList($_GET);
        render('registrants/index', ['title' => 'Quản lý người đăng ký Sự kiện'] + $data);
    }

    public function create(): void
    {
        require_login(); 
        render('registrants/create', ['title' => 'Thêm mới thông tin Đăng ký', 'errors' => []]);
    }

   public function store(): void
    {
        require_login(); 

        if (!empty($_POST['fax_number'])) {
            http_response_code(400);
            die("Phát hiện hành vi Spam! Request của bạn đã bị hệ thống từ chối xử lý.");
        }

        $data = [
            'name'             => trim($_POST['name'] ?? ''),
            'email'            => trim($_POST['email'] ?? ''),
            'phone'            => trim($_POST['phone'] ?? ''),
            'interested_event' => $_POST['interested_event'] ?? '',
            'note'             => trim($_POST['note'] ?? '')
        ];

        $result = $this->service->createRegistrant($data); 

        if (!$result['success']) { 
            render('registrants/create', [ 
                'title'  => 'Thêm lượt Đăng ký Tham gia mới', 
                'errors' => $result['errors'] 
            ]);
            return; 
        }

        flash('success', 'Hệ thống đã lưu lại thông tin người đăng ký sự kiện thành công.'); 
        redirect('/registrants'); 
    }

    public function edit(): void
    {
        require_login(); 
        $id = (int)($_GET['id'] ?? 0);
        $registrant = $this->service->getById($id);

        if (!$registrant) {
            flash('error', 'Không tìm thấy dữ liệu người đăng ký sự kiện.');
            redirect('/registrants');
        }

        render('registrants/edit', [
            'title' => 'Cập nhật thông tin đăng ký #' . $id,
            'registrant' => $registrant,
            'errors' => []
        ]);
    }

    public function update(): void
    {
        require_login(); 
        $id = (int)($_POST['id'] ?? 0);
        $result = $this->service->updateRegistrant($id, $_POST);

        if (!$result['success']) {
            $registrant = $this->service->getById($id) ?: $_POST;
            render('registrants/edit', [
                'title' => 'Cập nhật thông tin đăng ký #' . $id,
                'registrant' => $registrant,
                'errors' => $result['errors']
            ]);
            return;
        }

        flash('success', 'Thông tin người đăng ký sự kiện đã được cập nhật thành công.');
        redirect('/registrants');
    }

    public function delete(): void
    {
        require_login(); 
        $id = (int)($_POST['id'] ?? 0);
        $this->service->deleteRegistrant($id);

        flash('success', 'Người đăng ký đã được xoá khỏi hệ thống.');
        redirect('/registrants');
    }
}