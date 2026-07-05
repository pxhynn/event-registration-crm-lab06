<?php
class RegistrationRepository
{
    public function __construct(private PDO $db) {}

    public function countAll(string $keyword = ''): int
    {
        $sql = "SELECT COUNT(*) AS total FROM registrations";
        $params = [];
        
        if ($keyword !== '') { 
            // ĐỒI THÀNH CHỮ R HOA: Registration_code
            $sql .= " WHERE Registration_code LIKE :k1 OR customer_name LIKE :k2 OR customer_email LIKE :k3";
            $params['k1'] = '%' . $keyword . '%';
            $params['k2'] = '%' . $keyword . '%';
            $params['k3'] = '%' . $keyword . '%';
        }
        
        $stmt = $this->db->prepare($sql); 
        $stmt->execute($params); 
        return (int)($stmt->fetch()['total'] ?? 0); 
    }

    public function getPaginated(string $keyword, int $limit, int $offset, string $sort, string $direction): array
    {
        $sql = "SELECT * FROM registrations";
        $params = [];
        
        if ($keyword !== '') {
            // ĐỔI THÀNH CHỮ R HOA: Registration_code
            $sql .= " WHERE Registration_code LIKE :k1 OR customer_name LIKE :k2 OR customer_email LIKE :k3";
            $params['k1'] = '%' . $keyword . '%';
            $params['k2'] = '%' . $keyword . '%';
            $params['k3'] = '%' . $keyword . '%';
        }

        // Đồng bộ sắp xếp an toàn cho T24
        $sql .= " ORDER BY {$sort} {$direction} LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql); 

        foreach ($params as $key => $value) { 
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR); 
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute(); 
        return $stmt->fetchAll(); 
    }

    public function create(array $data): bool
    {
        // Đồng bộ hoàn toàn placeholders và cấu trúc cột chữ R viết hoa
        $sql = "INSERT INTO registrations (Registration_code, customer_name, customer_email, ticket_quantity, total_amount, payment_status) 
                VALUES (:registration_code, :customer_name, :customer_email, :ticket_quantity, :total_amount, :payment_status)";
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute([
                ':registration_code' => $data['registration_code'] ?? '',
                ':customer_name'     => $data['customer_name'] ?? '',
                ':customer_email'    => $data['customer_email'] ?? '',
                ':ticket_quantity'   => $data['ticket_quantity'] ?? 1,
                ':total_amount'      => $data['total_amount'] ?? 0.00,
                ':payment_status'    => $data['payment_status'] ?? 'chờ thanh toán'
            ]);
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                throw new DuplicateRecordException('Mã đơn đăng ký này đã tồn tại trong hệ thống.');
            }
            throw $e;
        }
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM registrations WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        return $data ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE registrations SET 
                Registration_code = :registration_code, customer_name = :customer_name, 
                customer_email = :customer_email, ticket_quantity = :ticket_quantity, 
                total_amount = :total_amount, payment_status = :payment_status 
                WHERE id = :id";
        try {
            return $this->db->prepare($sql)->execute([
                ':id'                => $id,
                ':registration_code' => $data['registration_code'],
                ':customer_name'     => $data['customer_name'],
                ':customer_email'    => $data['customer_email'],
                ':ticket_quantity'   => $data['ticket_quantity'],
                ':total_amount'      => $data['total_amount'],
                ':payment_status'    => $data['payment_status']
            ]);
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                throw new DuplicateRecordException('Mã số đơn đăng ký vé này đã trùng với một đơn đặt chỗ khác.');
            }
            throw $e;
        }
    }
}