<?php

require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/../../models/BookVariant.php';

class BookDetailController
{
    public function detail()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            die('ID sách không hợp lệ');
        }

        $bookModel = new Book();
        $variantModel = new BookVariant();

        $book = $bookModel->getBookById($id);

        if (!$book) {
            die('Không tìm thấy sách');
        }

        $variants = $variantModel->getByBookId($id);

        require_once __DIR__ . '/../../views/client/detail.php';
    }
}