<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBooks - Join Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #7B42FF;
            --bg-light: #f8f9fa;
        }

        body {
            background-color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #1a1a1a !important;
            padding: 1rem 0;
        }

        .register-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-container {
            max-width: 1000px;
            width: 100%;
            display: flex;
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* Side Image - Reversed for Register to look different */
        .register-image-side {
            flex: 1;
            background: linear-gradient(135deg, #a582f7 0%, #FEF9E7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px;
        }

        .register-image-side img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));
        }

        /* Form Side */
        .register-form-side {
            flex: 1;
            padding: 50px;
        }

        .welcome-text h1 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 8px;
            color: #1a1a1a;
        }

        .welcome-text p {
            color: #888;
            margin-bottom: 30px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 0 15px;
            margin-bottom: 15px;
            background-color: #fcfcfc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(123, 66, 255, 0.1);
            border-color: var(--primary-color);
            background-color: #fff;
        }

        .btn-signup {
            background-color: var(--primary-color);
            border: none;
            height: 50px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-signup:hover {
            background-color: #6030D9;
            transform: translateY(-2px);
            color: white;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .register-image-side { display: none; }
            .register-form-side { padding: 40px 20px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?action=/"><i class="fas fa-book-open me-2 text-primary"></i>SmartBooks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?action=/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=/login">Đăng nhập</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="register-wrapper">
        <div class="register-container">
            
            <div class="register-image-side">
                <img src="assets/uploads//6848c8_8c305ed722b941ccb5fc0bdfc675a28a_mv2-removebg-preview.png" alt="Registration Illustration">
            </div>

            <div class="register-form-side">
                <div class="welcome-text">
                    <h1>Tạo tài khoản</h1>
                    <p>Khám phá thế giới sách cùng SmartBooks</p>
                </div>

                <?php 
                $errors = $_SESSION['errors'] ?? [];
                $success = $_SESSION['success'] ?? '';
                $old = $_SESSION['old'] ?? [];
                unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);

                if (!empty($errors)): ?>
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success shadow-sm">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=/register/handle" method="POST">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Họ tên</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập họ tên" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-muted">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small fw-bold text-muted">Xác nhận</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-signup shadow">Đăng ký ngay</button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-muted small">Đã có tài khoản?</span>
                    <a href="index.php?action=/login" class="text-primary fw-bold text-decoration-none small"> Đăng nhập</a>
                </div>
                
                <div class="text-center mt-2">
                    <a href="index.php?action=/" class="text-muted text-decoration-none small"><i class="fas fa-arrow-left me-1"></i> Quay lại trang chủ</a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>