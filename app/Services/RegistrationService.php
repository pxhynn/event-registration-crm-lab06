<?php
class RegistrationService
{
    public function __construct(private RegistrationRepository $repo) {}

    public function getList(array $query): array
    {
        $keyword = trim($query['q'] ?? ''); 
        $page = max(1, (int)($query['page'] ?? 1)); 
        $perPage = 5; 

        $allowedSort = ['id', 'Registration_code', 'customer_name', 'created_at']; 
        $sort = in_array($query['sort'] ?? '', $allowedSort, true) ? $query['sort'] : 'created_at';
        $direction = strtoupper($query['direction'] ?? '') === 'ASC' ? 'ASC' : 'DESC';

        $totalItems = $this->repo->countAll($keyword); 
        $totalPages = max(1, (int)ceil($totalItems / $perPage)); 
        if ($page > $totalPages) $page = $totalPages; 
        $offset = ($page - 1) * $perPage; 

        return [
            'registrations' => $this->repo->getPaginated($keyword, $perPage, $offset, $sort, $direction), 
            'page'          => $page, 
            'totalPages'    => $totalPages, 
            'totalItems'    => $totalItems,
            'sort'          => $sort,
            'direction'     => $direction,
            'keyword'       => $keyword 
        ];
    }

    public function createOrder(array $input): array
    {
        $errors = [];
        $code = trim($input['registration_code'] ?? '');
        $name = trim($input['customer_name'] ?? '');
        $email = trim($input['customer_email'] ?? '');
        $qty = (int)($input['ticket_quantity'] ?? 0);
        $amount = (float)($input['total_amount'] ?? 0);
        $status = $input['payment_status'] ?? 'chờ thanh toán';

        if ($code === '') $errors['registration_code'] = 'Mã đăng ký bắt buộc nhập.';
        if ($name === '') $errors['customer_name'] = 'Họ tên khách mua vé bắt buộc nhập.';
        if ($email === '') {
            $errors['customer_email'] = 'Email bắt buộc nhập.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['customer_email'] = 'Định dạng email mua vé không chính xác.';
        }
        if ($qty <= 0) $errors['ticket_quantity'] = 'Số lượng vé phải lớn hơn hoặc bằng 1.';
        if ($amount < 0) $errors['total_amount'] = 'Tổng số tiền không được là số âm.'; 

        if (!in_array($status, ['chờ thanh toán', 'đã thanh toán', 'đơn đã hủy'], true)) {
            $errors['payment_status'] = 'Trạng thái hoá đơn thanh toán không hợp lệ.';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $data = [
                'registration_code' => $code,
                'customer_name'     => $name,
                'customer_email'    => $email,
                'ticket_quantity'   => $qty,
                'total_amount'      => $amount,
                'payment_status'    => $status
            ];
            $this->repo->create($data);
            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return ['success' => false, 'errors' => ['registration_code' => $e->getMessage()]];
        }
    }

    public function getById(int $id): ?array
    {
        return $this->repo->findById($id);
    }

    public function updateOrder(int $id, array $input): array
    {
        if (!$this->repo->findById($id)) {
            return ['success' => false, 'errors' => ['general' => 'Đơn vé này không tồn tại trên hệ thống.']];
        }

        $errors = [];
        if (trim($input['registration_code'] ?? '') === '') $errors['registration_code'] = 'Mã đơn vé không được trống.';
        if (trim($input['customer_name'] ?? '') === '') $errors['customer_name'] = 'Tên khách hàng không được trống.';
        if (!filter_var($input['customer_email'] ?? '', FILTER_VALIDATE_EMAIL)) $errors['customer_email'] = 'Email không hợp lệ.';

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $data = [
                'registration_code' => trim($input['registration_code']),
                'customer_name'     => trim($input['customer_name']),
                'customer_email'    => trim($input['customer_email']),
                'ticket_quantity'   => (int)$input['ticket_quantity'],
                'total_amount'      => (float)$input['total_amount'],
                'payment_status'    => $input['payment_status']
            ];
            $this->repo->update($id, $data);
            return ['success' => true, 'errors' => []];
        } catch (DuplicateRecordException $e) {
            return ['success' => false, 'errors' => ['registration_code' => $e->getMessage()]];
        }
    }
}