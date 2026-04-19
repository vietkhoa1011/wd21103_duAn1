<?php
// --- Dữ liệu sách (giả định đã có sẵn từ controller) ---
$image = $book['image'] ?? 'https://via.placeholder.com/500x700?text=No+Image';
$title = $book['title'] ?? 'Chưa có tên sách';
$author = $book['author'] ?? 'Chưa có tác giả';
$description = $book['description'] ?? 'Chưa có mô tả';
$category = $book['category_name'] ?? 'Chưa có danh mục';

// --- Session và giỏ hàng ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
}

// --- Reviews ---
require_once __DIR__ . '/../../models/ReviewModel.php';
$reviewModel = new ReviewModel();
$book_id = $book['book_id'] ?? 0;
$reviews = [];
$average_rating = 0;
$review_count = 0;
$user_can_review = false;
$user_has_reviewed = false;

if ($book_id > 0) {
    // Lấy chỉ approved reviews
    $reviews = $reviewModel->getReviewsByBookId($book_id, true);
    $average_rating = $reviewModel->getAverageRating($book_id);
    $review_count = $reviewModel->getReviewCount($book_id, true);

    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['user_id'];
        $user_can_review = $reviewModel->userCanReview($book_id, $user_id);
        $user_has_reviewed = $reviewModel->userHasReviewed($book_id, $user_id);
    }
}

