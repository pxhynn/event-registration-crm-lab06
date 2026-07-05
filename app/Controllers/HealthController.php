<?php
class HealthController
{
    public function __construct(private PDO $db) {}

    public function index(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $stmt = $this->db->query("SELECT 1");
            $stmt->execute();
            echo json_encode([
                'status' => 'UP',
                'app' => 'Event Registration CRM running smoothly',
                'database' => 'Connected successfully to MySQL via PDO'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'DOWN',
                'error' => 'Database connection failed'
            ]);
        }
        exit;
    }
}