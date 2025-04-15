<?php

require __DIR__ . '/../configs/Database.php';
require __DIR__ . '/../models/User.php';

class UserController
{
    public function getUsers($user)
    {
        $users = $user->getAllUsers();
        $usersFiltered = [];
        $params = $_GET;
        foreach ($users as $user) {
            $match = true;
            foreach ($user as $userObjKey => $userObjValue) {
                foreach ($params as $paramObjKey => $paramObjValue) {
                    if ($userObjKey == $paramObjKey && $userObjValue != $paramObjValue) {
                        $match = false;
                    };
                }
            }
            if ($match) {
                array_push($usersFiltered, $user);
            }
        }
        $jsonOutput = json_encode($usersFiltered);
        return $jsonOutput;
    }

    public function updateUser($user)
    {
        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        if (!isset($parameters->id) || !$parameters->nom) {
            http_response_code(400);
            return json_encode(["Error" => "input manquants"]);
        }

        $updatedUser = [
            "id" => $parameters->id,
            "nom" => $parameters->nom
        ];
        $user->update($updatedUser["id"], $updatedUser["nom"]);

        return json_encode($updatedUser);
    }


    public function deleteUser($user)
    {
        $users = $user->getAllUsers();

        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        if (!isset($parameters->id)) {
            http_response_code(400);
            return json_encode(["Error" => "input manquants"]);
        }
        $user->delete($parameters->id);
        $idToDelete = $parameters->id;

        $userToDelete = null;

        foreach ($users as $user) {
            if ($user["id"] == $idToDelete) {
                $userToDelete = $user;
            }
        }

        return json_encode($userToDelete);
    }

    public function addUser($userObj)
    {
        $users = $userObj->getAllUsers();

        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        if (!isset($parameters->id) || !$parameters->nom) {
            http_response_code(400);
            return json_encode(["Error" => "input manquant"]);
        }
        foreach ($users as $user) {
            if ($user["id"] == $parameters->id) {
                http_response_code(200);
                return json_encode(["Error" => "id deja existant"]);
            }
        }
        $newUser = [
            "id" => $parameters->id,
            "nom" => $parameters->nom
        ];
        $userObj->create($newUser["id"], $newUser["nom"]);
        return json_encode($newUser);
    }
}
