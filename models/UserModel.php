<?php
    class UserModel extends BaseModel {
        function getAllUsers() {
                $sql = "SELECT * FROM users";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        function findById($id) {
                $sql = "SELECT * FROM users WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        function update($id, $data) {
                $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
        }
        function delete($id) {
                $sql = "DELETE FROM users WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
        }
    }


?>