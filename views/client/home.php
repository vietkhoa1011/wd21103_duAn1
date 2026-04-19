<?php
// --- Load books data ---
$books = $books ?? []; // Ensure $books is defined, or include the data file here
// Example: include '../path/to/books_data.php'; or $books = getBooks();

// --- Lọc theo danh mục và tìm kiếm ---
$selected_category = $_GET['category'] ?? '';
$search_keyword = trim($_GET['search'] ?? '');

$filtered_books = $books;
if (!empty($selected_category)) {
    $filtered_books = array_filter($filtered_books, function ($book) use ($selected_category) {
        return $book['category_name'] === $selected_category;
    });
}
if (!empty($search_keyword)) {
    $filtered_books = array_filter($filtered_books, function ($book) use ($search_keyword) {
        return stripos($book['title'], $search_keyword) !== false || stripos($book['author'], $search_keyword) !== false;
    });
}

// --- Phân trang (6 sách/trang) ---
$items_per_page = 6;
$total_items = count($filtered_books);
$total_pages = ceil($total_items / $items_per_page);
$current_page = isset($_GET['page']) ? max(1, min($total_pages, (int)$_GET['page'])) : 1;
$offset = ($current_page - 1) * $items_per_page;

$paginated_books = array_slice($filtered_books, $offset, $items_per_page, true);

// Lấy danh sách danh mục duy nhất cho menu lọc
$categories = array_unique(array_column($books, 'category_name'));

