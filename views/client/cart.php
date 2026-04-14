<?php
// cart.php - Sử dụng header và footer dùng chung

// Dữ liệu từ controller
$cartItems = $cartItems ?? [];
$total = $total ?? 0;
$cartCount = count($cartItems); // Số sản phẩm trong giỏ (để hiển thị trong trang)

// Đặt tiêu đề trang
$pageTitle = 'Giỏ hàng · SmartBooks';

// Nhúng header
include __DIR__ . '/includes/header.php';
?>

<!-- ==================== HERO SECTION ==================== -->
<section class="detail-hero" style="background: linear-gradient(135deg, #f5f7ff 0%, #eef2ff 100%); padding: 3rem 0; margin-bottom: 2.5rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="hero-title" style="font-size: 2.8rem; font-weight: 700; color: #0f172a; font-family: 'Playfair Display', serif;">Giỏ hàng của bạn</h1>
                <p class="lead text-secondary mt-3">Xem lại các sản phẩm đã chọn và điều chỉnh số lượng trước khi thanh toán.</p>
            </div>
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=600"
                    alt="Cart Hero"
                    class="hero-cover img-fluid"
                    style="border-radius: 24px; box-shadow: 0 30px 40px -15px rgba(79, 70, 229, 0.2); border: 4px solid white; max-height: 360px; width: auto; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- ==================== MAIN CONTENT ==================== -->
<main class="container pb-5">
    <div class="card shadow-sm border-0" style="border-radius: 24px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="h4 fw-bold text-dark mb-0"><i class="fas fa-shopping-bag text-primary me-2"></i>Danh sách sản phẩm</h2>
                <span class="text-muted small"><i class="far fa-clipboard-list me-1"></i> Hiện có <?= $cartCount ?> sản phẩm</span>
            </div>

            <?php if (empty($cartItems)): ?>
                <div class="alert bg-light border-0 rounded-4 p-5 text-center">
                    <i class="fas fa-cart-shopping fa-3x text-muted mb-3"></i>
                    <h4 class="fw-normal">Giỏ hàng đang trống</h4>
                    <p class="text-muted">Hãy thêm sách vào giỏ để tiếp tục mua sắm.</p>
                    <a href="index.php" class="btn btn-primary-gradient mt-2 px-4 py-2 rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle variants-table" style="border-radius: 20px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,0.02);">
                        <thead style="background: #f8fafc; font-weight: 600; color: #1e293b; border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th style="padding: 1rem;">Ảnh</th>
                                <th style="padding: 1rem;">Tên sách</th>
                                <th style="padding: 1rem;">Phiên bản</th>
                                <th style="padding: 1rem;">Giá</th>
                                <th style="padding: 1rem;">Số lượng</th>
                                <th style="padding: 1rem;">Tạm tính</th>
                                <th style="padding: 1rem;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr style="background: white;">
                                    <td width="90" style="padding: 1rem;">
                                        <img src="<?= htmlspecialchars($item['image'] ?? 'https://via.placeholder.com/70x90?text=No+Image') ?>"
                                            alt="<?= htmlspecialchars($item['title'] ?? '') ?>"
                                            style="width:70px; height:90px; object-fit:cover; border-radius: 12px;">
                                    </td>
                                    <td style="padding: 1rem; font-weight: 500;"><?= htmlspecialchars($item['title'] ?? '') ?></td>
                                    <td style="padding: 1rem;">
                                        <span class="badge bg-light text-dark p-2">
                                            <?= htmlspecialchars($item['format_name'] ?? 'Bìa mềm') ?> ·
                                            <?= htmlspecialchars($item['language_name'] ?? 'Tiếng Việt') ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; font-weight: 600; color: #0f172a;">
                                        <?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="index.php?action=/cart/decrease&variant_id=<?= $item['variant_id'] ?>"
                                                class="btn btn-outline-secondary btn-sm rounded-3" style="width: 32px;">−</a>
                                            <span class="fw-bold"><?= $item['quantity'] ?? 1 ?></span>
                                            <a href="index.php?action=/cart/increase&variant_id=<?= $item['variant_id'] ?>"
                                                class="btn btn-outline-secondary btn-sm rounded-3" style="width: 32px;">+</a>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; font-weight: 700; color: #4f46e5;">
                                        <?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') ?> đ
                                    </td>
                                    <td style="padding: 1rem;">
                                        <a href="index.php?action=/cart/remove&variant_id=<?= $item['variant_id'] ?>"
                                            class="btn btn-soft-danger btn-sm rounded-3"
                                            onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 flex-wrap gap-3">
                    <a href="index.php?action=/cart/clear"
                        class="btn btn-outline-danger rounded-pill px-4"
                        onclick="return confirm('Bạn có muốn xóa toàn bộ giỏ hàng không?')">
                        <i class="fas fa-trash me-2"></i>Xóa toàn bộ
                    </a>

                    <div class="text-end">
                        <h4 class="fw-bold">Tổng tiền:
                            <span class="text-primary" style="font-size: 2rem;"><?= number_format($total, 0, ',', '.') ?> đ</span>
                        </h4>
                        <a href="index.php?action=/checkout" class="btn btn-primary-gradient btn-lg mt-2 px-5 py-3 rounded-pill shadow">
                            Tiến hành thanh toán <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
// Nhúng footer
include __DIR__ . '/includes/footer.php';
?>