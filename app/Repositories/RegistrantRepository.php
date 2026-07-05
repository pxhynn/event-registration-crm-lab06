<?php
class RegistrantRepository
{
    public function __construct(private PDO $db) {}

    public function countAll(string $keyword = ''): int
    {
        $sql = "SELECT COUNT(*) AS total FROM registrants";
        $params = [];
        
        if ($keyword !== '') { 
            $sql .= " WHERE name LIKE :k1 OR email LIKE :k2 OR phone LIKE :k3";
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
        $sql = "SELECT * FROM registrants";
        $params = [];
        if ($keyword !== '') {
            $sql .= " WHERE name LIKE :k1 OR email LIKE :k2 OR phone LIKE :k3";
            $params['k1'] = '%' . $keyword . '%';
            $params['k2'] = '%' . $keyword . '%';
            $params['k3'] = '%' . $keyword . '%';
        }

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

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM registrants WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        return $data ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO registrants (name, email, phone, interested_event, status, note) 
                VALUES (:name, :email, :phone, :interested_event, :status, :note)";
        $stmt = $this->db->prepare($sql);
        
        try {
            $stmt->bindValue(':name', $data['name'] ?? '', PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'] ?? '', PDO::PARAM_STR);
            $stmt->bindValue(':phone', $data['phone'] ?? '', PDO::PARAM_STR);
            $stmt->bindValue(':interested_event', $data['interested_event'] ?? '', PDO::PARAM_STR);

            $stmt->bindValue(':status', 'đăng ký mới', PDO::PARAM_STR); 
            
            $stmt->bindValue(':note', $data['note'] ?? '', PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) { 
                throw new DuplicateRecordException('Email này đã đăng ký tham gia sự kiện trước đó.');
            }
            throw $e; 
        }
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $sql = "UPDATE registrants SET 
                name = :name, email = :email, phone = :phone, 
                interested_event = :interested_event, status = :status, note = :note 
                WHERE id = :id";
        try {
            return $this->db->prepare($sql)->execute($data); 
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                throw new DuplicateRecordException('Email này trùng với một người đăng ký khác trên hệ thống.');
            }
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM registrants WHERE id = :id"); 
        return $stmt->execute(['id' => $id]);
    }
}