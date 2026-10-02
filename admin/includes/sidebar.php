<?php $current = basename($_SERVER['PHP_SELF']); ?>
<aside class="sidebar">
    <div class="logo-mini">
        <div class="avatar-wrap">
            <div class="avatar-placeholder">АЕ</div>
            <span class="notification-dot show"></span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="/admin/dashboard.php" class="nav-item <?= $current === 'dashboard.php' ? 'active' : '' ?>">
            <span class="material-symbols-rounded nav-icon">home</span>
            <span class="nav-text">Главная</span>
        </a>

        <a href="/admin/materials.php" class="nav-item <?= $current === 'materials.php' ? 'active' : '' ?>">
            <span class="material-symbols-rounded nav-icon">menu_book</span>
            <span class="nav-text">Материалы</span>
        </a>

        <a href="#" class="nav-item settings-item">
            <span class="material-symbols-rounded nav-icon">display_settings</span>
            <span class="nav-text">Настройки</span>
        </a>
    </nav>
</aside>