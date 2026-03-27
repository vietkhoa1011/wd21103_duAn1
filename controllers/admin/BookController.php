<?php

require_once __DIR__ . '/../../models/admin/Book.php';

class BookController
{
    public function viewBook()
    {
        $bookModel = new Book();
        $books = $bookModel->getAllBooks();

        include __DIR__ . '/../../views/admin/book.php';
    }
     public function create()
    {
        include __DIR__ . '/../../views/admin/book_create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $category_id = trim($_POST['category_id'] ?? '');

        $bookModel = new Book();
        $bookModel->insertBook($title, $author, $description, $image, $category_id);

        header('Location: index.php?action=/book');
        exit;
    }

    public function edit($id)
    {
        if (!$id) {
            die('Thiếu id');
        }

        $bookModel = new Book();
        $book = $bookModel->getBookById($id);

        if (!$book) {
            die('Không tìm thấy sách');
        }

        include __DIR__ . '/../../views/admin/book_edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            header('Location: index.php?action=/book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $category_id = trim($_POST['category_id'] ?? '');

        $bookModel = new Book();
        $bookModel->updateBook($id, $title, $author, $description, $image, $category_id);

        header('Location: index.php?action=/book');
        exit;
    }

    public function delete($id)
    {
        if (!$id) {
            header('Location: index.php?action=/book');
            exit;
        }

        $bookModel = new Book();
        $bookModel->deleteBook($id);

        header('Location: index.php?action=/book');
        exit;
    }
}