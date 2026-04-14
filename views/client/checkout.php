<?php
// checkout.php - Sử dụng header và footer dùng chung

// Dữ liệu từ controller
$user = $user ?? [];
$cartItems = $cartItems ?? [];
$total = $total ?? 0;

// Đặt tiêu đề trang
$pageTitle = 'Thanh toán · SmartBooks';

// Nhúng header (đã bao gồm session_start() và tính $cartCount)
include __DIR__ . '/includes/header.php';
?>

<!-- ==================== HERO SECTION ==================== -->
<section class="detail-hero" style="background: linear-gradient(135deg, #f5f7ff 0%, #eef2ff 100%); padding: 3rem 0; margin-bottom: 2.5rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="hero-title" style="font-size: 2.8rem; font-weight: 700; color: #0f172a; font-family: 'Playfair Display', serif;">Thanh toán</h1>
                <p class="lead text-secondary mt-3">Kiểm tra thông tin và hoàn tất đơn hàng của bạn.</p>
            </div>
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="https://images.unsplash.com/photo-1556656793-08538906a9f8?auto=format&fit=crop&q=80&w=600"
                    alt="Checkout Hero"
                    class="hero-cover img-fluid"
                    style="border-radius: 24px; box-shadow: 0 30px 40px -15px rgba(79, 70, 229, 0.2); border: 4px solid white; max-height: 360px; width: auto; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- ==================== MAIN CONTENT ==================== -->
<main class="container pb-5" style="max-width: 1000px;">
    <div class="row g-4">
        <!-- Thông tin khách hàng -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 24px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 24px 24px 0 0; background: linear-gradient(145deg, #4f46e5, #6366f1) !important; border: none;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2"></i>Thông tin khách hàng</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-semibold mb-1">Họ và tên</label>
                        <p class="fs-5 fw-semibold mb-0"><?= htmlspecialchars($user['name'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-semibold mb-1">Email</label>
                        <p class="fs-6 mb-0"><?= htmlspecialchars($user['email'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-semibold mb-1">Số điện thoại</label>
                        <p class="fs-6 mb-0"><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                    <div>
                        <label class="text-muted small text-uppercase fw-semibold mb-1">Địa chỉ giao hàng</label>
                        <p class="fs-6 mb-0"><?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 24px;">
                <div class="card-header bg-success text-white py-3" style="border-radius: 24px 24px 0 0; background: linear-gradient(145deg, #10b981, #059669) !important; border: none;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="order-items flex-grow-1">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                                <img src="<?= htmlspecialchars($item['image'] ?? 'https://via.placeholder.com/50x70?text=Book') ?>"
                                    alt="<?= htmlspecialchars($item['title'] ?? '') ?>"
                                    style="width: 50px; height: 70px; object-fit: cover; border-radius: 8px;">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['title'] ?? '') ?></h6>
                                    <p class="small text-muted mb-1">
                                        <?= htmlspecialchars($item['format_name'] ?? '') ?> ·
                                        <?= htmlspecialchars($item['language_name'] ?? '') ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">SL: <?= $item['quantity'] ?></span>
                                        <span class="fw-semibold text-primary">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">Tổng cộng:</span>
                            <span class="fw-bold text-danger fs-3"><?= number_format($total, 0, ',', '.') ?> đ</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0"><i class="fas fa-truck me-1"></i> Phí vận chuyển sẽ được tính sau</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút hành động -->
    <div class="row mt-5">
        <div class="col-12">
            <form method="POST" action="index.php?action=/checkout/store" class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="index.php?action=/cart" class="btn btn-outline-secondary-custom btn-lg px-5 py-3 rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                </a>
                <button type="submit" class="btn btn-primary-gradient btn-lg px-5 py-3 rounded-pill shadow">
                    <i class="fas fa-check-circle me-2"></i>Xác nhận đặt hàng
                </button>
            </form>
        </div>
    </div>
</main>

<?php
// Nhúng footer
include __DIR__ . '/includes/footer.php';
?>