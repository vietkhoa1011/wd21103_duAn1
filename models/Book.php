<?php

require_once __DIR__ . '/../configs/env.php';

class Book extends BaseModel
{
    // Lấy tất cả sách
    public function getAllBooks()
    {
        $sql = "SELECT books.*, categories.category_name 
                FROM books
                JOIN categories 
                ON books.category_id = categories.category_id
                ORDER BY books.book_id ASC";
                
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy sách theo ID
    public function getBookById($id)
    {
        $sql = "SELECT * FROM books WHERE book_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insertBook($title, $author, $description, $image, $category_id)
    {
        $sql = "INSERT INTO books (title, author, description, image, category_id) 
                VALUES (:title, :author, :description, :image, :category_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':image' => $image,
            ':category_id' => $category_id
        ]);
        return $this->pdo->lastInsertId();
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
        $stmt = $this->pdo->prepare($sql);
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
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}