<?php

require_once __DIR__ . '/../../models/OrderModel.php';
require_once __DIR__ . '/../../models/BookVariant.php';

class CheckoutController
{
    public function index()
    {
        // Hiển thị form checkout nếu cần
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra xem user đã đăng nhập chưa
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=/login');
            exit;
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

        $user = $_SESSION['user'];

        require_once __DIR__ . '/../../views/client/checkout.php';
    }

    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra user đã đăng nhập chưa
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=/login');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];

        // Kiểm tra giỏ hàng có trống không
        if (empty($cart)) {
            $_SESSION['error'] = 'Giỏ hàng của bạn trống!';
            header('Location: index.php?action=/cart');
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];

        // Tính tổng tiền
        $total = 0;
        $variantModel = new BookVariant();

        foreach ($cart as $item) {
            $variant = $variantModel->getVariantById($item['variant_id']);
            if ($variant) {
                $total += $variant['price'] * $item['quantity'];
            }
        }

        $orderModel = new Order();

        // Tạo đơn hàng
        $order_id = $orderModel->createOrder($user_id, $total);

        if (!$order_id) {
            $_SESSION['error'] = 'Không thể tạo đơn hàng. Vui lòng thử lại.';
            header('Location: index.php?action=/cart');
            exit;
        }

        // Tạo chi tiết đơn hàng
        foreach ($cart as $item) {
            $variant = $variantModel->getVariantById($item['variant_id']);
            if ($variant) {
                $orderModel->createOrderDetail(
                    $order_id,
                    $variant['book_id'],
                    $item['variant_id'],
                    $item['quantity'],
                    $variant['price']
                );
            }
        }

        // Xóa giỏ hàng
        unset($_SESSION['cart']);

        $_SESSION['success'] = 'Đặt hàng thành công! Mã đơn hàng: #' . $order_id;

        header('Location: index.php?action=/');
        exit;
    }
}
