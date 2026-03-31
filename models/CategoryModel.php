<?php
    class CategoryModel extends BaseModel{
        public function getAllCategories(){
            $sql = "SELECT * FROM categories";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getCategoryById($id){
            $sql = "SELECT * FROM categories WHERE category_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function insertCategory($category_name){
            $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':category_name' => $category_name]);
        }
        public function updateCategory($id, $category_name){
            $sql = "UPDATE categories SET category_name = :category_name WHERE category_id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id, ':category_name' => $category_name]);
        }
        public function deleteCategory($id){
            $sql = "DELETE FROM categories WHERE category_id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        }
        
    } 

?>