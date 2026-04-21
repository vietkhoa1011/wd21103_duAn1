<?php
require_once __DIR__ . '/../../client/sidebar.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 240px;
            padding: 20px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-4 main-content">
        <h2 class="mb-4">Thêm User Mới</h2>

        <div class="card" style="max-width: 600px;">
            <div class="card-body">
                <form method="POST" action="index.php?action=/user/store">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm</button>
                    <a href="index.php?action=/user" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>