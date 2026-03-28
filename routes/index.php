<?php
require_once __DIR__ . '/../controllers/client/HomeController.php';
require_once __DIR__ . '/../controllers/admin/UserController.php';
require_once __DIR__ . '/../controllers/admin/AuthController.php';
require_once __DIR__ . '/../controllers/client/ClientAuthController.php';
require_once __DIR__ . '/../controllers/admin/BookController.php';

$action = $_GET['action'] ?? '/';

match ($action) {
    // Client
    '/'         => (new HomeController)->home(),
    '/profile'  => (new UserController)->profile(),

    // Admin user
    '/user'         => (new UserController)->user(),
    '/user/create'  => (new UserController)->create(),
    '/user/update'  => (new UserController)->update($_GET['id'] ?? null),
    '/user/delete'  => (new UserController)->destroy($_GET['id'] ?? null),

    // Admin auth
    '/login' => (new AuthController)->login(),

    // Client register
    '/register' => (new ClientAuthController)->register(),

    // Book
    '/book'         => (new BookController)->viewBook(),
    '/book/create'  => (new BookController)->create(),
    '/book/store'   => (new BookController)->store(),
    '/book/edit'    => (new BookController)->edit($_GET['id'] ?? null),
    '/book/update'  => (new BookController)->update($_GET['id'] ?? null),
    '/book/delete'  => (new BookController)->delete($_GET['id'] ?? null),

    default => die('404 - Không tìm thấy trang')
};