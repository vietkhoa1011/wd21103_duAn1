<?php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Đăng ký tài khoản</h2>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($success) ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?action=/register/handle" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="form-control"
                                value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control"
                                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                        <a href="index.php?action=/" class="btn btn-secondary w-100 mt-2">Quay lại trang chủ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>