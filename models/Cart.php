<?php

require_once __DIR__ . '/BaseModel.php';

class Cart extends BaseModel
{
    public function getCartByUserId($user_id)
    {
        $sql = "SELECT * FROM cart WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCart($user_id)
    {
        $sql = "INSERT INTO cart (user_id) VALUES (:user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $this->pdo->lastInsertId();
    }

    public function getOrCreateCart($user_id)
    {
        $cart = $this->getCartByUserId($user_id);

        if ($cart) {
            return $cart['cart_id'];
        }

        return $this->createCart($user_id);
    }

    public function getCartItem($cart_id, $variant_id)
    {
        $sql = "SELECT * 
                FROM cart_items 
                WHERE cart_id = :cart_id AND variant_id = :variant_id
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':cart_id' => $cart_id,
            ':variant_id' => $variant_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addToCart($cart_id, $book_id, $variant_id, $quantity = 1)
    {
        $item = $this->getCartItem($cart_id, $variant_id);

        if ($item) {
            $sql = "UPDATE cart_items 
                    SET quantity = quantity + :quantity
                    WHERE cart_item_id = :cart_item_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':quantity' => $quantity,
                ':cart_item_id' => $item['cart_item_id']
            ]);
        }

        $sql = "INSERT INTO cart_items (cart_id, book_id, variant_id, quantity)
                VALUES (:cart_id, :book_id, :variant_id, :quantity)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':cart_id' => $cart_id,
            ':book_id' => $book_id,
            ':variant_id' => $variant_id,
            ':quantity' => $quantity
        ]);
    }

    public function getCartItemsByUserId($user_id)
    {
        $sql = "SELECT 
                    ci.cart_item_id,
                    ci.cart_id,
                    ci.book_id,
                    ci.variant_id,
                    ci.quantity,
                    b.title,
                    b.image,
                    bv.price,
                    f.format_name,
                    l.language_name
                FROM cart c
                JOIN cart_items ci ON c.cart_id = ci.cart_id
                JOIN books b ON ci.book_id = b.book_id
                JOIN book_variants bv ON ci.variant_id = bv.variant_id
                JOIN formats f ON bv.format_id = f.format_id
                JOIN languages l ON bv.language_id = l.language_id
                WHERE c.user_id = :user_id
                ORDER BY ci.cart_item_id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuantity($cart_item_id, $quantity)
    {
        $sql = "UPDATE cart_items 
                SET quantity = :quantity
                WHERE cart_item_id = :cart_item_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':quantity' => $quantity,
            ':cart_item_id' => $cart_item_id
        ]);
    }

    public function removeItem($cart_item_id)
    {
        $sql = "DELETE FROM cart_items WHERE cart_item_id = :cart_item_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':cart_item_id' => $cart_item_id
        ]);
    }

    public function clearCart($cart_id)
    {
        $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':cart_id' => $cart_id
        ]);
    }
}