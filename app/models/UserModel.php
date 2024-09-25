<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel
{

    public function getUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM Utilisateur");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            throw new Exception("Erreur lors de l'exécution: " . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Utilisateur WHERE id = ?");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function registerUser($username, $hashedPassword, $email)
    {
        $role = "Client"; // Définir le rôle par défaut

        $stmt = $this->conn->prepare("INSERT INTO Utilisateur (nom, password, email, role) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("ssss", $username, $hashedPassword, $email, $role);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        return true;
    }

    public function authenticateUser($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, nom, password, role FROM Utilisateur WHERE email = ?");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function updateById($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE Utilisateur SET nom=?, prenom=?, email=?, role=?, language=?, auth_provider=? WHERE id=?");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("ssssssi", 
        $data['nom'], 
        $data['prenom'], 
        $data['email'], 
        $data['role'], 
        $data['language'], 
        $data['auth_provider'], 
        $id
    );
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        return true;
    }

    public function deleteById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Utilisateur WHERE id = ?");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    public function getMedecinByUserId($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Article WHERE utilisateur_id = ?");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getSecretaireByUserId($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Boutique WHERE utilisateur_id = ?");
        if ($stmt === false) {
            throw new Exception("Erreur de préparation: " . $this->conn->error);
        }

        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution: " . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

