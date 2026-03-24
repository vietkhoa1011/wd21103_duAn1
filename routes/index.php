<?php
require_once __DIR__ . '/../controllers/client/HomeController.php';
require_once __DIR__ . '/../controllers/admin/UserController.php';
require_once __DIR__ . '/../controllers/admin/AuthController.php';

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->home(),
    '/user'     => (new UserController)->user(),
    '/login'   => (new AuthController)->login(),
};