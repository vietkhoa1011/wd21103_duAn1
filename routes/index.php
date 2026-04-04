<?php
require_once __DIR__ . '/../controllers/client/HomeController.php';
require_once __DIR__ . '/../controllers/admin/UserController.php';
require_once __DIR__ . '/../controllers/admin/AuthController.php';
// client auth controller removed - using single AuthController for login/register
require_once __DIR__ . '/../controllers/admin/BookController.php';
require_once __DIR__ . '/../controllers/admin/CategoryController.php';
$action = $_GET['action'] ?? '/';

match ($action) {
    // Client
    '/'         => (new HomeController)->home(),
    '/profile'  => (new UserController)->profile(),

    // Admin user
    '/user'         => (new UserController)->user(),
    '/user/create'  => (new UserController)->create(),
    '/user/store'   => (new UserController)->store(),
    '/user/edit'    => (new UserController)->edit($_GET['id'] ?? null),
    '/user/update'  => (new UserController)->update($_GET['id'] ?? null),
    '/user/delete'  => (new UserController)->destroy($_GET['id'] ?? null),

    // Admin auth
    '/login' => (new AuthController)->login(),
    '/login/handle' => (new AuthController)->handleLogin(),
    '/logout' => (new AuthController)->logout(),

    // Register (single unified)
    '/register' => (new AuthController)->register(),
    '/register/handle' => (new AuthController)->handleRegister(),

    // Book
    '/book'         => (new BookController)->viewBook(),
    '/book/create'  => (new BookController)->create(),  
    '/book/store'   => (new BookController)->store(),
    '/book/edit'    => (new BookController)->edit($_GET['id'] ?? null),
    '/book/update'  => (new BookController)->update($_GET['id'] ?? null),
    '/book/delete'  => (new BookController)->delete($_GET['id'] ?? null),

    //Category
        '/category'         => (new CategoryController)->viewCategory(),
        '/category/create'  => (new CategoryController)->create(),
        '/category/store'   => (new CategoryController)->store(),
        '/category/edit'    => (new CategoryController)->edit($_GET['id'] ?? null),
        '/category/update'  => (new CategoryController)->update($_GET['id'] ?? null),
        '/category/delete'  => (new CategoryController)->delete($_GET['id'] ?? null),

    default => die('404 - Không tìm thấy trang')
};