<?php
/** @var array $registrants */
/** @var string $keyword */
/** @var string $sort */
/** @var string $direction */
/** @var int $page */
/** @var int $totalPages */
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 style="border: none; padding: 0; margin: 0;">Hồ sơ Người đăng ký Sự kiện</h1>
    <a href="/registrants/create" class="btn">✨ Thêm người đăng ký</a>
</div>

<div class="card" style="padding: 20px; margin-bottom: 25px;">
    <form method="GET" action="/registrants" style="display: flex; gap: 15px; align-items: center;">
        <input type="text" name="q" class="form-control" placeholder="Tìm tên khách hàng, email, sđt..." value="<?= e($keyword) ?>" style="flex: 1; margin: 0;">
        <button type="submit" class="btn">Tìm kiếm</button>
        <?php if ($keyword !== ''): ?>
            <a href="/registrants" style="color: var(--danger); text-decoration: none; font-weight: bold; font-size: 12pt; margin-left: 10px;">Hủy lọc</a>
        <?php endif; ?>
    </form>
</div>

<div style="overflow-x: auto;">
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th><a href="/registrants?q=<?= e($keyword) ?>&sort=name&direction=<?= $sort === 'name' && $direction === 'ASC' ? 'DESC' : 'ASC' ?>" style="color: inherit; text-decoration: none;">Khách hàng (Họ và tên) ▲▼</a></th>
                <th><a href="/registrants?q=<?= e($keyword) ?>&sort=email&direction=<?= $sort === 'email' && $direction === 'ASC' ? 'DESC' : 'ASC' ?>" style="color: inherit; text-decoration: none;">Email liên hệ ▲▼</a></th>
                <th>Số điện thoại</th>
                <th>Chương trình đăng ký</th>
                <th>Trạng thái</th>
                <th style="text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($registrants)): ?>
                <tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">Không tìm thấy dữ liệu phù hợp.</td></tr>
            <?php else: ?>
                <?php foreach ($registrants as $r): ?>
                    <tr>
                        <td><?= e((string)$r['id']) ?></td>
                        <td><strong><?= e($r['name']) ?></strong></td>
                        <td><?= e($r['email']) ?></td>
                        <td><?= e($r['phone']) ?></td>
                        <td><span style="color: #7A6655; font-weight: 500;"><?= e($r['interested_event']) ?></span></td>
                        <td>
                            <?php if ($r['status'] === 'đăng ký mới'): ?><span class="badge badge-blue">Đăng ký mới</span>
                            <?php elseif ($r['status'] === 'đã hủy'): ?><span class="badge badge-red">Đã hủy</span>
                            <?php elseif ($r['status'] === 'đang xét duyệt'): ?><span class="badge badge-yellow">Đang xét duyệt</span>
                            <?php elseif ($r['status'] === 'hoàn tất'): ?><span class="badge badge-green">Hoàn tất</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="/registrants/edit?id=<?= e((string)$r['id']) ?>" style="color: var(--accent); font-weight: bold; text-decoration: none; margin-right: 15px;">✏️</a>
                            <form action="/registrants/delete" method="POST" style="display:inline;" onsubmit="return confirm('Xác nhận xoá hồ sơ khách hàng này?');">
                                <input type="hidden" name="id" value="<?= e((string)$r['id']) ?>">
                                <button type="submit" style="background:none; border:none; color:var(--danger); font-weight:bold; cursor:pointer; font-family:inherit; font-size:14pt; padding:0;">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/registrants?page=<?= $i ?>&q=<?= e($keyword) ?>&sort=<?= e($sort) ?>&direction=<?= e($direction) ?>" class="<?= $page === $i ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>