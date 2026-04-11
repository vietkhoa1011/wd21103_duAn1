<?php

require_once __DIR__ . '/../../models/BookVariant.php';
require_once __DIR__ . '/../../models/Book.php';

class CartController
{
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $variant_id = $_GET['variant_id'] ?? null;

        if (!$variant_id || !is_numeric($variant_id)) {
            die('Variant không hợp lệ');
        }

        $variantModel = new BookVariant();
        $variant = $variantModel->getVariantById($variant_id);

        if (!$variant) {
            die('Không tìm thấy sản phẩm');
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $key = (string)$variant['variant_id'];

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$key] = [
                'variant_id' => $variant['variant_id'],
                'book_id' => $variant['book_id'],
                'price' => $variant['price'],
                'quantity' => 1,
            ];
        }

        header('Location: index.php?action=/cart');
        exit;
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;

        $variantModel = new BookVariant();

        foreach ($cart as $item) {
            $variant = $variantModel->getVariantById($item['variant_id']);

            if ($variant) {
                $row = [
                    'variant_id' => $variant['variant_id'],
                    'book_id' => $variant['book_id'],
                    'title' => $variant['title'] ?? '',
                    'image' => $variant['image'] ?? '',
                    'format_name' => $variant['format_name'] ?? '',
                    'language_name' => $variant['language_name'] ?? '',
                    'price' => $variant['price'],
                    'quantity' => $item['quantity'],
                ];

                $cartItems[] = $row;
                $total += $row['price'] * $row['quantity'];
            }
        }

        require_once __DIR__ . '/../../views/client/cart.php';
    }

    public function increase()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $variant_id = $_GET['variant_id'] ?? null;

        if ($variant_id && isset($_SESSION['cart'][$variant_id])) {
            $_SESSION['cart'][$variant_id]['quantity'] += 1;
        }

        header('Location: index.php?action=/cart');
        exit;
    }

    public function decrease()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $variant_id = $_GET['variant_id'] ?? null;

        if ($variant_id && isset($_SESSION['cart'][$variant_id])) {
            $_SESSION['cart'][$variant_id]['quantity'] -= 1;

            if ($_SESSION['cart'][$variant_id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$variant_id]);
            }
        }

        header('Location: index.php?action=/cart');
        exit;
    }

    public function remove()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $variant_id = $_GET['variant_id'] ?? null;

        if ($variant_id && isset($_SESSION['cart'][$variant_id])) {
            unset($_SESSION['cart'][$variant_id]);
        }

        header('Location: index.php?action=/cart');
        exit;
    }

    public function clear()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['cart']);

        header('Location: index.php?action=/cart');
        exit;
    }
}