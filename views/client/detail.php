<?php
$image = $book['image'] ?? 'https://via.placeholder.com/500x700?text=No+Image';
$title = $book['title'] ?? 'Chưa có tên sách';
$author = $book['author'] ?? 'Chưa có tác giả';
$description = $book['description'] ?? 'Chưa có mô tả';
$category = $book['category_name'] ?? 'Chưa có danh mục';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sách</title>
    
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
                <h1 class="display-5 fw-bold mb-3">Chi tiết sách</h1>
                <p class="lead mb-0">Xem thông tin chi tiết và các phiên bản của sách.</p>
            </div>
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="<?= htmlspecialchars($image) ?>"
                     alt="<?= htmlspecialchars($title) ?>"
                     class="img-fluid rounded shadow hero-img"
                     style="max-height: 320px; object-fit: cover;">
            </div>
        </div>
    </div>
</header>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 overflow-hidden">
                <img src="<?= htmlspecialchars($image) ?>"
                     alt="<?= htmlspecialchars($title) ?>"
                     class="w-100"
                     style="height: 600px; object-fit: cover;">
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <p class="text-primary fw-bold text-uppercase small mb-2">
                        <?= htmlspecialchars($category) ?>
                    </p>

                    <h2 class="fw-bold mb-3"><?= htmlspecialchars($title) ?></h2>

                    <p class="text-muted mb-2">
                        <strong>Tác giả:</strong> <?= htmlspecialchars($author) ?>
                    </p>

                    <div class="mb-4">
                        <h5 class="fw-bold">Mô tả</h5>
                        <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($description)) ?></p>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Phiên bản sách</h5>

                        <?php if (!empty($variants)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Định dạng</th>
                                            <th>Ngôn ngữ</th>
                                            <th>Giá</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($variants as $variant): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($variant['format_name'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($variant['language_name'] ?? '') ?></td>
                                                <td class="fw-bold text-primary">
                                                    <?= number_format($variant['price'] ?? 0, 0, ',', '.') ?> đ
                                                </td>
                                                <td class="d-flex gap-2">
                                                   <a href="index.php?action=/cart/add&variant_id=<?= $variant['variant_id'] ?? 0 ?>" 
                                                    class="btn btn-success btn-sm">
                                                        Thêm vào giỏ hàng
                                                    </a>

                                                    <a href="index.php?action=/checkout&variant_id=<?= $variant['variant_id'] ?? 0 ?>" 
                                                    class="btn btn-primary btn-sm">
                                                        Mua ngay
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0">
                                Sách này hiện chưa có phiên bản nào.
                            </div>
                        <?php endif; ?>
                    </div>

                    <a href="index.php" class="btn btn-outline-secondary">
                        ← Quay lại trang chủ
                    </a>
                </div>
            </div>
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
                    <li class="mb-2"><a href="#" class="text-light text-decoration-none">Trang chủ</a></li>
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