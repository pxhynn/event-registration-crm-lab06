<div class="card" style="max-width: 450px; margin: 40px auto;">
    <h1>🔑 Cổng Đăng Nhập CRM</h1>
    <p style="font-size: 11pt; color: #888;">Điền thông tin tài khoản admin/staff quản trị được cấp để vào hệ thống.</p>
    
    <?php partial('flash'); ?>

    <?php if (!empty($_SESSION['flash_errors'])): ?>
        <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Thông báo: </strong>
            <span class="block sm:inline"><?= htmlspecialchars($_SESSION['flash_errors']) ?></span>
        </div>
        
        <?php unset($_SESSION['flash_errors']); ?>
    <?php endif; ?>

    <form action="/login" method="POST">
        <div class="form-group">
            <label for="email">Địa chỉ Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= e($old['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; padding: 12px; justify-content: center;">Xác thực tài khoản</button>
    </form>
</div>