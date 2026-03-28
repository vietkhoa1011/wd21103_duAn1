<?php 
    class HomeModel extends BaseModel
    {
        public function getAllBooks(){
            $sql = "SELECT * FROM books";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>