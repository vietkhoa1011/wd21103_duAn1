<?php
    class UserModel extends BaseModel {
        function getAllUsers() {
                $sql = "SELECT * FROM users";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        function findById($id) {
                $sql = "SELECT * FROM users WHERE user_id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        function create($name, $email, $phone = '', $address = '', $password = '') {
                $sql = "INSERT INTO users (name, email, phone, address, password) VALUES (:name, :email, :phone, :address, :password)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password ? password_hash($password, PASSWORD_BCRYPT) : '', PDO::PARAM_STR);
                return $stmt->execute();
        }
        function update($id, $data) {
                $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE user_id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
                $stmt->bindParam(':phone', $data['phone'] ?? '', PDO::PARAM_STR);
                $stmt->bindParam(':address', $data['address'] ?? '', PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
        }
        function delete($id) {
                $sql = "DELETE FROM users WHERE user_id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                return $stmt->execute();
        }
    }


?>