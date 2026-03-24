<?php
    class UserController {
        public $userModel;
        public function __construct()
        {
            $this->userModel = new UserModel();
        }
        function index() {}
        function create() {}
        function store() {}
        function edit($id) {}
        function update($id) {}
        function destroy($id) {}
    }

?>