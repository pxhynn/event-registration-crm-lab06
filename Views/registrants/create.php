<h1>Thêm lượt Đăng ký Tham gia mới</h1>
<p><a href="/registrants" style="color: var(--accent); text-decoration: none; font-weight: bold;">← Quay về danh sách quản lý</a></p>

<div class="card" style="max-width: 650px; margin-top: 25px;">
    <form action="/registrants/store" method="POST">
        <div class="form-group">
            <label>Họ và tên khách hàng (*):</label>
            <input type="text" name="name" class="form-control" placeholder="Ví dụ: Nguyễn Hoàng Anh Tú" value="<?= e(old('name')) ?>">
            <?php if (isset($errors['name'])): ?><div class="error-text"><?= e($errors['name']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Địa chỉ Email liên hệ (*):</label>
            <input type="text" name="email" class="form-control" placeholder="Ví dụ: tunuyen@gmail.com" value="<?= e(old('email')) ?>">
            <?php if (isset($errors['email'])): ?><div class="error-text"><?= e($errors['email']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Số điện thoại liên lạc (*):</label>
            <input type="text" name="phone" class="form-control" placeholder="Ví dụ: 0912345678" value="<?= e(old('phone')) ?>">
            <?php if (isset($errors['phone'])): ?><div class="error-text"><?= e($errors['phone']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Chương trình nghệ thuật / Workshop lựa chọn:</label>
            <select name="interested_event" class="form-control">
                <option value="Pottery Workshop" <?= old('interested_event') === 'Pottery Workshop' ? 'selected' : '' ?>>Workshop Làm Gốm Thủ Công - Gốm & Chill</option>
                <option value="Baking Masterclass" <?= old('interested_event') === 'Baking Masterclass' ? 'selected' : '' ?>>Workshop Làm Bánh Ngọt Pháp Cao Cấp</option>
                <option value="Chill Live Acoustic" <?= old('interested_event') === 'Chill Live Acoustic' ? 'selected' : '' ?>>Đêm Nhạc Chill Live Acoustic Cuối Tuần</option>
                <option value="Indie Music Fest" <?= old('interested_event') === 'Indie Music Fest' ? 'selected' : '' ?>>Đại Nhạc Hội Indie Music Festival 2026</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ghi chú hệ thống:</label>
            <textarea name="note" class="form-control" rows="4" placeholder="Nhập yêu cầu đặc biệt của khách nếu có..."><?= e(old('note')) ?></textarea>
        </div>

        <button type="submit" class="btn">Lưu thông tin khách hàng</button>
    </form>
</div>