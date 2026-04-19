<?php
require_once __DIR__ . '/../../models/UserModel.php';
require_once __DIR__ . '/../../models/AuthModel.php';
require_once __DIR__ . '/../../models/OrderModel.php';
class UserController
{
    public $userModel;
    public $authModel;
    public $orderModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
        $this->orderModel = new Order();
    }

    function user()
    {
        $this->authModel->checkAdmin();
        $users = $this->userModel->getAllUsers();
        require_once PATH_VIEW . './admin/user/user.php';
    }

    // Hiển thị trang profile 
    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=/login');
            exit;
        }
        $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?action=/login');
            exit;
        }
        $user = $this->userModel->findById($user_id);
        $orders = $this->orderModel->getOrdersByUserId($user_id);
        require_once PATH_VIEW . './client/profile.php';
    }

    // Cập nhật profile người dùng
    public function profileUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/profile');
            exit;
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=/login');
            exit;
        }

        $user_id = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? null;
        if (!$user_id) {
            header('Location: index.php?action=/login');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (!empty($name) && !empty($email)) {
            $this->userModel->update($user_id, [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address
            ]);

            // Cập nhật session với info mới
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;

            $_SESSION['success'] = 'Cập nhật hồ sơ thành công!';
        }

        header('Location: index.php?action=/profile');
        exit;
    }



    function create()
    {
        $this->authModel->checkAdmin();
        require_once PATH_VIEW . './admin/user/creater.php';
    }
    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->authModel->checkAdmin();
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'] ?? '';
            if (!empty($name) && !empty($email)) {
                $this->userModel->create($name, $email, $phone, $address, $password);
            }
            header('Location: index.php?action=/user');
            exit();
        }
    }
    function edit($id)
    {
        $this->authModel->checkAdmin();
        $user = $this->userModel->findById($id);
        require_once PATH_VIEW . './admin/user/update.php';
    }
    function update($id)
    {
        $this->authModel->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            if (!empty($name) && !empty($email)) {
                $this->userModel->update($id, ['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address]);
            }
            header('Location: index.php?action=/user');
            exit();
        }
    }
    function destroy($id)
    {
        $this->authModel->checkAdmin();
        if (!empty($id)) {
            $this->userModel->delete($id);
        }
        header('Location: index.php?action=/user');
        exit();
    }
}
