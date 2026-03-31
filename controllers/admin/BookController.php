<?php

require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/../../models/BookVariant.php';
require_once __DIR__ . '/../../models/CategoryModel.php';

class BookController
{
    private Book $bookModel;
    private BookVariant $variantModel;
    public function __construct()
    {
        $this->bookModel = new Book();
        $this->variantModel = new BookVariant();
    }

    public function viewBook(): void
    {
        $books = $this->bookModel->getAllBooks();
        include __DIR__ . '/../../views/admin/book.php';
    }

    public function create(): void
    {   
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
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
        if ($title === '') {
            $errors['title'] = "Tên sách không được để trống";
        }
        if (strlen($title) < 3) {
            $errors['title'] = "Tên sách phải >= 3 ký tự";
        }
        if ($author === '') {
            $errors['author'] = "Tác giả không được để trống";
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
        $book = $this->bookModel->getBookById($id);
        $variants = $this->variantModel->getByBookId($id);
        $formats = $this->variantModel->getFormats();
        $languages = $this->variantModel->getLanguages();

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