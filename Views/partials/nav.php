<header>
    <a href="/" class="logo">🎪 Event CRM</a>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/dashboard">Tổng quan</a>
            <a href="/registrants">Người đăng ký</a>
            <a href="/registrations">Đơn đặt vé</a>
            
            <span style="margin-left: 15px; color: var(--text-muted); font-size: 12pt;">
                👤 <strong><?= e($_SESSION['user_name']) ?></strong>
            </span>
            
            <form action="/logout" method="POST" style="display: inline; margin-left: 10px;">
                <button type="submit" style="background: none; border: none; color: var(--danger); font-weight: bold; cursor: pointer; font-family: inherit; font-size: 14pt; padding: 0;">Đăng xuất</button>
            </form>
        <?php else: ?>
            <a href="/login">🔑 Đăng nhập</a>
        <?php endif; ?>
    </nav>
</header>