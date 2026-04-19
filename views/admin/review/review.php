<?php
// Kiểm tra admin
$this->authModel->checkAdmin();

// Thống kê (Giữ nguyên logic PHP của bạn)
$total_pending = $this->reviewModel->countAllReviews('pending');
$total_approved = $this->reviewModel->countAllReviews('approved');
$total_rejected = $this->reviewModel->countAllReviews('rejected');
$total_all = $this->reviewModel->countAllReviews('all');
$status = $_GET['status'] ?? 'all';
$current_page = (int)($_GET['page'] ?? 1);
$total_pages = $total_pages ?? 1;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Review · Admin SmartBooks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
        }

        /* Cấu trúc Wrapper để Fix Sidebar */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        #content {
            flex-grow: 1;
            width: 100%;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        .page-title {
            font-family: 'Playfair Display', serif;
        }

        /* Header tinh tế hơn */
        .page-header {
            background: white;
            padding: 2rem 0;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* Thẻ thống kê */
        .stat-card {
            border-radius: 16px;
            padding: 1.5rem;
            background: white;
            border: 1px solid #f1f5f9;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        /* Bảng & Badge */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-pending {
            background: #fffbeb;
            color: #92400e;
        }

        .status-approved {
            background: #ecfdf5;
            color: #065f46;
        }

        .status-rejected {
            background: #fef2f2;
            color: #991b1b;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
        }

        .filter-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }

        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Responsive cho Sidebar */
        @media (max-width: 992px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
        </nav>

        <div id="content">
            <section class="page-header">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h1 class="page-title mb-1">Quản lý Đánh giá</h1>
                            <p class="text-muted small mb-0">Hệ thống kiểm duyệt phản hồi khách hàng SmartBooks</p>
                        </div>
                        <div class="text-muted">
                            <i class="far fa-calendar-alt me-1"></i> <?= date('d/m/Y') ?>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container-fluid px-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="text-warning mb-2"><i class="fas fa-clock fa-lg"></i></div>
                            <div class="stat-number"><?= $total_pending ?></div>
                            <div class="text-muted small fw-medium">Chờ duyệt</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="text-success mb-2"><i class="fas fa-check-double fa-lg"></i></div>
                            <div class="stat-number"><?= $total_approved ?></div>
                            <div class="text-muted small fw-medium">Đã xuất bản</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="text-danger mb-2"><i class="fas fa-ban fa-lg"></i></div>
                            <div class="stat-number"><?= $total_rejected ?></div>
                            <div class="text-muted small fw-medium">Đã ẩn</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="border-bottom: 3px solid var(--primary-color);">
                            <div class="text-primary mb-2"><i class="fas fa-comments fa-lg"></i></div>
                            <div class="stat-number"><?= $total_all ?></div>
                            <div class="text-muted small fw-medium">Tổng số</div>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">
                        <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?action=/admin/review&status=all" class="filter-btn <?= $status === 'all' ? 'active' : '' ?>">Tất cả</a>
                                <a href="index.php?action=/admin/review&status=pending" class="filter-btn <?= $status === 'pending' ? 'active' : '' ?>">Đang đợi</a>
                                <a href="index.php?action=/admin/review&status=approved" class="filter-btn <?= $status === 'approved' ? 'active' : '' ?>">Công khai</a>
                            </div>
                            <div class="search-box">
                                <input type="text" class="form-control form-control-sm" placeholder="Tìm ID hoặc tên...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Thông tin sách</th>
                                    <th>Người dùng</th>
                                    <th>Đánh giá</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($reviews)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">Không tìm thấy dữ liệu phù hợp.</td>
                                    </tr>
                                    <?php else: foreach ($reviews as $review): ?>
                                        <tr>
                                            <td class="ps-4 text-muted fw-bold">#<?= $review['review_id'] ?></td>
                                            <td>
                                                <div class="fw-semibold text-truncate" style="max-width: 180px;"><?= htmlspecialchars($review['book_title']) ?></div>
                                            </td>
                                            <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($review['user_name']) ?></span></td>
                                            <td>
                                                <div class="text-warning small">
                                                    <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $review['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 small text-muted" title="<?= htmlspecialchars($review['comment']) ?>">
                                                    <?= mb_strimwidth(htmlspecialchars($review['comment']), 0, 60, "...") ?: '<em>Không có nội dung</em>' ?>
                                                </p>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?= $review['status'] ?>">
                                                    <?= $review['status'] == 'pending' ? 'Chờ duyệt' : ($review['status'] == 'approved' ? 'Đã duyệt' : 'Từ chối') ?>
                                                </span>
                                            </td>
                                            <td class="pe-4">
                                                <div class="d-flex gap-2">
                                                    <?php if ($review['status'] !== 'approved'): ?>
                                                        <form method="POST" action="index.php?action=/admin/review/approve">
                                                            <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>">
                                                            <button class="btn-action bg-success bg-opacity-10 text-success" title="Duyệt"><i class="fas fa-check"></i></button>
                                                        </form>
                                                    <?php endif; ?>

                                                    <form method="POST" action="index.php?action=/admin/review/delete" onsubmit="return confirm('Xóa vĩnh viễn đánh giá này?')">
                                                        <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>">
                                                        <button class="btn-action bg-danger bg-opacity-10 text-danger" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_pages > 1): ?>
                        <div class="card-footer bg-white border-0 py-4">
                            <nav>
                                <ul class="pagination pagination-sm justify-content-center mb-0">
                                    <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link border-0 shadow-sm mx-1" href="?action=/admin/review&status=<?= $status ?>&page=<?= $current_page - 1 ?>"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link border-0 shadow-sm mx-1" href="#"><?= $current_page ?></a></li>
                                    <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link border-0 shadow-sm mx-1" href="?action=/admin/review&status=<?= $status ?>&page=<?= $current_page + 1 ?>"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>