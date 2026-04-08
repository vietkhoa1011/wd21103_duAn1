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
        $id = $_POST['id'];
        $status = $_POST['status'];

        $orderModel = new Order();
        $orderModel->updateStatus($id, $status);

        header("Location: ?action=/order");
    }
}  
?>