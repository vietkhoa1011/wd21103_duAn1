<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBooks - Welcome Back</title>
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
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Tùy chỉnh Navbar */
        .navbar {
            background-color: #1a1a1a !important;
            padding: 1rem 0;
        }

        /* Container chính chia 2 cột */
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            max-width: 1000px;
            width: 100%;
            display: flex;
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* Cột bên trái: Form */
        .login-form-side {
            flex: 1;
            padding: 60px;
        }

        .brand-logo {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
        }

        .welcome-text h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #1a1a1a;
        }

        .welcome-text p {
            color: #888;
            margin-bottom: 35px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(123, 66, 255, 0.1);
            border-color: var(--primary-color);
        }

        .btn-signin {
            background-color: var(--primary-color);
            border: none;
            height: 50px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            width: 140px;
            transition: 0.3s;
        }

        .btn-signin:hover {
            background-color: #6030D9;
            transform: translateY(-2px);
        }

        .form-check-label, .forgot-pass {
            font-size: 0.9rem;
            color: #666;
            text-decoration: none;
        }

        /* Cột bên phải: Ảnh */
        .login-image-side {
            flex: 1;
            background: linear-gradient(135deg, #a582f7 0%, #FEF9E7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px;
        }

        .login-image-side img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-image-side { display: none; }
            .login-form-side { padding: 40px 20px; }
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
                    <li class="nav-item"><a class="nav-link" href="#">Sách mới</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Tài khoản</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-form-side">
                <div class="brand-logo">
                    <i class="fas fa-fingerprint me-2"></i> Finnger
                </div>
                
                <div class="welcome-text">
                    <h1>Holla,<br>Welcome Back</h1>
                    <p>Chào mừng bạn trở lại với SmartBooks</p>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger py-2" style="border-radius: 10px;">
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="index.php?action=/login/handle" method="POST">
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-2">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label" for="remember">Nhớ mật khẩu</label>
                        </div>
                        <a href="#" class="forgot-pass">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-signin shadow">Sign In</button>
                </form>

                <div class="mt-5">
                    <span class="text-muted">Tôi chưa có tài khoản?</span>
                    <a href="index.php?action=/register" class="text-primary fw-bold text-decoration-none">Đăng ký</a>
                </div>
            </div>

            <div class="login-image-side">
                <img src="assets/uploads/6848c8_8c305ed722b941ccb5fc0bdfc675a28a_mv2-removebg-preview.png" alt="Illustration">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>