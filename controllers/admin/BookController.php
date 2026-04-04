<?php

require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/../../models/BookVariant.php';
require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/AuthModel.php';

class BookController
{
    private Book $bookModel;
    private BookVariant $variantModel;
    private AuthModel $authModel;
    public function __construct()
    {
        $this->bookModel = new Book();
        $this->variantModel = new BookVariant();
        $this->authModel = new AuthModel();
        $this->authModel->checkAdmin();
    }

    private function handleImageUpload(): string
    {
        if (!isset($_FILES['image_file']) || $_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        $file = $_FILES['image_file'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return '';
        }

        $uploadDir = __DIR__ . '/../../assets/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'assets/uploads/' . $fileName;
        }

        return '';
    }

    public function viewBook(): void
    {
        $this->authModel->checkAdmin();
        $books = $this->bookModel->getAllBooks();
        include __DIR__ . '/../../views/admin/book/book.php';
    }

    public function create(): void
    {
        $this->authModel->checkAdmin();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        $formats = $this->variantModel->getFormats();
        $languages = $this->variantModel->getLanguages();
        include __DIR__ . '/../../views/admin/book/book_create.php';
    }

    public function store(): void
    {   
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=/book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = '';
        $category_id = (int) ($_POST['category_id'] ?? 0);

        // Handle image
        $image_type = $_POST['image_type'] ?? 'url';
        if ($image_type === 'url') {
            $image = trim($_POST['image_url'] ?? '');
        } elseif ($image_type === 'upload') {
            $image = $this->handleImageUpload();
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
        if ($author === '') {
            $errors['author'] = "Tác giả không được để trống";
        }
        if ($description === '') {
            $errors['description'] = "Mô tả không được để trống";
        }
        if (!empty($errors)) {
            require_once __DIR__ . '/../../views/admin/book/book_create.php';
            return;
        }



        $book_id = $this->bookModel->insertBook($title, $author, $description, $image, $category_id);

        // Insert variants
        if (isset($_POST['variants']) && is_array($_POST['variants'])) {
            foreach ($_POST['variants'] as $variant) {
                $format_id = (int) ($variant['format_id'] ?? 0);
                $language_id = (int) ($variant['language_id'] ?? 0);
                $price = (float) ($variant['price'] ?? 0);
                if ($format_id > 0 && $language_id > 0 && $price > 0) {
                    $this->variantModel->insertVariant($book_id, $format_id, $language_id, $price);
                }
            }
        }

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

        include __DIR__ . '/../../views/admin/book/book_edit.php';
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
        $image = '';
        $category_id = (int) ($_POST['category_id'] ?? 0);

        // Handle image
        $image_type = $_POST['image_type'] ?? 'url';
        if ($image_type === 'url') {
            $image = trim($_POST['image_url'] ?? '');
        } elseif ($image_type === 'upload') {
            $uploadedImage = $this->handleImageUpload();
            if ($uploadedImage) {
                $image = $uploadedImage;
            } else {
                // Keep existing image if upload failed
                $existingBook = $this->bookModel->getBookById($id);
                $image = $existingBook['image'];
            }
        } else {
            // Keep existing if no change
            $existingBook = $this->bookModel->getBookById($id);
            $image = $existingBook['image'];
        }

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