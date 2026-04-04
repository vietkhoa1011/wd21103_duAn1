<?php
require_once __DIR__ . '/../../models/AuthModel.php';

class AuthController
{
    public $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function login()
    {
        require_once PATH_VIEW . '/../views/client/login.php';
    }

    public function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/login');
            exit;
        }

        $email = trim($_POST['email'] ?? ''); 
        $password = trim($_POST['password'] ?? '');

        if ($this->authModel->login($email, $password)) {
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
                header('Location: index.php?action=/book');
            } else {
                header('Location: index.php?action=/');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng';
            header('Location: index.php?action=/login');
            exit;
        }
    }

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
        } elseif ($this->authModel->findByEmail($email)) {
            $errors[] = "Email đã tồn tại";
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

        if ($this->authModel->register($name, $email, $password)) {
            $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            header('Location: index.php?action=/login');
            exit;
        } else {
            $_SESSION['error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
            header('Location: index.php?action=/register');
            exit;
        }
    }

    public function logout()
    {
        $this->authModel->logout();
        header('Location: index.php?action=/login');
        exit;
    }
}
