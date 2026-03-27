<?php

require_once __DIR__ . '/../../configs/env.php';

class Book
{
    public $conn;

    public function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            die('Lỗi kết nối database: ' . $e->getMessage());
        }
    }

    public function getAllBooks()
    {
        $sql = "SELECT * FROM books";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function getBookById($id)
    {
        $sql = "SELECT * FROM books WHERE book_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insertBook($title, $author, $description, $image, $category_id)
    {
        $sql = "INSERT INTO books (title, author, description, image, category_id) 
                VALUES (:title, :author, :description, :image, :category_id)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':image' => $image,
            ':category_id' => $category_id
        ]);
    }

    public function updateBook($id, $title, $author, $description, $image, $category_id)
    {
        $sql = "UPDATE books 
                SET title = :title,
                    author = :author,
                    description = :description,
                    image = :image,
                    category_id = :category_id
                WHERE book_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':image' => $image,
            ':category_id' => $category_id
        ]);
    }

    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE book_id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}