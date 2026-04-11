<?php
if (!isset($order)) {
    $order = [];
}
if (!isset($orderDetails)) {
    $orderDetails = [];
}
?>

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

    .wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
    }

    #sidebar {
        min-width: var(--sidebar-width);
        max-width: var(--sidebar-width);
        background: var(--dark-blue);
        color: #fff;
        min-height: 100vh;
        transition: all 0.3s;
    }

    #content {
        width: 100%;
        padding: 20px 40px;
        transition: all 0.3s;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 20px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-weight: 600;
        color: #666;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 16px;
        color: #333;
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

    .badge-pending { background-color: #00d2ff; color: white; border-radius: 12px; padding: 6px 12px; }
    .badge-delivered { background-color: #28a745; color: white; border-radius: 12px; padding: 6px 12px; }
    .badge-cancelled { background-color: #dc3545; color: white; border-radius: 12px; padding: 6px 12px; }
    .badge-unpaid { background-color: #ffc107; color: white; border-radius: 5px; padding: 4px 10px; }
    .badge-paid { background-color: #28a745; color: white; border-radius: 5px; padding: 4px 10px; }

    .action-btn {
        margin-top: 10px;
    }

    .back-link {
        color: #0066cc;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .total-price {
        font-size: 24px;
        color: #dc3545;
        font-weight: bold;
    }
</style>

<div class="wrapper">
    <nav id="sidebar">
        <?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
    </nav>

    <div id="content">
        <a href="?action=/order" class="back-link"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>

        <header class="page-header">
            <h2 class="fw-bold">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_id'] ?? 'N/A') ?></h2>
        </header>

        <!-- Thông tin chung -->
        <div class="detail-card">
            <h5 class="mb-4">Thông tin đơn hàng</h5>
            
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Khách hàng</span>
                    <span class="info-value"><?= htmlspecialchars($order['name'] ?? 'N/A') ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?= htmlspecialchars($order['email'] ?? 'N/A') ?></span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Ngày đặt</span>
                    <span class="info-value"><?= date('d/m/Y H:i', strtotime($order['order_date'] ?? 'now')) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tổng tiền</span>
                    <span class="total-price"><?= number_format($order['total_price'] ?? 0) ?>đ</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Trạng thái giao hàng</span>
                    <span>
                        <span class="badge badge-<?= strtolower($order['status'] ?? 'pending') ?>">
                            <?= ucfirst($order['status'] ?? 'pending') ?>
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Trạng thái thanh toán</span>
                    <span>
                        <span class="badge badge-<?= strtolower(str_replace(' ', '-', $order['payment_status'] ?? 'unpaid')) ?>">
                            <?= htmlspecialchars($order['payment_status'] ?? 'unpaid') ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="detail-card">
            <h5 class="mb-4">Chi tiết sản phẩm</h5>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sách</th>
                            <th>Định dạng</th>
                            <th>Ngôn ngữ</th>
                            <th style="text-align: center;">Số lượng</th>
                            <th style="text-align: right;">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orderDetails)): ?>
                            <?php foreach($orderDetails as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['book_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['format_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['language_name'] ?? '-') ?></td>
                                <td style="text-align: center;"><?= intval($item['quantity'] ?? 0) ?></td>
                                <td style="text-align: right;">
                                    <strong><?= number_format($item['price'] ?? 0) ?>đ</strong>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #ccc;">Không có sản phẩm</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form update trạng thái -->
        <div class="detail-card">
            <h5 class="mb-4">Cập nhật trạng thái</h5>
            
            <form method="POST" action="?action=/order/update" class="d-flex align-items-end gap-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($order['order_id'] ?? '') ?>">
                
                <div class="flex-grow-1">
                    <label class="form-label fw-600">Trạng thái giao hàng</label>
                    <select name="status" class="form-select" required>
                        <option value="pending" <?= ($order['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                        <option value="delivered" <?= ($order['status'] ?? '') == 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                        <option value="cancelled" <?= ($order['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Hủy</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
            </form>
        </div>
    </div>
</div>