<div class="card" style="text-align: center; max-width: 600px; margin: 60px auto; border-top: 5px solid #C06C54;">
    <h1 style="font-size: 26pt; color: #C06C54;"><?= e($title) ?></h1>
    <p style="margin: 20px 0; font-size: 14pt;"><?= e($message) ?></p>
    
    <?php 
    $appConfig = require __DIR__ . '/../../config/app.php';
    if ($appConfig['debug'] === false): 
    ?>
        <p style="color: #999; font-size: 11pt;">Hệ thống đã ghi lại nhật ký lỗi. Nếu cần hỗ trợ, vui lòng liên hệ quản trị viên.</p>
    <?php endif; ?>
    
    <p style="margin-top: 30px;"><a href="/" class="btn">Quay lại Trang chủ</a></p>
</div>