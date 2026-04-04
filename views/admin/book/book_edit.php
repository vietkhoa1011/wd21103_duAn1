<?php
if (!isset($book)) {
    $book = [];

}
if (!isset($variants)) {
    $variants = [];

}
if (!isset($formats)) {
    $formats = [];

}
if (!isset($languages)) {
    $languages = [];

}
require_once __DIR__ . '/../../../views/client/sidebar.php';
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
    <h2 class="mb-4">Chi tiết sách</h2>

    <form action="index.php?action=/book/update&id=<?= $book['book_id'] ?>" method="POST" enctype="multipart/form-data">
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
            <label class="form-label">Ảnh</label>
            <?php $isUrl = strpos($book['image'], 'http') === 0; ?>
            <div class="mb-2">
                <input type="radio" name="image_type" value="url" id="image_url_radio" <?= $isUrl ? 'checked' : '' ?>>
                <label for="image_url_radio">Nhập URL ảnh</label>
            </div>
            <input type="text" name="image_url" class="form-control" value="<?= $isUrl ? htmlspecialchars($book['image']) : '' ?>" placeholder="Nhập URL ảnh">

            <div class="mb-2 mt-3">
                <input type="radio" name="image_type" value="upload" id="image_upload_radio" <?= !$isUrl ? 'checked' : '' ?>>
                <label for="image_upload_radio">Upload ảnh</label>
            </div>
            <input type="file" name="image_file" class="form-control" accept="image/*" style="display: none;" id="image_file_input">
            <?php if (!$isUrl && !empty($book['image'])): ?>
                <small class="text-muted">Ảnh hiện tại: <?= htmlspecialchars($book['image']) ?></small>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Category ID</label>
            <input type="number" name="category_id" class="form-control" value="<?= htmlspecialchars($book['category_id']) ?>">
        </div>

        
        
        
        <h4 class="mt-4">Biến thể</h4>
        <?php foreach ($variants as $index => $v): ?>
            <div class="border p-3 mb-3 rounded">

                <!-- ID variant -->
                <input type="hidden" name="variants[<?= $index ?>][variant_id]" value="<?= $v['variant_id'] ?>">

                <!-- FORMAT -->
                <div class="mb-2">
                    <label>Format</label>
                    <select name="variants[<?= $index ?>][format_id]" class="form-control">
                        <?php foreach ($formats as $f): ?>
                            <option value="<?= $f['format_id'] ?>"
                                <?= $f['format_id'] == $v['format_id'] ? 'selected' : '' ?>>
                                <?= $f['format_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- LANGUAGE -->
                <div class="mb-2">
                    <label>Language</label>
                    <select name="variants[<?= $index ?>][language_id]" class="form-control">
                        <?php foreach ($languages as $l): ?>
                            <option value="<?= $l['language_id'] ?>"
                                <?= $l['language_id'] == $v['language_id'] ? 'selected' : '' ?>>
                                <?= $l['language_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- PRICE -->
                <div class="mb-2">
                    <label>Giá</label>
                    <input type="number" 
                        name="variants[<?= $index ?>][price]" 
                        class="form-control"
                        value="<?= $v['price'] ?>">
                </div>

            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-warning">Cập nhật</button>
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