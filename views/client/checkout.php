<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$total = $total ?? 0;
$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
    
}
if (!isset($cartItems)) {
    $cartItems = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .hero-img {
            border-radius: 16px;
            transition: all 0.5s ease;
            transform: rotate(3deg) scale(1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: floating 3s ease-in-out infinite;
        }

        .hero-img:hover {
            transform: rotate(0deg) scale(1.05);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(3deg); }
            50% { transform: translateY(-10px) rotate(3deg); }
            100% { transform: translateY(0px) rotate(3deg); }
        }

        .checkout-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .item-row {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .total-row {
            font-size: 18px;
            font-weight: bold;
            color: #dc3545;
            padding: 15px 0;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">
        <a href="index.php" class="navbar-brand fw-bold text-white">
            <i class="fas fa-book-open me-2 text-primary"></i>SmartBooks
        </a>

        <div class="d-none d-md-flex flex-grow-1 mx-5">
            <form method="GET" action="index.php" class="w-100 d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-primary" placeholder="Tìm tên sách, tác giả...">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <a href="index.php?action=/profile" class="btn btn-outline-light ms-3">
                    <i class="fas fa-user"></i>
                </a>

                <a href="index.php?action=/book" class="btn btn-outline-light ms-3" title="Quản lý sách">
                    <i class="fas fa-book-open"></i>
                </a>
                <a href="index.php?action=/cart" class="btn btn-outline-light ms-3 position-relative" title="Giỏ hàng">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if ($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            </form>
        </div>
    </div>
</nav>

<header class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold mb-3">Thanh toán</h1>
                <p class="lead mb-0">Kiểm tra thông tin và hoàn tất đơn hàng của bạn.</p>
            </div>
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="https://images.unsplash.com/photo-1556656793-08538906a9f8?auto=format&fit=crop&q=80&w=600"
                     alt="Checkout Hero"
                     class="img-fluid rounded shadow hero-img"
                     style="max-height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>
</header>

<main class="container checkout-container py-5">
    <div class="row">
        <!-- Thông tin khách hàng -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên</label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user['name'] ?? '') ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số điện thoại</label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Địa chỉ</label>
                        <p class="form-control-plaintext"><?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="order-summary">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="item-row">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <strong><?= htmlspecialchars($item['title'] ?? '') ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($item['format_name'] ?? '') ?> - 
                                            <?= htmlspecialchars($item['language_name'] ?? '') ?>
                                        </small>
                                        <br>
                                        <small class="text-muted">Số lượng: <strong><?= $item['quantity'] ?></strong></small>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div class="fw-bold text-primary">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                        </div>
                                        <small class="text-muted">
                                            <?= number_format($item['price'], 0, ',', '.') ?> đ/cái
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="total-row d-flex justify-content-between">
                        <span>Tổng tiền:</span>
                        <span class="text-danger"><?= number_format($total, 0, ',', '.') ?> đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút hành động -->
    <div class="row mb-5">
        <div class="col-12">
            <form method="POST" action="index.php?action=/checkout/store" class="d-flex gap-3 justify-content-center">
                <a href="index.php?action=/cart" class="btn btn-outline-secondary btn-lg px-5">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                </a>
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-check me-2"></i>Xác nhận đặt hàng
                </button>
            </form>
        </div>
    </div>
</main>

<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div>
                <h4 class="text-white fw-bold h5 mb-3">BookStore</h4>
                <p class="small">Nơi kết nối đam mê đọc sách và lan tỏa tri thức đến mọi người Việt Nam.</p>
            </div>
            <div>
                <h4 class="text-white fw-bold mb-3">Liên kết</h4>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="index.php" class="text-light text-decoration-none">Trang chủ</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Sách mới</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Khuyến mãi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white fw-bold mb-3">Hỗ trợ</h4>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Chính sách vận chuyển</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Đổi trả hàng</a></li>
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white fw-bold mb-3">Đăng ký nhận tin</h4>
                <div class="d-flex flex-column">
                    <input type="email" class="form-control bg-secondary border-0 mb-2 small" placeholder="Email của bạn">
                    <button class="btn btn-primary small fw-bold">Đăng ký</button>
                </div>
            </div>
        </div>
        <div class="border-top border-secondary mt-5 pt-3 text-center small">
            <p>&copy; 2024 BookStore. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
