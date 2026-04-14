<?php
// header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tính số lượng sản phẩm trong giỏ hàng
$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
}

// Lấy từ khóa tìm kiếm và danh mục hiện tại để giữ giá trị trong ô input (nếu có)
$search_keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'SmartBooks - Không gian tri thức' ?></title>

    <!-- Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Inter & Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Các style dùng chung (có thể đưa vào file .css riêng) --- */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        h1,
        h2,
        h3,
        h4,
        .navbar-brand,
        .hero-title {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar glassmorphism */
        .navbar {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            color: #4f46e5;
        }

        .navbar .btn-outline-light {
            color: #334155;
            border-color: #e2e8f0;
            background: white;
        }

        .navbar .btn-outline-light:hover {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }

        .navbar .input-group .form-control {
            border-radius: 50px 0 0 50px;
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1.25rem;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .navbar .input-group .btn {
            border-radius: 0 50px 50px 0;
            padding: 0.75rem 1.5rem;
            background: #4f46e5;
            border: 1px solid #4f46e5;
            color: white;
        }

        /* Nút back to top */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #4f46e5;
            color: white;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 25px #4f46e5a0;
            transition: 0.2s;
            z-index: 1000;
            text-decoration: none;
        }

        .back-to-top:hover {
            background: #1e293b;
            color: white;
            transform: translateY(-5px);
        }
    </style>
    <!-- Các style đặc thù của từng trang có thể đặt trong <style> riêng ở trang con -->
</head>

<body>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a href="index.php" class="navbar-brand">
                <i class="fas fa-book-open me-2"></i>SmartBooks
            </a>

            <!-- Desktop search & actions -->
            <div class="d-none d-lg-flex flex-grow-1 mx-5">
                <form method="GET" action="index.php" class="w-100 d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Tìm tên sách, tác giả..."
                            value="<?= htmlspecialchars($search_keyword) ?>">
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <?php if (!empty($selected_category)): ?>
                        <input type="hidden" name="category" value="<?= htmlspecialchars($selected_category) ?>">
                    <?php endif; ?>
                    <a href="index.php?action=/profile" class="btn btn-outline-light ms-3 rounded-4 px-3">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="index.php?action=/book" class="btn btn-outline-light ms-2 rounded-4 px-3" title="Quản lý sách">
                        <i class="fas fa-book-open"></i>
                    </a>
                    <a href="index.php?action=/cart" class="btn btn-outline-light ms-2 rounded-4 px-3 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($cartCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $cartCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php?action=/logout" class="btn btn-outline-light ms-2 rounded-4 px-3" title="Đăng xuất">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    <?php else: ?>
                        <a href="index.php?action=/login" class="btn btn-outline-light ms-2 rounded-4 px-3" title="Đăng nhập">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Mobile toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile">
                <i class="fas fa-bars text-dark"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarMobile">
                <div class="d-lg-none mt-3 w-100">
                    <form method="GET" action="index.php" class="w-100">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Tìm sách..." value="<?= htmlspecialchars($search_keyword) ?>">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="d-flex gap-2 justify-content-around">
                            <a href="index.php?action=/profile" class="btn btn-outline-secondary w-100"><i class="fas fa-user me-1"></i> Tài khoản</a>
                            <a href="index.php?action=/cart" class="btn btn-outline-primary w-100 position-relative">
                                <i class="fas fa-shopping-cart me-1"></i> Giỏ
                                <?php if ($cartCount > 0): ?>
                                    <span class="badge bg-danger ms-1"><?= $cartCount ?></span>
                                <?php endif; ?>
                            </a>
                            <?php if (isset($_SESSION['user'])): ?>
                                <a href="index.php?action=/logout" class="btn btn-outline-danger w-100"><i class="fas fa-sign-out-alt me-1"></i> Đăng xuất</a>
                            <?php else: ?>
                                <a href="index.php?action=/login" class="btn btn-outline-success w-100"><i class="fas fa-sign-in-alt me-1"></i> Đăng nhập</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>