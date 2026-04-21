<?php
// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ?action=/login');
    exit;
}
$totalStats = $totalStats ?? [];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo Doanh thu | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --bg-body: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            display: flex;
        }

        /* Sidebar Container */
        .app-sidebar {
            width: 260px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }

        /* Main Content */
        .app-content {
            margin-left: 260px;
            /* Khớp với width sidebar */
            flex: 1;
            padding: 2rem;
            min-width: 0;
            /* Tránh tràn layout trên mobile */
        }

        .page-header {
            margin-bottom: 2rem;
        }

        /* Stats Card Styling */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .currency-vn {
            color: #10b981;
        }

        /* Tables */
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: #f1f5f9;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem;
            color: var(--text-muted);
            border: none;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
        }

        .btn-back {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: var(--text-main);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #f1f5f9;
            color: var(--primary-color);
        }

        @media (max-width: 992px) {
            .app-sidebar {
                display: none;
            }

            .app-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <aside class="app-sidebar">
        <?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
    </aside>

    <main class="app-content">
        <header class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?action=/order" class="text-decoration-none">Đơn hàng</a></li>
                    <li class="breadcrumb-item active">Báo cáo thống kê</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold">📈 Phân tích kinh doanh</h1>
        </header>

        <?php if ($totalStats): ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">📦 Tổng đơn hàng</div>
                    <div class="stat-value"><?= number_format($totalStats['total_orders'] ?? 0); ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">💰 Tổng doanh thu</div>
                    <div class="stat-value currency-vn"><?= number_format($totalStats['total_revenue'] ?? 0, 0, ',', '.'); ?>đ</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">🛒 Sản phẩm đã bán</div>
                    <div class="stat-value"><?= number_format($totalStats['total_items'] ?? 0); ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">📊 Giá trị TB/Đơn</div>
                    <div class="stat-value" style="color: #6366f1;"><?= number_format($totalStats['avg_order_value'] ?? 0, 0, ',', '.'); ?>đ</div>
                </div>
            </div>
        <?php endif; ?>

        <h2 class="section-title">📅 Thống kê chi tiết hàng ngày</h2>
        <div class="table-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th class="text-center">Số đơn</th>
                        <th class="text-end">Doanh thu</th>
                        <th class="text-center">Sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dailyStats)): ?>
                        <?php foreach ($dailyStats as $stat): ?>
                            <tr>
                                <td class="fw-medium"><?= date('d/m/Y', strtotime($stat['order_date'])); ?></td>
                                <td class="text-center"><?= number_format($stat['total_orders'] ?? 0); ?></td>
                                <td class="text-end fw-bold text-success"><?= number_format($stat['total_revenue'] ?? 0, 0, ',', '.'); ?>đ</td>
                                <td class="text-center"><?= number_format($stat['total_items'] ?? 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Không có dữ liệu phát sinh</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h2 class="section-title">🗓️ Tổng hợp theo tháng</h2>
        <div class="table-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tháng / Năm</th>
                        <th class="text-center">Tổng đơn</th>
                        <th class="text-end">Doanh thu</th>
                        <th class="text-center">Sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($monthlyStats)): ?>
                        <?php foreach ($monthlyStats as $stat): ?>
                            <tr>
                                <td class="fw-medium">
                                    <?php
                                    $date = DateTime::createFromFormat('Y-m', $stat['month']);
                                    echo $date ? $date->format('m / Y') : $stat['month'];
                                    ?>
                                </td>
                                <td class="text-center"><?= number_format($stat['total_orders'] ?? 0); ?></td>
                                <td class="text-end fw-bold text-primary"><?= number_format($stat['total_revenue'] ?? 0, 0, ',', '.'); ?>đ</td>
                                <td class="text-center"><?= number_format($stat['total_items'] ?? 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Chưa có dữ liệu tháng</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mb-5">
            <a href="?action=/order" class="btn-back">
                <span>←</span> Quay lại quản lý đơn hàng
            </a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>