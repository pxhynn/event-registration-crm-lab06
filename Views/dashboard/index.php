<?php
/** @var int $newRegistrants */
/** @var int $pendingRegistrants */
/** @var int $totalPaidOrders */
/** @var float $totalRevenue */
/** @var array $recentLeads */
/** @var array $summaryEvents */
?>

<h1>Bảng điều khiển quản trị</h1>
<p style="color: var(--text-muted); margin-bottom: 30px;">Số liệu vận hành thời gian thực của các chương trình nghệ thuật và workshop thủ công.</p>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 35px;">
    <div class="card" style="margin: 0; border-top: 4px solid #1E88E5; padding: 20px;">
        <h3 style="margin: 0; font-size: 12pt; color: var(--text-muted); font-weight: normal; text-transform: uppercase;">Đăng ký mới</h3>
        <p style="font-size: 28pt; font-weight: bold; margin: 10px 0 0 0; color: #1E88E5;"><?= $newRegistrants ?></p>
    </div>
    <div class="card" style="margin: 0; border-top: 4px solid var(--warning); padding: 20px;">
        <h3 style="margin: 0; font-size: 12pt; color: var(--text-muted); font-weight: normal; text-transform: uppercase;">Đang phê duyệt</h3>
        <p style="font-size: 28pt; font-weight: bold; margin: 10px 0 0 0; color: var(--warning);"><?= $pendingRegistrants ?></p>
    </div>
    <div class="card" style="margin: 0; border-top: 4px solid var(--success); padding: 20px;">
        <h3 style="margin: 0; font-size: 12pt; color: var(--text-muted); font-weight: normal; text-transform: uppercase;">Đơn vé hoàn thành</h3>
        <p style="font-size: 28pt; font-weight: bold; margin: 10px 0 0 0; color: var(--success);"><?= $totalPaidOrders ?></p>
    </div>
    <div class="card" style="margin: 0; border-top: 4px solid #8E7A67; padding: 20px;">
        <h3 style="margin: 0; font-size: 12pt; color: var(--text-muted); font-weight: normal; text-transform: uppercase;">Tổng doanh thu</h3>
        <p style="font-size: 24pt; font-weight: bold; margin: 14px 0 0 0; color: #4A3E3D;"><?= number_format($totalRevenue, 0, ',', '.') ?>đ</p>
    </div>
</div>

<div style="display: flex; flex-direction: column; gap: 30px;">
    
    <div class="card" style="padding: 25px; margin: 0;">
        <h2 style="font-size: 15pt; margin-top: 0; color: var(--text-primary); margin-bottom: 15px;">👥 Khách hàng tương tác / Thay đổi gần đây</h2>
        <div style="overflow-x: auto;">
            <table style="margin-top: 0;">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Email liên hệ</th>
                        <th>Số điện thoại</th>
                        <th>Chương trình chọn</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentLeads)): ?>
                        <tr><td colspan="5" style="text-align: center; color: var(--text-muted);">Chưa có tương tác nào gần đây.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentLeads as $rl): ?>
                            <tr>
                                <td><strong><?= e($rl['name']) ?></strong></td>
                                <td><?= e($rl['email']) ?></td>
                                <td><?= e($rl['phone']) ?></td>
                                <td><?= e($rl['interested_event']) ?></td>
                                <td>
                                    <?php if ($rl['status'] === 'đăng ký mới'): ?><span class="badge badge-blue">Đăng ký mới</span>
                                    <?php elseif ($rl['status'] === 'đang xét duyệt'): ?><span class="badge badge-yellow">Đang xét duyệt</span>
                                    <?php elseif ($rl['status'] === 'hoàn tất'): ?><span class="badge badge-green">Hoàn tất</span>
                                    <?php else: ?><span class="badge badge-red">Đã hủy</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="padding: 25px; margin: 0;">
        <h2 style="font-size: 15pt; margin-top: 0; color: var(--text-primary); margin-bottom: 15px;">🎪 Danh sách Chương trình Sự kiện & Hiệu suất doanh thu</h2>
        <div style="overflow-x: auto;">
            <table style="margin-top: 0;">
                <thead>
                    <tr>
                        <th>Mã sự kiện</th>
                        <th>Tên chương trình sự kiện / Workshop</th>
                        <th>Giá vé gốc</th>
                        <th>Số vé đã bán</th>
                        <th>Tổng số tiền thu về</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($summaryEvents as $se): ?>
                        <tr>
                            <td><code style="font-size: 11pt; color: var(--danger); font-weight: bold;"><?= e($se['code']) ?></code></td>
                            <td><strong><?= e($se['name']) ?></strong></td>
                            <td><?= number_format($se['price'], 0, ',', '.') ?>đ</td>
                            <td><span style="color: var(--success); font-weight: bold;"><?= $se['total_tickets'] ?> vé</span></td>
                            <td><strong><?= number_format($se['total_amount'], 0, ',', '.') ?>đ</strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>