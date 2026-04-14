<?php
// profile.php - Sử dụng header và footer dùng chung

// Dữ liệu từ controller
$user = $user ?? [];
$orders = $orders ?? [];

// Đặt tiêu đề trang
$pageTitle = 'Hồ sơ cá nhân · SmartBooks';

// Nhúng header (đã bao gồm session_start() và tính $cartCount)
include __DIR__ . '/includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <!-- ==================== BREADCRUMB & TITLE ==================== -->
    <section class="py-4 bg-white border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hồ sơ của tôi</li>
                </ol>
            </nav>
            <h1 class="hero-title mb-0" style="font-size: 2.5rem;">Xin chào, <?= htmlspecialchars($user['name'] ?? 'bạn') ?>!</h1>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="container py-5">
        <div class="row g-4">
            <!-- Cột trái: Thông tin cơ bản và Avatar -->
            <div class="col-lg-4">
                <!-- Card thông tin cá nhân -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 24px;">
                    <div class="card-body text-center p-4">
                        <img src="https://i.pravatar.cc/300?img=68"
                            alt="Avatar"
                            class="rounded-circle mb-3"
                            style="width: 140px; height: 140px; object-fit: cover; border: 4px solid white; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                        <h4 class="fw-bold mb-1"><?= htmlspecialchars($user['name'] ?? 'Người dùng') ?></h4>
                        <p class="text-muted mb-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                <i class="fas fa-crown me-1"></i>Thành viên Vàng
                            </span>
                        </p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <a href="#orders" class="btn btn-soft-primary btn-sm rounded-pill px-4">
                                <i class="fas fa-box-open me-1"></i>Đơn hàng
                            </a>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                                <i class="fas fa-heart me-1"></i>Yêu thích
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card thống kê -->
                <div class="card shadow-sm border-0" style="border-radius: 24px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-chart-bar text-primary me-2"></i>Thống kê mua sắm</h5>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <span class="text-muted"><i class="fas fa-book text-primary me-2"></i>Sách đã mua</span>
                            <span class="fw-bold"><?= count($orders) ?> cuốn</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <span class="text-muted"><i class="fas fa-star text-warning me-2"></i>Đánh giá</span>
                            <span class="fw-bold">15 lượt</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="fas fa-coins text-success me-2"></i>Điểm tích lũy</span>
                            <span class="fw-bold">1,250 điểm</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Chi tiết và chỉnh sửa -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0" style="border-radius: 24px;">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <ul class="nav nav-pills" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active rounded-pill px-4 py-2 me-2" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab">
                                    <i class="fas fa-info-circle me-1"></i>Thông tin
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 py-2" id="edit-tab" data-bs-toggle="pill" data-bs-target="#edit" type="button" role="tab">
                                    <i class="fas fa-user-edit me-1"></i>Cập nhật hồ sơ
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content" id="profileTabContent">
                            <!-- Tab Tổng quan -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                <h5 class="fw-bold mb-4">Thông tin cá nhân</h5>

                                <div class="row mb-3">
                                    <div class="col-sm-3 fw-semibold">Họ và tên</div>
                                    <div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['name'] ?? '') ?></div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3 fw-semibold">Email</div>
                                    <div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3 fw-semibold">Điện thoại</div>
                                    <div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-3 fw-semibold">Địa chỉ</div>
                                    <div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></div>
                                </div>

                                <!-- Lịch sử đơn hàng gần đây -->
                                <h5 class="fw-bold mt-5 mb-3" id="orders">Đơn hàng gần đây</h5>
                                <?php if (!empty($orders)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle border-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Mã ĐH</th>
                                                    <th>Ngày mua</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order): ?>
                                                    <tr>
                                                        <td><a href="#" class="fw-bold text-decoration-none">#<?= htmlspecialchars($order['order_id']) ?></a></td>
                                                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                                                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                                                        <td class="fw-semibold text-primary"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                                        <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Đã giao</span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert bg-light border-0 rounded-4 p-4 text-center">
                                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                        <p class="mb-0">Bạn chưa có đơn hàng nào.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Tab Chỉnh sửa hồ sơ -->
                            <div class="tab-pane fade" id="edit" role="tabpanel">
                                <form method="POST" action="index.php?action=/profile/update">
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Họ và tên</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                            <input type="text" class="form-control border-start-0 ps-0" name="name"
                                                value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="Nhập họ và tên">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                            <input type="email" class="form-control border-start-0 ps-0" name="email"
                                                value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="Nhập email">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Số điện thoại</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                            <input type="text" class="form-control border-start-0 ps-0" name="phone"
                                                value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                            <textarea class="form-control border-start-0 ps-0" name="address" rows="3"
                                                placeholder="Nhập địa chỉ"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">Hủy</button>
                                        <button type="submit" class="btn btn-primary-gradient rounded-pill px-4">
                                            <i class="fas fa-save me-1"></i>Lưu thay đổi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    // Nhúng footer
    include __DIR__ . '/includes/footer.php';
    ?>
</body>

</html>