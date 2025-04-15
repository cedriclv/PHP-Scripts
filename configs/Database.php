<?php
class Database
{

    public $dsn = 'mysql:host=localhost;dbname=api_users';
    public $username = 'root';
    public $password = 'Nicole-1960';
    public $pdo = null;

    public function getConnect()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            print "Erreur lors de la connexion";
        }
        return $this->pdo;
    }
}
