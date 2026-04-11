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
        $sql = "
            SELECT 
                od.order_detail_id,
                od.order_id,
                od.quantity,
                od.price,

                b.title AS book_name,
                b.image,

                f.format_name,
                l.language_name

            FROM order_detail od

            JOIN book_variants bv ON od.variant_id = bv.variant_id
            JOIN books b ON bv.book_id = b.book_id
            JOIN formats f ON bv.format_id = f.format_id
            JOIN languages l ON bv.language_id = l.language_id

            WHERE od.order_id = :id
        ";

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

    public function createOrder($user_id, $total_price, $status = 'pending', $payment_status = 'unpaid')
    {
        $sql = "INSERT INTO orders (user_id, total_price, status, payment_status, order_date) 
                VALUES (:user_id, :total_price, :status, :payment_status, NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_status', $payment_status);

        if ($stmt->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }

    public function createOrderDetail($order_id, $book_id, $variant_id, $quantity, $price)
    {
        $sql = "INSERT INTO order_detail (order_id, book_id, variant_id, quantity, price) 
                VALUES (:order_id, :book_id, :variant_id, :quantity, :price)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->bindParam(':variant_id', $variant_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        return $stmt->execute();
    }
}
?>