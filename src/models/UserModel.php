<?php
require_once __DIR__ . '/User.php';

class UserModel
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function arrayToObject() {}

    function getAllUsers()
    {
        $query = $this->pdo->prepare("SELECT * FROM USERS");
        $query->execute();
        $records = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($records as $record) {
            $user = new User();
            $user->id = $record["id"];
            $user->nom = $record["nom"];
            array_push($users, $user);
        }
        return $users;
    }

    function getUserById($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM USERS WHERE id = :userId");
        $query->bindParam(':userId', $id);
        $query->execute();
        $record = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount() > 0) {
            $user = new User();
            $user->id = $record["id"];
            $user->nom = $record["nom"];
            return $user;
        }
        return null;
    }

    function create($newUser)
    {
        $query = $this->pdo->prepare("INSERT INTO users (id,nom) VALUES (:newUserId, :newUserName)");
        $query->bindParam(':newUserId', $newUser->id);
        $query->bindParam(':newUserName', $newUser->nom);
        $query->execute();
    }

    function update($user)
    {
        $query = $this->pdo->prepare("UPDATE users SET nom = :newUserName WHERE id = :newUserId");
        $query->bindParam(':newUserId', $user->id);
        $query->bindParam(':newUserName', $user->nom);
        $query->execute();
    }

    function delete($user)
    {
        $query = $this->pdo->prepare("DELETE FROM users WHERE id = :userId");
        $query->bindParam(':userId', $user->id);
        $query->execute();
    }
}
