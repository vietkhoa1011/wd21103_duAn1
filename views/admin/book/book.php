<?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
    margin-left: 240px;
    padding: 20px;
}
        .table img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .desc-cell {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .title-cell {
            max-width: 180px;
        }

        .author-cell {
            max-width: 160px;
        }
    </style>
</head>
<body>
<div class="main-content">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Quản lý sách</h1>
        <a href="index.php?action=/book/create" class="btn btn-primary">+ Thêm sách</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th width="80">ID</th>
                            <th>Ảnh</th>
                            <th class="title-cell">Tên sách</th>
                            <th class="author-cell">Tác giả</th>
                            <th class="desc-cell">Mô tả</th>
                            <th width="120">Danh mục</th>
                            <th width="180">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books)): ?>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?= htmlspecialchars($book['book_id']) ?></td>

                                    <td>
                                        <img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                                    </td>

                                    <td class="title-cell">
                                        <?= htmlspecialchars($book['title']) ?>
                                    </td>

                                    <td class="author-cell">
                                        <?= htmlspecialchars($book['author']) ?>
                                    </td>

                                    <td class="desc-cell text-start">
                                        <?= htmlspecialchars($book['description']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($book['category_name']) ?>
                                    </td>
                                    


                                    <td>
                                        <a href="index.php?action=/book/edit&id=<?= $book['book_id'] ?>" class="btn btn-warning btn-sm">Chi tiết</a>
                                        <a href="index.php?action=/book/delete&id=<?= $book['book_id'] ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc muốn xóa sách này không?')">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Chưa có sách nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</div>

</body>
</html>