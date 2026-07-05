<?php
class RegistrantService
{
    public function __construct(private RegistrantRepository $repo) {} 
    
    public function getList(array $query): array
    {
        $keyword = trim($query['q'] ?? ''); 
        $page = max(1, (int)($query['page'] ?? 1)); 
        $perPage = 5; 

        $allowedSort = ['id', 'name', 'email', 'created_at'];
        $sort = in_array($query['sort'] ?? '', $allowedSort, true) ? $query['sort'] : 'created_at';
        $direction = strtoupper($query['direction'] ?? '') === 'ASC' ? 'ASC' : 'DESC';

        $totalItems = $this->repo->countAll($keyword); 
        $totalPages = max(1, (int)ceil($totalItems / $perPage)); 
        if ($page > $totalPages) $page = $totalPages; 
        $offset = ($page - 1) * $perPage; 

        return [
            'registrants' => $this->repo->getPaginated($keyword, $perPage, $offset, $sort, $direction), 
            'keyword'     => $keyword, 
            'page'        => $page, 
            'totalPages'  => $totalPages, 
            'totalItems'  => $totalItems, 
            'sort'        => $sort,
            'direction'   => $direction
        ];
    }

    public function createRegistrant(array $input): array
    {
        $errors = $this->validate($input);
        if (!empty($errors)) { 
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $data = [
                'name'             => trim($input['name']),
                'email'            => trim($input['email']),
                'phone'            => trim($input['phone']),
                'interested_event' => $input['interested_event'],
                'status'           => $input['status'] ?? 'new',
                'note'             => trim($input['note'] ?? '')
            ];
            $this->repo->create($data); 
            return ['success' => true, 'errors' => []]; 
        } catch (DuplicateRecordException $e) { 
            return ['success' => false, 'errors' => ['email' => $e->getMessage()]]; 
        }
    }

    public function updateRegistrant(int $id, array $input): array
    {
        if (!$this->repo->findById($id)) { 
            return ['success' => false, 'errors' => ['general' => 'Người đăng ký sự kiện này không tồn tại.']];
        }

        $errors = $this->validate($input);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $data = [
                'name'             => trim($input['name']),
                'email'            => trim($input['email']),
                'phone'            => trim($input['phone']),
                'interested_event' => $input['interested_event'],
                'status'           => $input['status'],
                'note'             => trim($input['note'] ?? '')
            ];
            $this->repo->update($id, $data);
            return ['success' => true, 'errors' => []]; 
        } catch (DuplicateRecordException $e) {
            return ['success' => false, 'errors' => ['email' => $e->getMessage()]];
        }
    }

    public function deleteRegistrant(int $id): array
    {
        if ($id <= 0) return ['success' => false, 'errors' => ['general' => 'ID không hợp lệ.']];
        $this->repo->delete($id);
        return ['success' => true, 'errors' => []]; 
    }

    public function getById(int $id): ?array
    {
        return $this->repo->findById($id);
    }

    private function validate(array $input): array
    {
        $errors = [];
        $name = trim($input['name'] ?? ''); 
        $email = trim($input['email'] ?? ''); 
        $phone = trim($input['phone'] ?? ''); 
        $event = $input['interested_event'] ?? '';
        $status = $input['status'] ?? 'new';

        if ($name === '') $errors['name'] = 'Họ và tên bắt buộc phải nhập.'; 
        if ($email === '') { 
            $errors['email'] = 'Email liên lạc bắt buộc phải nhập.'; 
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $errors['email'] = 'Định dạng email không hợp lệ.'; 
        }
        if ($phone === '') $errors['phone'] = 'Số điện thoại bắt buộc phải nhập.';
        
        $validEvents = ['Pottery Workshop', 'Baking Masterclass', 'Chill Live Acoustic', 'Indie Music Fest'];
        if (!in_array($event, $validEvents, true)) {
            $errors['interested_event'] = 'Sự kiện lựa chọn không hợp lệ.';
        }

        $validStatuses = ['new', 'contacted', 'reserved', 'cancelled'];
        if (!in_array($status, $validStatuses, true)) { 
            $errors['status'] = 'Trạng thái xử lý không hợp lệ.'; 
        }

        return $errors;
    }
}