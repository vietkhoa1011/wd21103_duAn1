<?php
class AuthController
{
    public $authModel;
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }
    public function login()
    {
        require_once PATH_VIEW . 'admin/login.php';
    }
}
