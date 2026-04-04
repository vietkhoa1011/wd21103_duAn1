<?php
require_once __DIR__ . '/../../models/UserModel.php';
require_once __DIR__ . '/../../models/AuthModel.php';
    class UserController {
        public $userModel;
        public $authModel;
        public function __construct()
        {
            $this->userModel = new UserModel();
            $this->authModel = new AuthModel();
        }
        
        function user() {
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
            $user = $this->userModel->findById($_SESSION['user']['user_id']);
            require_once PATH_VIEW . './client/profile.php';
        }


        
        function create() {
            $this->authModel->checkAdmin();
            require_once PATH_VIEW . './admin/user/creater.php';
        }
        function store() {
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
        function edit($id) {
            $this->authModel->checkAdmin();
            $user = $this->userModel->findById($id);
            require_once PATH_VIEW . './admin/user/update.php';
        }
        function update($id) {
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
        function destroy($id) {
            $this->authModel->checkAdmin();
            if (!empty($id)) {
                $this->userModel->delete($id);
            }
            header('Location: index.php?action=/user');
            exit();
        }
        
    }

?>