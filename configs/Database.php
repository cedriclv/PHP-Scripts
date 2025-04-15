<?php

require __DIR__ . '/config.php';
class Database
{
    public $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    public $username = DB_USERNAME;
    public $password = DB_PASSWORD;
    public $pdo = null;

    public function getConnect()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO($this->dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erreur lors de la connexion" . $e->getMessage();
            }
            return $this->pdo;
        }
    }
}
