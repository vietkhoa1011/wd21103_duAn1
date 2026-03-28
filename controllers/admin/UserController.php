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
                // Thực hiện lưu dữ liệu vào database
                // Ví dụ: $this->userModel->create($name, $email);
                // Sau khi lưu xong, chuyển hướng về trang danh sách người dùng
                header('Location: index.php?action=admin/user');
                exit();
            }
        }
        function edit($id) {
            $user = $this->userModel->findById($id);
            require_once PATH_VIEW . './admin/user/edit_user.php';
        }
        function update($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                // Thực hiện cập nhật dữ liệu vào database
                // Ví dụ: $this->userModel->update($id, ['name' => $name, 'email' => $email]);
                // Sau khi cập nhật xong, chuyển hướng về trang danh sách người dùng
                header('Location: index.php?action=admin/user');
                exit();
            }
        }
        function destroy($id) {
            // Thực hiện xóa dữ liệu khỏi database
            // Ví dụ: $this->userModel->delete($id);
            // Sau khi xóa xong, chuyển hướng về trang danh sách người dùng
            header('Location: index.php?action=admin/user');
            exit();
        }
        
    }

?>