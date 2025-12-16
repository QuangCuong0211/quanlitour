    <?php
    // views/guide/dashboard.php - Dashboard HDV hoàn chỉnh với thống kê thật
    $act = 'hdv-dashboard';

    ob_start();

    // ID của hướng dẫn viên hiện tại (là user_id trong session)
    $guide_id = $_SESSION['user_id'];

    // Lấy tất cả lịch khởi hành của HDV này
    $departures = pdo_query("
        SELECT d.*, t.name AS tour_name, t.price
        FROM departures d
        JOIN tours t ON d.tour_id = t.id
        WHERE d.guide_id = ?
        ORDER BY d.departure_date ASC
    ", $guide_id);

    // Thống kê
    $total_tours = count($departures);      // Tổng số tour đang dẫn
    $today_tours = 0;                       // Số tour hôm nay
    $total_customers = 0;                   // Tổng số khách
    $estimated_revenue = 0;                 // Ước tính doanh thu

    $today = date('Y-m-d'); // Ngày hiện tại (ví dụ: 2025-12-17)

    foreach ($departures as $dep) {
        // Đếm tour hôm nay
        if ($dep['departure_date'] == $today) {
            $today_tours++;
        }

        // Đếm số khách của tour này
        $cust_count = pdo_query_value("
            SELECT COUNT(*)
            FROM booking_customers bc
            JOIN bookings b ON bc.booking_id = b.id
            WHERE b.tour_id = ? AND b.start_date = ?
        ", $dep['tour_id'], $dep['departure_date']);

        $total_customers += $cust_count;

        // Ước tính doanh thu = số khách × giá tour
        $estimated_revenue += $cust_count * ($dep['price'] ?? 0);
    }
    ?>

    <h4 class="mb-4 text-success fw-bold"><i class="fas fa-tachometer-alt"></i> Dashboard - Thống kê cá nhân</h4>

    <!-- 4 CARD THỐNG KÊ ĐẸP -->
    <div class="stat-grid">
        <div class="stat-card">
            <i class="fas fa-route text-primary"></i>
            <h2><?= $total_tours ?></h2>
            <p>Tour đang dẫn</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-calendar-day text-warning"></i>
            <h2><?= $today_tours ?></h2>
            <p>Tour hôm nay</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-users text-success"></i>
            <h2><?= $total_customers ?></h2>
            <p>Tổng khách hàng</p>
        </div>
        <div class="stat-card">
            <i class="fas fa-dollar-sign text-info"></i>
            <h2><?= number_format($estimated_revenue) ?>đ</h2>
            <p>Ước tính doanh thu</p>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH TOUR SẮP TỚI -->
    <?php if ($total_tours > 0): ?>
    <div class="table-card">
        <h5 class="text-success mb-4"><i class="fas fa-list-alt"></i> Các tour bạn đang dẫn</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên tour</th>
                        <th>Ngày khởi hành</th>
                        <th>Số khách</th>
                        <th>Giá tour</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; foreach ($departures as $dep): 
                        $cust = pdo_query_value("SELECT COUNT(*) FROM booking_customers bc JOIN bookings b ON bc.booking_id = b.id WHERE b.tour_id = ? AND b.start_date = ?", $dep['tour_id'], $dep['departure_date']);
                    ?>
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td><strong><?= htmlspecialchars($dep['tour_name']) ?></strong></td>
                        <td><?= date('d/m/Y', strtotime($dep['departure_date'])) ?></td>
                        <td><span class="badge bg-primary fs-6"><?= $cust ?></span></td>
                        <td><?= number_format($dep['price']) ?>đ</td>
                        <td>
                            <?php if ($dep['departure_date'] == $today): ?>
                                <span class="badge bg-warning text-dark">Hôm nay</span>
                            <?php elseif ($dep['departure_date'] < $today): ?>
                                <span class="badge bg-secondary">Đã qua</span>
                            <?php else: ?>
                                <span class="badge bg-success">Sắp tới</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?act=hdv-customers&departure_id=<?= $dep['id'] ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-users"></i> Xem khách
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center p-5 rounded-4 shadow">
        <i class="fas fa-info-circle fa-3x mb-4 text-info"></i>
        <h4>Chưa có tour nào được phân công</h4>
        <p class="lead">Khi admin gán tour cho bạn qua phần "Quản lý lịch khởi hành", thông tin sẽ hiện ở đây.</p>
    </div>
    <?php endif; ?>

    <!-- LỜI CHÀO -->
    <div class="text-center bg-white p-5 rounded-4 shadow mt-5">
        <h3 class="text-success">Chào mừng quay lại, <?= htmlspecialchars($_SESSION['user_name'] ?? 'HDV') ?>!</h3>
        <p class="lead text-muted">Hôm nay: <strong><?= date('l, d/m/Y') ?></strong> – Chúc bạn dẫn tour vui vẻ!</p>
    </div>

    <?php
    $content = ob_get_clean();
    require "views/guide/layout.php"; // Include layout chung
    ?>