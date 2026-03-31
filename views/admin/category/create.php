<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh Mục Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
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
                        <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-6"> <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 text-primary">
                                <i class="fas fa-plus-circle me-2"></i>Thêm Category mới
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="index.php?action=/category/store">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Tên Category:</label>
                                    <input type="text" 
                                           class="form-control form-control-lg" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Nhập tên danh mục..." 
                                           required>
                                    <div class="form-text">Ví dụ: Điện thoại, Laptop, Phụ kiện...</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-1"></i> Lưu lại
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