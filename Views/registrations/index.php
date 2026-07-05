<?php
/** @var array $registrations */
/** @var string $keyword */
/** @var int $page */
/** @var int $totalPages */
/** @var int $totalItems */
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="border: none; padding: 0; margin: 0;">Sổ theo dõi Đơn đặt vé Sự kiện</h1>
    <a href="/registrations/create" class="btn" style="background-color: var(--success);">🛒 Lập hóa đơn vé mới</a>
</div>

<div class="card" style="padding: 20px; margin-bottom: 25px;">
    <form method="GET" action="/registrations" style="display: flex; gap: 15px; align-items: center;">
        <input type="text" name="q" class="form-control" placeholder="Tìm mã số đơn, tên khách hàng, email nhận vé..." value="<?= e($keyword) ?>" style="margin: 0;">
        <button type="submit" class="btn" style="background-color: var(--success);">Tìm kiếm</button>
    </form>
</div>

<div style="overflow-x: auto;">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã hóa đơn vé</th>
                <th>Họ tên người mua</th>
                <th>Email nhận vé</th>
                <th>Số lượng</th>
                <th>Tổng thanh toán</th>
                <th>Trạng thái</th>
                <th>Ngày phát hành</th>
                <th style="text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($registrations)): ?>
                <tr><td colspan="9" style="text-align: center; color: var(--text-muted); padding: 30px;">Hệ thống chưa ghi nhận đơn đặt vé nào.</td></tr>
            <?php else: ?>
                <?php foreach ($registrations as $rg): ?>
                    <tr>
                        <td><?= e((string)$rg['id']) ?></td>
                        <td><strong style="color: var(--danger);"><?= e($rg['registration_code']) ?></strong></td>
                        <td><strong><?= e($rg['customer_name']) ?></strong></td>
                        <td><?= e($rg['customer_email']) ?></td>
                        <td><?= e((string)$rg['ticket_quantity']) ?> vé</td>
                        <td><strong style="color: var(--text-primary);"><?= number_format((float)$rg['total_amount'], 0, ',', '.') ?>đ</strong></td>
                        <td>
                            <?php if ($rg['payment_status'] === 'đã thanh toán'): ?>
                                <span class="badge badge-green">Đã thanh toán</span>
                            <?php elseif ($rg['payment_status'] === 'chờ thanh toán'): ?>
                                <span class="badge badge-yellow">Chờ thanh toán</span>
                            <?php elseif ($rg['payment_status'] === 'đơn đã hủy'): ?>
                                <span class="badge badge-red">Đơn đã hủy</span>
                            <?php endif; ?>
                        </td>
                        <td><span style="font-size: 12pt; color: var(--text-muted);"><?= e($rg['created_at']) ?></span></td>
                        
                        <td style="text-align: center; white-space: nowrap;">
                            <a href="/registrations/edit?id=<?= e((string)$rg['id']) ?>" 
                               title="Chỉnh sửa đơn hàng" 
                               style="color: var(--accent); font-size: 16pt; text-decoration: none; margin-right: 18px; display: inline-block;">
                               ✏️
                            </a>
                            
                            <form action="/registrations/delete" method="POST" style="display: inline-block;" onsubmit="return confirm('Xác nhận huỷ/xoá đơn đặt vé này khỏi hệ thống?');">
                                <input type="hidden" name="id" value="<?= e((string)$rg['id']) ?>">
                                <button type="submit" 
                                        title="Xóa đơn hàng" 
                                        style="background: none; border: none; color: var(--danger); font-size: 16pt; cursor: pointer; padding: 0; font-family: inherit; display: inline-block; vertical-align: middle;">
                                        🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px; padding: 0 5px;">
    <div style="color: var(--text-muted); font-size: 11pt;">
        Hiển thị trang <strong><?= $page ?></strong> / <strong><?= $totalPages ?></strong> (Tổng số <strong><?= $totalItems ?></strong> đơn vé)
    </div>
    <div style="display: flex; gap: 8px;">
        <?php if ($page > 1): ?>
            <a href="/registrations?q=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>" class="btn" style="padding: 6px 14px; background-color: #8E7A67; font-size: 11pt; text-decoration: none;">← Trước</a>
        <?php else: ?>
            <span class="btn" style="padding: 6px 14px; background-color: #DDD; color: #999; cursor: not-allowed; font-size: 11pt;">← Trước</span>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/registrations?q=<?= urlencode($keyword) ?>&page=<?= $i ?>" 
               class="btn" 
               style="padding: 6px 14px; font-size: 11pt; text-decoration: none; background-color: <?= $i === $page ? 'var(--accent)' : '#EAE6E1' ?>; color: <?= $i === $page ? '#FFF' : 'var(--text-primary)' ?>;">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="/registrations?q=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>" class="btn" style="padding: 6px 14px; background-color: #8E7A67; font-size: 11pt; text-decoration: none;">Sau →</a>
        <?php else: ?>
            <span class="btn" style="padding: 6px 14px; background-color: #DDD; color: #999; cursor: not-allowed; font-size: 11pt;">Sau →</span>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>