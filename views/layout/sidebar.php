<?php
$act = $_GET['act'] ?? '';
?>
<div class="admin-sidebar">
    <div class="brand">Admin</div>

    <a class="menu-item <?= in_array($act, ['admin','']) ? 'active' : '' ?>"
       href="?act=admin">Dashboard</a>

    <a class="menu-item <?= strpos($act,'tour') === 0 ? 'active' : '' ?>"
       href="?act=tour-list">Quản lý Tour</a>

    <a class="menu-item <?= strpos($act,'guide') === 0 ? 'active' : '' ?>"
       href="?act=guide-list">Quản lý HDV</a>

    <a class="menu-item <?= strpos($act,'category') === 0 ? 'active' : '' ?>"
       href="?act=category-list">Quản lý Danh mục</a>

    <a class="menu-item <?= strpos($act,'customer') === 0 ? 'active' : '' ?>"
       href="?act=customer-list">Khách hàng</a>

    <a class="menu-item <?= strpos($act,'booking') === 0 ? 'active' : '' ?>"
       href="?act=booking-list">Quản lý Booking</a>
        </a>
    <a class="menu-item <?= strpos($act,'departure') === 0 ? 'active' : '' ?>"
       href="?act=departure-list">Quản lý lịch khởi hành</a>
        </a>
    </div>
</div>
