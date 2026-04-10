<?php
$cartCount = count($cartItems ?? []);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .book-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.02);
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
            </form>
        </div>
    </div>
</nav>

<header class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold mb-3">Giỏ hàng của bạn</h1>
                <p class="lead mb-0">Xem lại các sản phẩm đã chọn và điều chỉnh số lượng trước khi thanh toán.</p>
            </div>
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=600"
                     alt="Cart Hero"
                     class="img-fluid rounded shadow hero-img"
                     style="max-height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>
</header>

<main class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="h4 fw-bold text-dark mb-0">Danh sách sản phẩm trong giỏ</h2>
                <span class="text-muted small">Hiện có <?= $cartCount ?> sản phẩm</span>
            </div>

            <?php if (empty($cartItems)): ?>
                <div class="alert alert-warning">Giỏ hàng đang trống.</div>
                <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sách</th>
                                <th>Phiên bản</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tạm tính</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td width="90">
                                        <img src="<?= htmlspecialchars($item['image'] ?? '') ?>"
                                             alt="<?= htmlspecialchars($item['title'] ?? '') ?>"
                                             style="width:70px;height:90px;object-fit:cover;">
                                    </td>
                                    <td><?= htmlspecialchars($item['title'] ?? '') ?></td>
                                    <td>
                                        <?= htmlspecialchars($item['format_name'] ?? '') ?> -
                                        <?= htmlspecialchars($item['language_name'] ?? '') ?>
                                    </td>
                                    <td class="text-primary fw-bold">
                                        <?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="index.php?action=/cart/decrease&variant_id=<?= $item['variant_id'] ?>"
                                               class="btn btn-outline-secondary btn-sm">-</a>

                                            <span class="fw-bold"><?= $item['quantity'] ?? 1 ?></span>

                                            <a href="index.php?action=/cart/increase&variant_id=<?= $item['variant_id'] ?>"
                                               class="btn btn-outline-secondary btn-sm">+</a>
                                        </div>
                                    </td>
                                    <td class="fw-bold">
                                        <?= number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') ?> đ
                                    </td>
                                    <td>
                                        <a href="index.php?action=/cart/remove&variant_id=<?= $item['variant_id'] ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                    <a href="index.php?action=/cart/clear"
                       class="btn btn-outline-danger"
                       onclick="return confirm('Bạn có muốn xóa toàn bộ giỏ hàng không?')">
                        Xóa toàn bộ
                    </a>

                    <div class="text-end">
                        <h4>Tổng tiền:
                            <span class="text-primary fw-bold">
                                <?= number_format($total, 0, ',', '.') ?> đ
                            </span>
                        </h4>
                        <a href="index.php?action=/checkout" class="btn btn-success mt-2">
                            Tiến hành thanh toán
                        </a>
                    </div>
                </div>
            <?php endif; ?>
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