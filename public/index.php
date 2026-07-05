<?php
// 1. Khởi động cấu hình phiên làm việc an toàn với Cookie flags
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']), 
    'httponly' => true, 
    'samesite' => 'Lax' 
]);
session_start();

// 2. Nhúng thủ công toàn bộ cấu trúc mã nguồn theo đúng phân bổ thư mục đề bài
require_once __DIR__ . '/../app/Core/helpers.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/DuplicateRecordException.php';

// Nhúng Repositories
require_once __DIR__ . '/../app/Repositories/UserRepository.php';
require_once __DIR__ . '/../app/Repositories/RegistrantRepository.php';
require_once __DIR__ . '/../app/Repositories/RegistrationRepository.php';

// Nhúng Services
require_once __DIR__ . '/../app/Services/AuthService.php';
require_once __DIR__ . '/../app/Services/RegistrantService.php';
require_once __DIR__ . '/../app/Services/RegistrationService.php';

// Nhúng Controllers
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/DashboardController.php';
require_once __DIR__ . '/../app/Controllers/RegistrantController.php';
require_once __DIR__ . '/../app/Controllers/RegistrationController.php';
require_once __DIR__ . '/../app/Controllers/HealthController.php';

// 3. Khởi tạo Database PDO Connection 
$dbConfig = require __DIR__ . '/../config/database.php';
try {
    $pdo = Database::connect($dbConfig);
} catch (Exception $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

// 4. Xây dựng Khung Dependency Injection Container thủ công
$container = [];

// Khởi tạo Repositories kết nối DB
$container[UserRepository::class] = new UserRepository($pdo);
$container[RegistrantRepository::class] = new RegistrantRepository($pdo);
$container[RegistrationRepository::class] = new RegistrationRepository($pdo);

// Khởi tạo Services nghiệp vụ
$container[AuthService::class] = new AuthService($container[UserRepository::class]);
$container[RegistrantService::class] = new RegistrantService($container[RegistrantRepository::class]);
$container[RegistrationService::class] = new RegistrationService($container[RegistrationRepository::class]);

// Khởi tạo Controllers liên kết View 
$container[HomeController::class] = new HomeController();
$container[AuthController::class] = new AuthController($container[AuthService::class]);
$container[DashboardController::class] = new DashboardController($container[RegistrantRepository::class], $container[RegistrationRepository::class]);
$container[RegistrantController::class] = new RegistrantController($container[RegistrantService::class]);
$container[RegistrationController::class] = new RegistrationController($container[RegistrationService::class]);
$container[HealthController::class] = new HealthController($pdo);

// 5. Khai báo bảng định tuyến Route rõ ràng bảo mật đúng biểu mẫu 
$router = new Router();

// Routes cho Authentication & Dashboard
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/login', [AuthController::class, 'login']);
$router->add('POST', '/login', [AuthController::class, 'handleLogin']);
$router->add('POST', '/logout', [AuthController::class, 'logout']);
$router->add('GET', '/dashboard', [DashboardController::class, 'index']);

// Routes cho Module: Registrants (Quản lý người đăng ký)
$router->add('GET', '/registrants', [RegistrantController::class, 'index']);
$router->add('GET', '/registrants/create', [RegistrantController::class, 'create']);
$router->add('POST', '/registrants/store', [RegistrantController::class, 'store']);
$router->add('GET', '/registrants/edit', [RegistrantController::class, 'edit']);
$router->add('POST', '/registrants/update', [RegistrantController::class, 'update']);
$router->add('POST', '/registrants/delete', [RegistrantController::class, 'delete']);

// Routes cho Module: Registrations (Quản lý đơn mua vé/đặt chỗ)
$router->add('GET', '/registrations', [RegistrationController::class, 'index']);
$router->add('GET', '/registrations/create', [RegistrationController::class, 'create']);
$router->add('POST', '/registrations/store', [RegistrationController::class, 'store']);
$router->add('GET', '/registrations/edit', [RegistrationController::class, 'edit']);
$router->add('POST', '/registrations/update', [RegistrationController::class, 'update']);
$router->add('POST', '/registrations/delete', [RegistrationController::class, 'delete']);

// Route kiểm tra System Health
$router->add('GET', '/health', [HealthController::class, 'index']);

// 6. Thực thi Request Dispatching điều phối tác vụ
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $container);