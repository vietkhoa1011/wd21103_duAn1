<?php
if (!isset($categories)) {
    $categories = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .main-content { padding: 20px; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
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
                <h1 class="h2">Danh sách Category</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="index.php?action=/category/create" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Thêm mới
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th>Tên danh mục</th>
                                    <th style="width: 20%; text-align: center;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach($categories as $c): ?>
                                    <tr>
                                        <td>#<?= $c['category_id'] ?></td>
                                        <td><strong><?= htmlspecialchars($c['category_name']) ?></strong></td>
                                        <td class="text-center">
                                            <a href="index.php?action=/category/edit&id=<?= $c['category_id'] ?>" 
                                               class="btn btn-sm btn-outline-warning me-1">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="index.php?action=/category/delete&id=<?= $c['category_id'] ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có dữ liệu nào.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>