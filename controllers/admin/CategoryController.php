<?php
require_once __DIR__ . '/../../models/CategoryModel.php';
    class CategoryController
    {
        public $categoryModel;
        public function __construct()
        {
            $this->categoryModel = new CategoryModel();
        }
        public function viewCategory()
        {
            $categories = $this->categoryModel->getAllCategories();
            require_once PATH_VIEW . 'admin/category/category.php';
        }
        public function create(): void
        {
            require_once PATH_VIEW . 'admin/category/create.php';
        }
        public function store()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'] ?? '';
                if (!empty($name)) {
                    $this->categoryModel->insertCategory($name);
                }
                header('Location: index.php?action=/category');
                exit();
            }
        }
        public function edit($id)
        {
            $category = $this->categoryModel->getCategoryById($id);
            require_once PATH_VIEW . 'admin/category/edit.php';
        }
        public function update($id)
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'] ?? '';
                if (!empty($name)) {
                    $this->categoryModel->updateCategory($id, $name);
                }
                header('Location: index.php?action=/category');
                exit();
            }
        }
        public function delete($id)
        {
            $this->categoryModel->deleteCategory($id);
            header('Location: index.php?action=/category');
            exit();
        }
    }

?>