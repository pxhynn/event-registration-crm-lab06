<?php 
/** @var array $registrant */ 
/** @var array $errors */ 
?>
<h1>✏️ Chỉnh sửa Thông tin Đăng ký</h1>
<p><a href="/registrants" style="color: var(--accent); text-decoration: none; font-weight: bold;">← Quay về danh sách quản lý</a></p>

<div class="card" style="max-width: 650px; margin-top: 25px;">
    <form action="/registrants/update" method="POST">
        <input type="hidden" name="id" value="<?= e((string)$registrant['id']) ?>">

        <div class="form-group">
            <label>Họ và tên khách hàng (Hỗ trợ tên tiếng Việt 2 - 5 từ) (*):</label>
            <input type="text" name="name" class="form-control" value="<?= e($registrant['name']) ?>">
            <?php if (isset($errors['name'])): ?><div class="error-text"><?= e($errors['name']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Địa chỉ Email liên hệ (Định dạng: tenho@gmail.com) (*):</label>
            <input type="text" name="email" class="form-control" value="<?= e($registrant['email']) ?>">
            <?php if (isset($errors['email'])): ?><div class="error-text"><?= e($errors['email']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Số điện thoại liên lạc (*):</label>
            <input type="text" name="phone" class="form-control" value="<?= e($registrant['phone']) ?>">
            <?php if (isset($errors['phone'])): ?><div class="error-text"><?= e($errors['phone']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Chương trình nghệ thuật / Workshop lựa chọn:</label>
            <select name="interested_event" class="form-control">
                <option value="Pottery Workshop" <?= $registrant['interested_event'] === 'Pottery Workshop' ? 'selected' : '' ?>>Workshop Làm Gốm Thủ Công - Gốm & Chill</option>
                <option value="Baking Masterclass" <?= $registrant['interested_event'] === 'Baking Masterclass' ? 'selected' : '' ?>>Workshop Làm Bánh Ngọt Pháp Cao Cấp</option>
                <option value="Chill Live Acoustic" <?= $registrant['interested_event'] === 'Chill Live Acoustic' ? 'selected' : '' ?>>Đêm Nhạc Chill Live Acoustic Cuối Tuần</option>
                <option value="Indie Music Fest" <?= $registrant['interested_event'] === 'Indie Music Fest' ? 'selected' : '' ?>>Đại Nhạc Hội Indie Music Festival 2026</option>
            </select>
        </div>

        <div class="form-group">
            <label>Trạng thái xử lý hồ sơ:</label>
            <select name="status" class="form-control">
                <option value="đăng ký mới" <?= $registrant['status'] === 'đăng ký mới' ? 'selected' : '' ?>>Đăng ký mới</option>
                <option value="đang xét duyệt" <?= $registrant['status'] === 'đang xét duyệt' ? 'selected' : '' ?>>Đang xét duyệt</option>
                <option value="hoàn tất" <?= $registrant['status'] === 'hoàn tất' ? 'selected' : '' ?>>Hoàn tất</option>
                <option value="đã hủy" <?= $registrant['status'] === 'đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ghi chú hệ thống:</label>
            <textarea name="note" class="form-control" rows="4"><?= e($registrant['note'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn">Cập nhật hồ sơ khách hàng</button>
    </form>
</div>