<?php
    if (!isset($category)) {
        $category = [];
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {  background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .main-content { padding: 20px; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border-radius: 10px; }
        .form-label { font-weight: 600; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý Danh mục</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?action=/category">Danh sách</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card border-warning"> <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 text-warning">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa Category
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="index.php?action=/category/update&id=<?= $category['category_id'] ?? '' ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">ID Danh mục:</label>
                                    <input type="text" class="form-control bg-light" value="<?= $category['category_id'] ?? '' ?>" disabled>
                                </div>

                                <div class="mb-4">
                                    <label for="name" class="form-label">Tên Category:</label>
                                    <input type="text" 
                                           class="form-control form-control-lg" 
                                           id="name" 
                                           name="name" 
                                           value="<?= htmlspecialchars($category['category_name'] ?? '') ?>" 
                                           required>
                                    <div class="form-text">Thay đổi tên danh mục để cập nhật hệ thống.</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">
                                        <i class="fas fa-sync-alt me-1"></i> Cập nhật
                                    </button>
                                    <a href="index.php?action=/category" class="btn btn-outline-secondary px-4">
                                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>