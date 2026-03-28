<?php
if (!isset($book)) {
    $book = [];

}
require_once __DIR__ . '/../../views/client/sidebar.php';
?>
<!DOCTYPE html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
    margin-left: 240px;
    padding: 20px;
}
    </style>
    </head>
<body>
<div  class="container py-5 main-content">
    <h2 class="mb-4">Sửa sách</h2>

    <form action="index.php?action=/book/update&id=<?= $book['book_id'] ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($book['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh (link ảnh)</label>
            <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($book['image']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Category ID</label>
            <input type="number" name="category_id" class="form-control" value="<?= htmlspecialchars($book['category_id']) ?>">
        </div>

        <button type="submit" class="btn btn-warning">Cập nhật</button>
        <a href="index.php?action=/book" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>