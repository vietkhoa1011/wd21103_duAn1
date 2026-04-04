<?php
    class BookVariant extends BaseModel
    {
        // lấy variants theo book
        public function getByBookId($book_id)
        {
            $sql = "SELECT 
                        v.*,
                        f.format_name,
                        l.language_name
                    FROM book_variants v
                    JOIN formats f ON v.format_id = f.format_id
                    JOIN languages l ON v.language_id = l.language_id
                    WHERE v.book_id = :book_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':book_id' => $book_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getFormats()
        {   
            return $this->pdo->query("SELECT * FROM formats")->fetchAll();
        }

        public function getLanguages()
        {
            return $this->pdo->query("SELECT * FROM languages")->fetchAll();
        }

        public function insertVariant($book_id, $format_id, $language_id, $price)
        {
            $sql = "INSERT INTO book_variants (book_id, format_id, language_id, price) 
                    VALUES (:book_id, :format_id, :language_id, :price)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':book_id' => $book_id,
                ':format_id' => $format_id,
                ':language_id' => $language_id,
                ':price' => $price
            ]);
        }
    }
?>