<?php 
    class HomeModel extends BaseModel
    {
        public function getAllBooks(){
            $sql = "SELECT books.*, categories.category_name 
                    FROM books
                    JOIN categories 
                    ON books.category_id = categories.category_id
                    ORDER BY books.book_id ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>