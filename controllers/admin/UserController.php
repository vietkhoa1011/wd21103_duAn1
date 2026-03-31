<?php
require_once __DIR__ . '/../../models/UserModel.php';
    class UserController {
        public $userModel;
        public function __construct()
        {
            $this->userModel = new UserModel();
        }
        
        function user() {
            $users = $this->userModel->getAllUsers();
            require_once PATH_VIEW . './admin/user/user.php';
        }

        // Hiển thị trang profile 
        public function profile() 
        {   
            $users = $this->userModel->getAllUsers();

            require_once PATH_VIEW . './client/profile.php';
        }


        
        function create() {
            require_once PATH_VIEW . './admin/user/creater.php';
        }
        function store() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $user = $this->userModel->findById($id);
            require_once PATH_VIEW . './admin/user/update.php';
        }
        function update($id) {
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
            if (!empty($id)) {
                $this->userModel->delete($id);
            }
            header('Location: index.php?action=/user');
            exit();
        }
        
    }

?>