$pageTitle = htmlspecialchars($book['title'] ?? 'Chi tiết sách') . ' · SmartBooks';
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> · SmartBooks</title>

    <!-- Bootstrap 5 + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Inter & Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
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

        /* ----- Hero section nhẹ nhàng ----- */
        .detail-hero {
            background: linear-gradient(135deg, #f5f7ff 0%, #eef2ff 100%);
            padding: 3rem 0;
            margin-bottom: 2.5rem;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: #0f172a;
        }

        .breadcrumb-custom a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .hero-cover {
            border-radius: 24px;
            box-shadow: 0 30px 40px -15px rgba(79, 70, 229, 0.2);
            border: 4px solid white;
            max-height: 360px;
            width: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .hero-cover:hover {
            transform: scale(1.02);
        }

        /* ----- Card chi tiết ----- */
        .detail-card {
            background: white;
            border-radius: 28px;
            padding: 2rem;
            box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;

        }

        .category-badge {
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 600;
            font-size: 0.8rem;
            padding: 6px 14px;
            border-radius: 40px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .book-title-detail {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            color: #0f172a;
        }

        .author-info {
            font-size: 1.1rem;
            color: #475569;
        }

        .author-info i {
            color: #4f46e5;
            width: 24px;
        }

        .description-text {
            color: #334155;
            line-height: 1.7;
        }

        /* ----- Bảng phiên bản ----- */
        .variants-table {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.02);
        }

        .variants-table thead th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
        }

        .variants-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            background: white;
        }

        .price-tag {
            font-weight: 700;
            color: #0f172a;
            font-size: 1.2rem;
        }

        .btn-soft-primary {
            background: #eef2ff;
            color: #4f46e5;
            border: none;
            font-weight: 600;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            transition: all 0.2s;
        }

        .btn-soft-primary:hover {
            background: #4f46e5;
            color: white;
        }

        .btn-primary-gradient {
            background: linear-gradient(145deg, #4f46e5, #6366f1);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            box-shadow: 0 8px 16px -6px #4f46e580;
            transition: all 0.2s;
        }

        .btn-primary-gradient:hover {
            background: #4338ca;
            box-shadow: 0 10px 20px -5px #4f46e5;
            transform: scale(1.02);
            color: white;
        }

        .btn-outline-secondary-custom {
            border: 1.5px solid #cbd5e1;
            color: #475569;
            border-radius: 40px;
            padding: 0.6rem 1.8rem;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-outline-secondary-custom:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        /* Back to top */
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
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- ==================== HERO ==================== -->
    <section class="detail-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-custom mb-3">
                        <a href="index.php"><i class="fas fa-home me-1"></i>Trang chủ</a>
                        <span class="mx-2 text-muted">/</span>
                        <a href="index.php?category=<?= urlencode($category) ?>"><?= htmlspecialchars($category) ?></a>
                        <span class="mx-2 text-muted">/</span>
                        <span class="text-secondary"><?= htmlspecialchars($title) ?></span>
                    </div>
                    <h1 class="hero-title"><?= htmlspecialchars($title) ?></h1>
                    <p class="lead text-secondary mt-3">Khám phá chi tiết và các phiên bản đặc biệt</p>
                </div>
                <!-- <div class="col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="<?= htmlspecialchars($image) ?>"
                        alt="<?= htmlspecialchars($title) ?>"
                        class="hero-cover img-fluid">
                </div> -->
            </div>
        </div>
    </section>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="container pb-5">
        <div class="row g-5">
            <!-- Cột trái: Ảnh lớn (có thể thêm ảnh khác nếu muốn) -->
            <div class="col-lg-5">
                <div class="position-sticky" style="top: 100px;">
                    <div class="bg-white p-3 rounded-4 shadow-sm border">
                        <img src="<?= htmlspecialchars($image) ?>"
                            alt="<?= htmlspecialchars($title) ?>"
                            class="w-100 rounded-3"
                            style="object-fit: cover; max-height: 600px;">
                    </div>
                    <!-- Thông tin bổ sung (có thể thêm đánh giá sau) -->
                    <div class="mt-4 d-flex gap-2">
                        <span class="badge bg-light text-dark p-3 rounded-4"><i class="far fa-bookmark text-primary me-1"></i> <?= htmlspecialchars($category) ?></span>
                        <span class="badge bg-light text-dark p-3 rounded-4"><i class="far fa-user text-primary me-1"></i> <?= htmlspecialchars($author) ?></span>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Chi tiết và bảng biến thể -->
            <div class="col-lg-7">
                <div class="detail-card">
                    <span class="category-badge mb-3"><i class="far fa-folder-open me-1"></i><?= htmlspecialchars($category) ?></span>
                    <h2 class="book-title-detail mt-3"><?= htmlspecialchars($title) ?></h2>
                    <div class="author-info d-flex align-items-center mt-2 mb-4">
                        <i class="fas fa-feather-alt"></i>
                        <span class="ms-2"><?= htmlspecialchars($author) ?></span>
                    </div>

                    <div class="description-text mb-5">
                        <h5 class="fw-bold mb-3"><i class="fas fa-align-left text-primary me-2"></i>Mô tả sách</h5>
                        <p><?= nl2br(htmlspecialchars($description)) ?></p>
                    </div>

                    <div class="variants-section">
                        <h5 class="fw-bold mb-3"><i class="fas fa-layer-group text-primary me-2"></i>Phiên bản có sẵn</h5>

                        <?php if (!empty($variants)): ?>
                            <div class="table-responsive variants-table">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Định dạng</th>
                                            <th>Ngôn ngữ</th>
                                            <th>Giá bán</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($variants as $variant): ?>
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold"><i class="far fa-file-alt me-1 text-secondary"></i><?= htmlspecialchars($variant['format_name'] ?? 'Bìa mềm') ?></span>
                                                </td>
                                                <td>
                                                    <span><i class="fas fa-globe me-1 text-secondary"></i><?= htmlspecialchars($variant['language_name'] ?? 'Tiếng Việt') ?></span>
                                                </td>
                                                <td>
                                                    <span class="price-tag"><?= number_format($variant['price'] ?? 0, 0, ',', '.') ?> đ</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <a href="index.php?action=/cart/add&variant_id=<?= $variant['variant_id'] ?? 0 ?>"
                                                            class="btn btn-soft-primary">
                                                            <i class="fas fa-cart-plus me-1"></i>Thêm
                                                        </a>
                                                        <a href="index.php?action=/checkout&variant_id=<?= $variant['variant_id'] ?? 0 ?>"
                                                            class="btn btn-primary-gradient">
                                                            Mua ngay
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert bg-light border-0 rounded-4 p-4 text-center">
                                <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                <p class="mb-0">Hiện chưa có phiên bản nào cho cuốn sách này.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-5">
                        <a href="index.php" class="btn btn-outline-secondary-custom">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row g-5 mt-2">
            <div class="col-lg-12">
                <?php include 'includes/review_list.php'; ?>
                <?php include 'includes/review_form.php'; ?>
            </div>
        </div>
    </main>
    <?php
    // Nhúng footer
    include 'includes/footer.php';
    ?>
    <!-- Back to top -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.back-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>