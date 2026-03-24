<?php
require_once __DIR__ . '/../controllers/client/HomeController.php';
require_once __DIR__ . '/../controllers/admin/UserController.php';
require_once __DIR__ . '/../controllers/admin/AuthController.php';

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'         => (new HomeController)->home(),

    // Admin user
    '/user'     => (new UserController)->user(),
    '/user/create' => (new UserController)->create(),
    '/user/update' => (new UserController)->update($_GET['id'] ?? null),
    '/user/delete' => (new UserController)->destroy($_GET['id'] ?? null),
    // Authentication
    '/login'   => (new AuthController)->login(),
    // '/register'   => (new AuthController)->register(),
    // '/logout'  => (new AuthController)->logout(),
};