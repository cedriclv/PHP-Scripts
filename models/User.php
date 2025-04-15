<?php
class User
{
    public $id;
    public $nom;
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getAllUsers()
    {
        $query = $this->pdo->prepare("SELECT * FROM USERS");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    function create($newUserId, $newUserName)
    {
        $query = $this->pdo->prepare("INSERT INTO users (id,nom) VALUES (:newUserId, :newUserName)");
        $query->bindParam(':newUserId', $newUserId);
        $query->bindParam(':newUserName', $newUserName);
        $query->execute();
    }

    function update($newUserId, $newUserName)
    {
        $query = $this->pdo->prepare("UPDATE users SET nom = :newUserName WHERE id = :newUserId");
        $query->bindParam(':newUserId', $newUserId);
        $query->bindParam(':newUserName', $newUserName);
        $query->execute();
    }

    function delete($userId)
    {
        $query = $this->pdo->prepare("DELETE FROM users WHERE id = :userId");
        $query->bindParam(':userId', $userId);
        $query->execute();
    }
}
