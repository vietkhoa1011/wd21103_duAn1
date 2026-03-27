<?php
require_once __DIR__ . '/../controllers/client/HomeController.php';
require_once __DIR__ . '/../controllers/admin/UserController.php';
require_once __DIR__ . '/../controllers/admin/AuthController.php';
require_once __DIR__ . '/../controllers/client/ClientAuthController.php';
require_once __DIR__ . '/../controllers/admin/BookController.php';

$action = $_GET['action'] ?? '/';

switch ($action) {
    case '/':
        (new HomeController)->home();
        break;

    // Admin user
    case '/user':
        (new UserController)->user();
        break;

    case '/user/create':
        (new UserController)->create();
        break;

    case '/user/update':
        (new UserController)->update($_GET['id'] ?? null);
        break;

    case '/user/delete':
        (new UserController)->destroy($_GET['id'] ?? null);
        break;

    // Admin auth
    case '/login':
        (new AuthController)->login();
        break;

    // Client register
    case '/register':
        (new ClientAuthController)->register();
        break;

    // Book
    case '/book':
        (new BookController)->viewBook();
        break;

    case '/book/create':
        (new BookController)->create();
        break;

    case '/book/store':
        (new BookController)->store();
        break;

    case '/book/edit':
        (new BookController)->edit($_GET['id'] ?? null);
        break;

    case '/book/update':
        (new BookController)->update($_GET['id'] ?? null);
        break;

    case '/book/delete':
        (new BookController)->delete($_GET['id'] ?? null);
        break;

    default:
        die('404 - Không tìm thấy trang');
}