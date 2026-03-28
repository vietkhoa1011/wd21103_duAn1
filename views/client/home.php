<?php
// --- Load books data ---
$books = $books ?? []; // Ensure $books is defined, or include the data file here
// Example: include '../path/to/books_data.php'; or $books = getBooks();

// --- Lọc theo danh mục và tìm kiếm ---
$selected_category = $_GET['category'] ?? '';
$search_keyword = trim($_GET['search'] ?? '');

$filtered_books = $books;
if (!empty($selected_category)) {
    $filtered_books = array_filter($filtered_books, function($book) use ($selected_category) {
        return $book['category'] === $selected_category;
    });
}
if (!empty($search_keyword)) {
    $filtered_books = array_filter($filtered_books, function($book) use ($search_keyword) {
        return stripos($book['title'], $search_keyword) !== false || stripos($book['author'], $search_keyword) !== false;
    });
}

// --- Phân trang (5 sách/trang) ---
$items_per_page = 6;
$total_items = count($filtered_books);
$total_pages = ceil($total_items / $items_per_page);
$current_page = isset($_GET['page']) ? max(1, min($total_pages, (int)$_GET['page'])) : 1;
$offset = ($current_page - 1) * $items_per_page;

$paginated_books = array_slice($filtered_books, $offset, $items_per_page, true);

// Lấy danh sách danh mục duy nhất cho menu lọc
$categories = array_unique(array_column($books, 'category'));



?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiệm Sách Trực Tuyến - Giao diện người dùng</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        /* Tùy chỉnh thanh phân trang */
        .pagination {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            border-radius: 8px;
            padding: 8px 14px;
        }
        .pagination .active .page-link {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }
        /* Hiệu ứng hover cho card */
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
        }

        /* Hover effect */
        .hero-img:hover {
            transform: rotate(0deg) scale(1.05);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        } 
        .book-float-btn {
            position: fixed;
           
            right: 58px;
            width: 60px;
            height: 60px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: all 0.3s ease;
            border: none;
            outline: none;
        }

        .book-float-btn:hover {
            background: #084298;
            transform: scale(1.1);
            color: white;
        }

        /* Animation khi load trang */
        @keyframes floatUp {
            0% {
                opacity: 0;
                transform: translateY(50px) rotate(3deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotate(3deg);
            }
        }

        .hero-img {
            animation: floatUp 1s ease forwards;
        }
        @keyframes floating {
            0% { transform: translateY(0px) rotate(3deg); }
            50% { transform: translateY(-10px) rotate(3deg); }
            100% { transform: translateY(0px) rotate(3deg); }
        }

        .hero-img {
            animation: floating 3s ease-in-out infinite;
        }
        
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container"> <!-- px-3 để tạo khoảng trống hai bên -->
        <a href="index.php" class="navbar-brand fw-bold text-white">
            <i class="fas fa-book-open me-2 text-primary"></i>SmartBooks
        </a>
        <!-- Thanh tìm kiếm -->
        <div class="d-none d-md-flex flex-grow-1 mx-5">
            <form method="GET" class="w-100 d-flex align-items-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-primary" 
                           placeholder="Tìm tên sách, tác giả..." 
                           value="<?= htmlspecialchars($search_keyword) ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <?php if (!empty($selected_category)): ?>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($selected_category) ?>">
                <?php endif; ?>
                <!-- Icon người bên cạnh thanh tìm kiếm -->
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
<!-- // --- Phần hero --- -->
<header class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="display-4 fw-bold mb-4">Thế giới tri thức <br> trong tầm tay bạn.</h1>
                <p class="lead mb-4">Giảm giá tới 50% cho tất cả các dòng sách văn học trong tháng này.</p>
                <a href="#books" class="btn btn-warning btn-lg rounded-pill fw-bold">
                    Khám phá ngay
                </a>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=600"
                    alt="Hero Book"
                    class="img-fluid rounded shadow hero-img">
            </div>
        </div>
    </div>
</header>




<!-- // --- Lọc theo danh mục và tìm kiếm --- -->
<main class="container py-5" id="books">
    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="card p-3 shadow-sm border sticky-top" style="top: 80px;">
                <h3 class="fw-bold h5 mb-3 pb-2 border-bottom border-secondary">Danh Mục Sách</h3>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="<?= $_SERVER['PHP_SELF'] ?>" class="text-decoration-none d-flex justify-content-between <?= empty($selected_category) ? 'fw-bold text-primary' : 'text-dark' ?>">Tất cả <span class="text-muted">(<?= count($books) ?>)</span></a></li>
                    <?php foreach ($categories as $cat): 
                        $count = count(array_filter($books, fn($b) => $b['category'] === $cat));
                    ?>
                    <li class="mb-3">
                        <a href="?category=<?= urlencode($cat) ?><?= !empty($search_keyword) ? '&search='.urlencode($search_keyword) : '' ?>" class="text-decoration-none d-flex justify-content-between <?= $selected_category === $cat ? 'fw-bold text-primary' : 'text-dark' ?>">
                            <?= htmlspecialchars($cat) ?> <span class="text-muted">(<?= $count ?>)</span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="h4 fw-bold text-dark">Sách Mới Nhất</h2>
                <div class="d-flex gap-2">
                    <span class="text-muted small">Hiển thị <?= count($paginated_books) ?> / <?= $total_items ?> sản phẩm</span>
                </div>
            </div>

            <?php if (empty($paginated_books)): ?>
                <div class="card p-4 text-center border">
                    Không tìm thấy sách nào phù hợp.
                </div>
            <?php else: ?>
            <div class="row g-4">
                <?php foreach ($paginated_books as $book): 
                    $image = $book['image'] ?? 'https://via.placeholder.com/400x250?text=No+Image';
                    $desc = strip_tags($book['description'] ?? '');
                    if (strlen($desc) > 120) $desc = substr($desc, 0, 117) . '...';
                ?>
                <div class="col-md-4 col-sm-6 d-flex align-items-stretch">
                    <div class="book-card card overflow-hidden shadow-sm border h-100 w-100 d-flex flex-column">
                        <div class="position-relative overflow-hidden" style="height: 500px;">
                            <img src="<?= htmlspecialchars($image) ?>" class="card-img-top h-100 w-100 object-fit-cover" alt="<?= htmlspecialchars($book['title']) ?>">
                        </div>
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <p class="text-primary fw-bold text-uppercase small mb-1"><?= htmlspecialchars($book['category'] ?? '') ?></p>
                            <h5 class="card-title fw-bold text-dark mb-2 text-truncate"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="text-muted small mb-3">Tác giả: <?= htmlspecialchars($book['author']) ?></p>
                            <p class="text-muted small mb-3 flex-grow-1"><?= htmlspecialchars($desc) ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-primary fs-5"><?= htmlspecialchars($book['price'] ?? '') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <!-- Phân trang -->
            <?php if ($total_pages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page - 1])) ?>">Trước</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page + 1])) ?>">Sau</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
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
