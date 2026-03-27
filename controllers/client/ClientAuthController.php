<?php

class ClientAuthController
{
    public function register()
    {
        include __DIR__ . '/../../views/client/register.php';
    }

    public function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');

        $errors = [];

        if ($name === '') {
            $errors[] = "Họ tên không được để trống";
        }

        if ($email === '') {
            $errors[] = "Email không được để trống";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không đúng định dạng";
        }

        if ($password === '') {
            $errors[] = "Mật khẩu không được để trống";
        }

        if ($confirm_password === '') {
            $errors[] = "Bạn phải nhập lại mật khẩu";
        }

        if ($password !== $confirm_password) {
            $errors[] = "Mật khẩu nhập lại không khớp";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header('Location: index.php?action=/register');
            exit;
        }

        // Chỗ này sau này m thêm code insert database
        $_SESSION['success'] = "Đăng ký thành công";
        header('Location: index.php?action=/register');
        exit;
    }
}