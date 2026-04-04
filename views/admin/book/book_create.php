<?php require_once __DIR__ . '/../../../views/client/sidebar.php'; ?>
<?php
if (!isset($categories)) {
    $categories = [];
}
if (!isset($formats)) {
    $formats = [];
}
if (!isset($languages)) {
    $languages = [];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 240px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container py-5 main-content">
    <h2 class="mb-4">Thêm sách</h2>

    <form action="index.php?action=/book/store" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <input type="text" name="title" class="form-control">
            <?php if (!empty($errors['title'])): ?>
                <small class="text-danger"><?= $errors['title'] ?></small>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input type="text" name="author" class="form-control">
            <?php if (!empty($errors['author'])): ?>
                <small class="text-danger"><?= $errors['author'] ?></small>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
            <?php if (!empty($errors['description'])): ?>
                <small class="text-danger"><?= $errors['description'] ?></small>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh</label>
            <div class="mb-2">
                <input type="radio" name="image_type" value="url" id="image_url_radio" checked>
                <label for="image_url_radio">Nhập URL ảnh</label>
            </div>
            <input type="text" name="image_url" class="form-control" placeholder="Nhập URL ảnh">

            <div class="mb-2 mt-3">
                <input type="radio" name="image_type" value="upload" id="image_upload_radio">
                <label for="image_upload_radio">Upload ảnh</label>
            </div>
            <input type="file" name="image_file" class="form-control" accept="image/*" style="display: none;" id="image_file_input">
        </div>

        <div class="mb-3">
            <label class="form-label">Category ID</label>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['category_id'] ?>">
                            <?= $cat['category_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <h4 class="mt-4">Biến thể</h4>
        <div class="border p-3 mb-3 rounded" id="variant-0">
            <!-- FORMAT -->
            <div class="mb-2">
                <label>Format</label>
                <select name="variants[0][format_id]" class="form-control">
                    <option value="">-- Chọn format --</option>
                    <?php foreach ($formats as $f): ?>
                        <option value="<?= $f['format_id'] ?>">
                            <?= $f['format_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- LANGUAGE -->
            <div class="mb-2">
                <label>Language</label>
                <select name="variants[0][language_id]" class="form-control">
                    <option value="">-- Chọn ngôn ngữ --</option>
                    <?php foreach ($languages as $l): ?>
                        <option value="<?= $l['language_id'] ?>">
                            <?= $l['language_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- PRICE -->
            <div class="mb-2">
                <label>Giá</label>
                <input type="number" step="0.01" name="variants[0][price]" class="form-control" placeholder="Nhập giá">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Thêm sách</button>
        <a href="index.php?action=/book" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlRadio = document.getElementById('image_url_radio');
    const uploadRadio = document.getElementById('image_upload_radio');
    const urlInput = document.querySelector('input[name="image_url"]');
    const fileInput = document.getElementById('image_file_input');

    function toggleImageInput() {
        if (urlRadio.checked) {
            urlInput.style.display = 'block';
            fileInput.style.display = 'none';
        } else {
            urlInput.style.display = 'none';
            fileInput.style.display = 'block';
        }
    }

    urlRadio.addEventListener('change', toggleImageInput);
    uploadRadio.addEventListener('change', toggleImageInput);

    // Initial state
    toggleImageInput();
});
</script>

</body>
</html>