// --- Khởi tạo session và giỏ hàng ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    $cartCount = count($_SESSION['cart']);
}
$pageTitle = 'SmartBooks - Thế giới tri thức';
// Nhúng header
include 'includes/header.php';
?>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f9fafb;
    }

    h1,
    h2,
    h3,
    h4,
    .navbar-brand {
        font-family: 'Playfair Display', serif;
    }

    /* Hero section nâng cao */
    .hero-section {
        background: linear-gradient(135deg, #f5f7ff 0%, #eef2ff 100%);
        padding: 4rem 0;
        margin-bottom: 2rem;
    }

    .hero-title {
        font-size: 3.2rem;
        font-weight: 700;
        line-height: 1.2;
        color: #0f172a;
    }

    .hero-highlight {
        color: #4f46e5;
        border-bottom: 3px solid #c7d2fe;
    }

    .hero-img {
        border-radius: 24px;
        box-shadow: 0 30px 40px -15px rgba(79, 70, 229, 0.2);
        transition: all 0.4s ease;
        border: 4px solid white;
    }

    .hero-img:hover {
        transform: scale(1.01) rotate(0.5deg);
        box-shadow: 0 40px 60px -12px #4f46e5;
    }

    /* Sidebar danh mục */
    .category-card {
        background: white;
        border-radius: 24px;
        padding: 1.8rem 1.5rem;
        box-shadow: 0 12px 30px -8px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .category-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
        color: #0f172a;
        border-bottom: 2px dashed #e2e8f0;
        padding-bottom: 0.75rem;
    }

    .category-list {
        list-style: none;
        padding: 0;
    }

    .category-list li {
        margin-bottom: 0.6rem;
    }

    .category-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 1rem;
        border-radius: 16px;
        color: #334155;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        background: transparent;
    }

    .category-list a:hover {
        background: #f8fafc;
        color: #4f46e5;
        transform: translateX(4px);
    }

    .category-list a.active {
        background: #4f46e5;
        color: white;
    }

    .category-list .badge-count {
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
    }

    .category-list a.active .badge-count {
        background: rgba(255, 255, 255, 0.25);
        color: white;
    }

    /* Book Cards */
    .book-grid {
        margin-top: 1rem;
    }

    .book-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.15, 0.75, 0.45, 1);
        box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.06);
        border: 1px solid #f1f5f9;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 35px -12px rgba(79, 70, 229, 0.15);
        border-color: #d9e2ef;
    }

    .book-cover {
        position: relative;
        overflow: hidden;
        aspect-ratio: 3/4;
        background: #f1f5f9;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .book-card:hover .book-cover img {
        transform: scale(1.07);
    }

    .book-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #4f46e5;
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 40px;
        letter-spacing: 0.5px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .book-body {
        padding: 1.5rem 1.2rem 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .book-category {
        color: #4f46e5;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .book-title {
        font-weight: 700;
        font-size: 1.2rem;
        line-height: 1.4;
        color: #0f172a;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .book-desc {
        font-size: 0.85rem;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 1.2rem;
        flex: 1;
    }

    .book-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-soft-primary {
        background: #eef2ff;
        color: #4f46e5;
        border: none;
        font-weight: 600;
        padding: 0.6rem 1rem;
        border-radius: 50px;
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
        padding: 0.6rem 1rem;
        border-radius: 50px;
        box-shadow: 0 8px 16px -6px #4f46e580;
        transition: all 0.2s;
    }

    .btn-primary-gradient:hover {
        background: #4338ca;
        box-shadow: 0 10px 20px -5px #4f46e5;
        transform: scale(1.02);
        color: white;
    }

    /* Pagination */
    .pagination-custom .page-link {
        border: none;
        margin: 0 4px;
        border-radius: 50px !important;
        padding: 0.6rem 1.1rem;
        color: #334155;
        font-weight: 500;
        background: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .pagination-custom .active .page-link {
        background: #4f46e5;
        color: white;
        box-shadow: 0 6px 14px #4f46e580;
    }

    /* Nút quay lại đầu trang */
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

<body>

    <!-- Navbar tinh tế, trong suốt -->

    <!-- Hero section mới mẻ -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill mb-4">
                        <i class="fas fa-sparkles me-1"></i> Ưu đãi độc quyền
                    </span>
                    <h1 class="hero-title">
                        Khám phá <span class="hero-highlight">kho tàng</span> tri thức
                    </h1>
                    <p class="lead text-secondary my-4" style="font-size: 1.2rem;">
                        Hơn 5000+ đầu sách · Giao nhanh 2h · Miễn phí vận chuyển cho đơn từ 300k
                    </p>
                    <a href="#books" class="btn btn-primary-gradient btn-lg px-5 py-3 rounded-pill fw-bold shadow">
                        Mua sắm ngay <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=600"
                        alt="Sách nổi bật"
                        class="img-fluid hero-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <main class="container pb-5" id="books">
        <div class="row g-4">
            <!-- Sidebar Danh mục -->
            <aside class="col-lg-3">
                <div class="category-card sticky-top" style="top: 100px;">
                    <h3 class="category-title"><i class="fas fa-layer-group me-2"></i>Danh mục sách</h3>
                    <ul class="category-list">
                        <li>
                            <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>" class="<?= empty($selected_category) ? 'active' : '' ?>">
                                <span>Tất cả sách</span>
                                <span class="badge-count"><?= count($books) ?></span>
                            </a>
                        </li>
                        <?php foreach ($categories as $cat):
                            $count = count(array_filter($books, fn($b) => $b['category_name'] === $cat));
                        ?>
                            <li>
                                <a href="?category=<?= urlencode($cat) ?><?= !empty($search_keyword) ? '&search=' . urlencode($search_keyword) : '' ?>"
                                    class="<?= $selected_category === $cat ? 'active' : '' ?>">
                                    <?= htmlspecialchars($cat) ?>
                                    <span class="badge-count"><?= $count ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Gợi ý nhỏ -->
                    <div class="mt-4 p-3 bg-light rounded-4 small">
                        <i class="fas fa-truck-fast text-primary me-2"></i>
                        <strong>Freeship</strong> cho đơn hàng từ 300k
                    </div>
                </div>
            </aside>

            <!-- Danh sách sách -->
            <div class="col-lg-9">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <h2 class="h3 fw-bold mb-0" style="font-family: 'Playfair Display';">✨ Sách nổi bật</h2>
                    <span class="text-muted"><i class="far fa-bookmark me-1"></i> <?= $total_items ?> đầu sách</span>
                </div>

                <?php if (empty($paginated_books)): ?>
                    <div class="bg-white p-5 rounded-4 text-center shadow-sm border">
                        <i class="fas fa-book-open fa-3x text-primary opacity-50 mb-3"></i>
                        <h4>Không tìm thấy sách phù hợp</h4>
                        <p class="text-muted">Hãy thử lại với từ khóa khác hoặc chọn danh mục khác.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-4 book-grid">
                        <?php foreach ($paginated_books as $book):
                            $id = $book['book_id'] ?? 0;
                            $image = $book['image'] ?? 'https://via.placeholder.com/400x500?text=Book+Cover';
                            $title = $book['title'] ?? 'Chưa có tên sách';
                            $category = $book['category_name'] ?? 'Chưa phân loại';
                            $author = $book['author'] ?? 'Khuyết danh';
                            $desc = strip_tags($book['description'] ?? '');
                            if (strlen($desc) > 100) $desc = mb_substr($desc, 0, 100) . '...';
                        ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="book-card h-100">
                                    <div class="book-cover">
                                        <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>">
                                        <span class="book-badge"><i class="far fa-star me-1"></i>Bán chạy</span>
                                    </div>
                                    <div class="book-body">
                                        <div class="book-category"><?= htmlspecialchars($category) ?></div>
                                        <h5 class="book-title"><?= htmlspecialchars($title) ?></h5>
                                        <div class="book-author"><i class="fas fa-user-pen me-1"></i><?= htmlspecialchars($author) ?></div>
                                        <p class="book-desc"><?= htmlspecialchars($desc) ?></p>
                                        <div class="book-actions">
                                            <a href="index.php?action=/book/detail&id=<?= $id ?>" class="btn btn-soft-primary flex-fill">
                                                <i class="far fa-eye me-1"></i> Chi tiết
                                            </a>
                                            <a href="index.php?action=/cart&add=<?= $id ?>" class="btn btn-primary-gradient flex-fill">
                                                <i class="fas fa-cart-plus me-1"></i> Mua
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Phân trang đẹp -->
                    <?php if ($total_pages > 1): ?>
                        <nav class="mt-5">
                            <ul class="pagination pagination-custom justify-content-center">
                                <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page - 1])) ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <?php
                                $start = max(1, $current_page - 2);
                                $end = min($total_pages, $current_page + 2);
                                if ($start > 1) echo '<li class="page-item"><span class="page-link">...</span></li>';
                                for ($i = $start; $i <= $end; $i++):
                                ?>
                                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor;
                                if ($end < $total_pages) echo '<li class="page-item"><span class="page-link">...</span></li>';
                                ?>
                                <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page + 1])) ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer chuyên nghiệp -->
    <?php
    // Nhúng footer
    include 'includes/footer.php';
    ?>

    <!-- Nút back to top -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cuộn mượt khi nhấn back to top
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