<?php
    class Order extends BaseModel
{
    protected $table = 'orders';

    public function getOrders($status = '')
    {
        $sql = "SELECT o.*, u.name, u.email 
                FROM orders o 
                JOIN users u ON o.user_id = u.user_id";

        if ($status != '') {
            $sql .= " WHERE o.status = :status";
        }

        $sql .= " ORDER BY o.order_date DESC";

        $stmt = $this->pdo->prepare($sql);

        if ($status != '') {
            $stmt->bindParam(':status', $status);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOrderById($id)
    {
        $sql = "SELECT o.*, u.name, u.email 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                WHERE o.order_id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($order_id)
    {
        $sql = "SELECT * FROM order_detail WHERE order_id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $order_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE order_id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }
}
?>