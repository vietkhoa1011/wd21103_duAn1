<?php
class AuthModel extends BaseModel
{
    function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?action=/login');
            exit("Chỉ admin mới có quyền truy cập trang này.");
        }
    }

    function checkLogin()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=/login');
            exit("Bạn cần đăng nhập để truy cập trang này.");
        }
    }

    function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if ($user && $password === $user['password']) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function register($name, $email, $password, $role = 'user')
    {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role
        ]);
    }

    function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
