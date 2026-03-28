<?php
require_once __DIR__ . '/../../models/HomeModel.php';
class HomeController
{   
    public $homeModel;
    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }
    // Hiển thị trang chủ với danh sách sách
    public function home() 
    {   
        // Lấy tất cả sách từ model
        $books = $this->homeModel->getAllBooks();

        // Truyền dữ liệu sách vào view
        require_once PATH_VIEW . './client/home.php';
    }
    


}