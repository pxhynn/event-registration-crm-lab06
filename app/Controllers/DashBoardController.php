<?php
class DashboardController
{
    private PDO $db;

    public function __construct(private RegistrantRepository $regRepo, private RegistrationRepository $orderRepo) {
        $dbConfig = require __DIR__ . '/../../config/database.php';
        $this->db = Database::connect($dbConfig);
    }

    public function index(): void
    {
        require_login(); 

        $stmt = $this->db->query("SELECT COUNT(*) FROM registrants WHERE status = 'đăng ký mới'");
        $newRegistrants = (int)$stmt->fetchColumn();

        $stmt = $this->db->query("SELECT COUNT(*) FROM registrants WHERE status = 'đang xét duyệt'");
        $pendingRegistrants = (int)$stmt->fetchColumn();

        $stmt = $this->db->query("SELECT COUNT(*) FROM registrations WHERE payment_status = 'đã thanh toán'");
        $totalPaidOrders = (int)$stmt->fetchColumn();

        $stmt = $this->db->query("SELECT SUM(total_amount) FROM registrations WHERE payment_status = 'đã thanh toán'");
        $totalRevenue = (float)($stmt->fetchColumn() ?: 0);

        $stmt = $this->db->query("SELECT * FROM registrants ORDER BY updated_at DESC, created_at DESC LIMIT 5");
        $recentLeads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $eventsMapping = [
            'POT' => ['name' => 'Workshop Làm Gốm Thủ Công - Gốm & Chill', 'price' => 350000],
            'BAK' => ['name' => 'Workshop Làm Bánh Ngọt Pháp Cao Cấp', 'price' => 450000],
            'CHI' => ['name' => 'Đêm Nhạc Chill Live Acoustic Cuối Tuần', 'price' => 300000],
            'IND' => ['name' => 'Đại Nhạc Hội Indie Music Festival 2026', 'price' => 500000]
        ];

        $summaryEvents = [];
        foreach ($eventsMapping as $code => $info) {
            $stmt = $this->db->prepare("
                SELECT SUM(ticket_quantity) as total_qty, SUM(total_amount) as total_sum 
                FROM registrations 
                WHERE registration_code LIKE :pattern AND payment_status = 'đã thanh toán'
            ");
            $stmt->execute(['pattern' => '%-' . $code . '-%']);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            $summaryEvents[] = [
                'code' => 'EVT-' . $code . '-2026',
                'name' => $info['name'],
                'price' => $info['price'],
                'total_tickets' => (int)($res['total_qty'] ?? 0),
                'total_amount' => (float)($res['total_sum'] ?? 0)
            ];
        }

        render('dashboard/index', [
            'title' => 'Bảng điều khiển tổng quan',
            'newRegistrants' => $newRegistrants,
            'pendingRegistrants' => $pendingRegistrants,
            'totalPaidOrders' => $totalPaidOrders,
            'totalRevenue' => $totalRevenue,
            'recentLeads' => $recentLeads,
            'summaryEvents' => $summaryEvents
        ]);
    }
}