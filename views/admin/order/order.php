<?php
if (!isset($orders)) {
    $orders = [];
}
$current_status = $_GET['status'] ?? '';
?>
<?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --sidebar-width: 250px;
        --dark-blue: #1e2633;
    }

    body {
        background-color: #f4f7f6;
        margin: 0;
    }

    /* Bố cục chính */
    .wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
    }

    /* Sidebar giữ nguyên độ rộng */
    #sidebar {
        min-width: var(--sidebar-width);
        max-width: var(--sidebar-width);
        background: var(--dark-blue);
        color: #fff;
        min-height: 100vh;
        transition: all 0.3s;
    }

    /* Nội dung chính bên phải */
    #content {
        width: 100%;
        padding: 20px 40px;
        transition: all 0.3s;
    }

    /* Header & Filter */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    /* Style cho bảng giống trong ảnh */
    .order-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #fafafa;
        border-bottom: 1px solid #eee;
        padding: 15px;
        font-weight: 600;
        color: #333;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
    }

    /* Status Badge */
    .badge-pending {
        background-color: #ffc107;
        color: white;
        border-radius: 12px;
    }

    .badge-processing {
        background-color: #00d2ff;
        color: white;
        border-radius: 12px;
    }

    .badge-shipped {
        background-color: #0066cc;
        color: white;
        border-radius: 12px;
    }

    .badge-delivered {
        background-color: #28a745;
        color: white;
        border-radius: 12px;
    }

    .badge-cancelled {
        background-color: #dc3545;
        color: white;
        border-radius: 12px;
    }

    .badge-unpaid {
        background-color: #ffc107;
        color: white;
        border-radius: 5px;
    }

    .badge-paid {
        background-color: #28a745;
        color: white;
        border-radius: 5px;
    }
</style>

<div class="wrapper">
    <nav id="sidebar">
        <?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
    </nav>

    <div id="content">
        <header class="page-header">
            <h2 class="fw-bold">Quản lý đơn hàng</h2>

            <form method="GET" action="index.php" class="d-flex align-items-center">
                <span class="me-2 text-muted">Lọc trạng thái:</span>
                <input type="hidden" name="action" value="/order">
                <select name="status" class="form-select border-0 shadow-sm" onchange="this.form.submit()" style="width: 200px;">
                    <option value="" <?= $current_status == '' ? 'selected' : '' ?>>-- Tất cả --</option>
                    <option value="pending" <?= $current_status == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                    <option value="processing" <?= $current_status == 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                    <option value="shipped" <?= $current_status == 'shipped' ? 'selected' : '' ?>>Đang giao</option>
                    <option value="delivered" <?= $current_status == 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                    <option value="cancelled" <?= $current_status == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </form>
        </header>

        <div class="order-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thanh toán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $row): ?>
                            <tr>
                                <td class="fw-bold text-primary">#<?= $row['order_id'] ?></td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($row['email']) ?></div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row['order_date'])) ?></td>
                                <td class="text-danger fw-bold"><?= number_format($row['total_price']) ?>đ</td>
                                <td>
                                    <?php
                                    $status = strtolower($row['status']);
                                    $statusText = match ($status) {
                                        'pending' => 'Chờ xác nhận',
                                        'processing' => 'Đang xử lý',
                                        'shipped' => 'Đang giao',
                                        'delivered' => 'Đã giao',
                                        'cancelled' => 'Đã hủy',
                                        default => ucfirst($status)
                                    };
                                    $badgeClass = match ($status) {
                                        'pending' => 'badge-pending',
                                        'processing' => 'badge-processing',
                                        'shipped' => 'badge-shipped',
                                        'delivered' => 'badge-delivered',
                                        'cancelled' => 'badge-cancelled',
                                        default => 'badge-secondary'
                                    };
                                    ?>

                                    <span class="badge <?= $badgeClass ?> px-3 py-2">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $payment = strtolower($row['payment_status']);

                                    $paymentText = match ($payment) {
                                        'paid' => 'Đã thanh toán',
                                        'unpaid' => 'Chưa thanh toán',
                                        default => ucfirst($payment)
                                    };

                                    $paymentClass = match ($payment) {
                                        'paid' => 'badge-paid',
                                        'unpaid' => 'badge-unpaid',
                                        default => 'badge-secondary'
                                    };
                                    ?>

                                    <span class="badge <?= $paymentClass ?> px-2 py-1">
                                        <?= $paymentText ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?action=/order/detail&id=<?= $row['order_id'] ?>" class="btn btn-outline-secondary btn-sm px-3">Chi tiết</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>