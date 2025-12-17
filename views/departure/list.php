<?php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/sidebar.php';
?>

<div class="main-wrapper">
    <div class="container-fluid">
        <div class="page-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Danh Sách Lịch Khởi Hành</h2>
               
            </div>

            <?php if (empty($departures)): ?>
                <p class="text-muted">Chưa có lịch khởi hành nào.</p>
            <?php else: ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour</th>
                            <th>Ngày đi</th>
                            <th>Ngày về</th>
                            <th>HDV</th>
                            <th>Trạng thái</th>
                            <!-- <th width="180">Hành động</th>
                        </tr> -->
                    </thead>
                    <tbody>
                        <?php foreach ($departures as $d): ?>
                            <tr>
                                <td><?= $d['id'] ?></td>
                                <td><?= htmlspecialchars($d['tour_name'] ?? 'N/A') ?></td>
                                <td><?= date('d/m/Y', strtotime($d['departure_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($d['return_date'])) ?></td>
                                <td><?= htmlspecialchars($d['guide_name'] ?? 'Chưa phân') ?></td>
                              
                                <td>
                                    <span class="badge <?= $d['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $d['status'] === 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                    </span>
                                </td>
                                <!-- <td>
                                    <a href="?act=departure-edit&id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="?act=departure-delete&id=<?= $d['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Xóa lịch khởi hành này?')">
                                       Xóa
                                    </a>
                                </td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>
