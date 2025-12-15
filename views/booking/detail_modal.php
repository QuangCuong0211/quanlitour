<div class="mb-3">
    <strong>Mã booking:</strong>
    <span class="badge bg-primary"><?= $booking['booking_code'] ?></span>
</div>

<div class="row mb-3">
    <div class="col-md-4"><strong>Người lớn:</strong> <?= $booking['adult'] ?></div>
    <div class="col-md-4"><strong>Trẻ em:</strong> <?= $booking['child'] ?></div>
    <div class="col-md-4">
        <strong>Tổng tiền:</strong>
        <span class="text-danger fw-bold">
            <?= number_format($booking['total_price']) ?> đ
        </span>
    </div>
</div>

<hr>

<h6>Danh sách khách</h6>

<table class="table table-bordered table-sm">
    <thead class="table-light text-center">
        <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Loại</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $i => $c): ?>
        <tr>
            <td class="text-center"><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['phone']) ?></td>
            <td><?= htmlspecialchars($c['email']) ?></td>
            <td class="text-center">
                <span class="badge <?= $c['type']=='adult'?'bg-success':'bg-warning' ?>">
                    <?= $c['type']=='adult'?'Người lớn':'Trẻ em' ?>
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
