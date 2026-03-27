<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Thêm sách</h2>

    <form action="index.php?action=/book/store" method="POST">
        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input type="text" name="author" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh (link ảnh)</label>
            <input type="text" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Category ID</label>
            <input type="number" name="category_id" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Thêm sách</button>
        <a href="index.php?action=/book" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>