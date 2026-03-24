<?php
require_once __DIR__ . '/../controllers/client/HomeController.php';
require_once __DIR__ . '/../controllers/admin/AuthController.php';

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->home(),
    '/login'   => (new AuthController)->login(),
};