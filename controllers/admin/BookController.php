<?php

require_once __DIR__ . '/../../models/Book.php';

class BookController
{
    private Book $bookModel;

    public function __construct()
    {
        $this->bookModel = new Book();
    }

    public function viewBook(): void
    {
        $books = $this->bookModel->getAllBooks();
        include __DIR__ . '/../../views/admin/book.php';
    }

    public function create(): void
    {
        include __DIR__ . '/../../views/admin/book_create.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $category_id = (int) ($_POST['category_id'] ?? 0);

        // validate đơn giản
        if ($title === '' || $author === '') {
            die('Thiếu dữ liệu');
        }

        $this->bookModel->insertBook($title, $author, $description, $image, $category_id);

        header('Location: index.php?action=/book');
        exit;
    }

    public function edit(int $id): void
    {
        $book = $this->bookModel->getBookById($id);

        if (!$book) {
            die('Không tìm thấy sách');
        }

        include __DIR__ . '/../../views/admin/book_edit.php';
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $category_id = (int) ($_POST['category_id'] ?? 0);

        $this->bookModel->updateBook($id, $title, $author, $description, $image, $category_id);

        header('Location: index.php?action=/book');
        exit;
    }

    public function delete(int $id): void
    {
        $this->bookModel->deleteBook($id);

        header('Location: index.php?action=/book');
        exit;
    }
}