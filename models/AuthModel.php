<?php
    class AuthModel extends BaseModel{
        function checkAdmin() {
            if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                header('Location: index.php?action=/user');
                exit("Chỉ admin mới có quyền truy cập trang này.");
            }
        }
        function login() {
            
        }




    
        function findByEmail() {}
        function register() {}
        function verifyPassword() {}
    }

?>