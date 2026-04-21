<?php
require_once __DIR__ . '/../../models/OrderModel.php';

class OrderController
{
    public function viewOrders()
    {
        $status = $_GET['status'] ?? '';

        $orderModel = new Order();
        $orders = $orderModel->getOrders($status);

        require_once PATH_VIEW . 'admin/order/order.php';
    }
    public function viewOrderDetail()
    {
        $id = $_GET['id'] ?? 0;

        $orderModel = new Order();

        $order = $orderModel->getOrderById($id);
        $orderDetails = $orderModel->getOrderDetails($id);

        require_once PATH_VIEW . 'admin/order/order_detail.php';
    }
    public function updateOrder()
    {
        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;
        $payment_status = $_POST['payment_status'] ?? null;

        $orderModel = new Order();

        // Basic validation
        if (!$id) {
            $_SESSION['error'] = 'ID đơn hàng không hợp lệ.';
            header("Location: ?action=/order");
            exit;
        }

        // Fetch current order
        $order = $orderModel->getOrderById($id);
        if (!$order) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng.';
            header("Location: ?action=/order");
            exit;
        }

        // If already delivered, disallow changes
        if (isset($order['status']) && $order['status'] === 'delivered') {
            $_SESSION['error'] = 'Đơn hàng đã giao - không thể chỉnh sửa.';
            header("Location: ?action=/order/detail&id=" . urlencode($id));
            exit;
        }

        // sanitize/allowlist statuses
        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $allowedPayments = ['unpaid', 'paid'];

        if (!in_array($status, $allowedStatuses)) {
            $_SESSION['error'] = 'Trạng thái không hợp lệ.';
            header("Location: ?action=/order/detail&id=" . urlencode($id));
            exit;
        }

        if ($payment_status === null || !in_array($payment_status, $allowedPayments)) {
            // default to existing payment_status if not provided or invalid
            $payment_status = $order['payment_status'] ?? 'unpaid';
        }

        $orderModel->updateOrder($id, $status, $payment_status);
        $_SESSION['success'] = 'Cập nhật đơn hàng thành công.';
        header("Location: ?action=/order/detail&id=" . urlencode($id));
    }

    public function viewStatistics()
    {
        $orderModel = new Order();

        $dailyStats = $orderModel->getStatistics();
        $monthlyStats = $orderModel->getMonthlyStatistics();
        $totalStats = $orderModel->getTotalStats();

        require_once PATH_VIEW . 'admin/order/statistics.php';
    }
}
