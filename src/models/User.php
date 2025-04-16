<?php
class User
{
    public $id;
    public $nom;

    public function __construct() {}

    public function objectToArray()
    {
        return [
            "id" => $this->id,
            "nom" => $this->nom
        ];
    }
}
