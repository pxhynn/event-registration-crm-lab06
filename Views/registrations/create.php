<?php /** @var array $errors */ ?>
<h1>🛒 Lập Đơn đặt vé Sự kiện mới</h1>
<p><a href="/registrations" style="color: var(--success); text-decoration: none; font-weight: bold;">← Quay về danh sách quản lý</a></p>

<div class="card" style="max-width: 650px; margin-top: 25px;">
    <form action="/registrations/store" method="POST">
        <div class="form-group">
            <label>Mã hóa đơn đơn đặt vé duy nhất (*):</label>
            <input type="text" name="registration_code" class="form-control" placeholder="Ví dụ: REG-IND-2026" value="<?= e(old('registration_code')) ?>">
            <?php if (isset($errors['registration_code'])): ?><div class="error-text"><?= e($errors['registration_code']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Họ và tên người mua vé (*):</label>
            <input type="text" name="customer_name" class="form-control" placeholder="Ví dụ: Trần Hoàng Anh Tú" value="<?= e(old('customer_name')) ?>">
            <?php if (isset($errors['customer_name'])): ?><div class="error-text"><?= e($errors['customer_name']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Địa chỉ Email nhận vé chính thức (*):</label>
            <input type="text" name="customer_email" class="form-control" placeholder="Ví dụ: tenho@gmail.com" value="<?= e(old('customer_email')) ?>">
            <?php if (isset($errors['customer_email'])): ?><div class="error-text"><?= e($errors['customer_email']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Lựa chọn Chương trình Sự kiện để tính giá gốc:</label>
            <select id="js-event-selector" class="form-control">
                <option value="350000">Workshop Làm Gốm Thủ Công - Gốm & Chill (350.000đ)</option>
                <option value="450000">Workshop Làm Bánh Ngọt Pháp Cao Cấp (450.000đ)</option>
                <option value="300000">Đêm Nhạc Chill Live Acoustic Cuối Tuần (300.000đ)</option>
                <option value="500000">Đại Nhạc Hội Indie Music Festival 2026 (500.000đ)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Số lượng vé đặt chỗ (*):</label>
            <input type="number" id="js-quantity-input" name="ticket_quantity" class="form-control" min="1" value="<?= e(old('ticket_quantity', '1')) ?>">
            <?php if (isset($errors['ticket_quantity'])): ?><div class="error-text"><?= e($errors['ticket_quantity']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Tổng số tiền thanh toán (VNĐ) (Tự động tính toán) (*):</label>
            <input type="number" id="js-total-output" name="total_amount" class="form-control" value="<?= e(old('total_amount', '350000')) ?>" readonly>
            <?php if (isset($errors['total_amount'])): ?><div class="error-text"><?= e($errors['total_amount']) ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label>Trạng thái thanh toán đơn hàng:</label>
            <select name="payment_status" class="form-control">
                <option value="chờ thanh toán" <?= old('payment_status') === 'chờ thanh toán' ? 'selected' : '' ?>>Chờ thanh toán</option>
                <option value="đã thanh toán" <?= old('payment_status') === 'đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                <option value="đơn đã hủy" <?= old('payment_status') === 'đơn đã hủy' ? 'selected' : '' ?>>Đơn đã hủy</option>
            </select>
        </div>

        <button type="submit" class="btn" style="background-color: var(--success);">Xác nhận lập đơn xuất vé</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const eventSelect = document.getElementById('js-event-selector');
    const quantityInput = document.getElementById('js-quantity-input');
    const totalOutput = document.getElementById('js-total-output');

    function updatePrice() {
        const unitPrice = parseInt(eventSelect.value) || 0;
        const qty = parseInt(quantityInput.value) || 1;
        totalOutput.value = unitPrice * qty;
    }

    eventSelect.addEventListener('change', updatePrice);
    quantityInput.addEventListener('input', updatePrice);
});
</script>