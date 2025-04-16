<?php

require __DIR__ . '/../../configs/Database.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../helpers/helpers.php';

class UserController
{
    public function getUsers($userModel)
    {
        $users = $userModel->getAllUsers();
        $usersArrayFiltered = [];
        $params = $_GET;
        foreach ($users as $user) {
            $match = true;
            foreach (get_object_vars($user) as $userObjKey => $userObjValue) {
                foreach ($params as $paramObjKey => $paramObjValue) {
                    if ($userObjKey == $paramObjKey && $userObjValue != $paramObjValue) {
                        $match = false;
                    };
                }
            }
            if ($match) {
                array_push($usersArrayFiltered, $user->objectToArray());
            }
        }
        if (count($usersArrayFiltered) > 0) {
            sendJsonResponse($usersArrayFiltered, 'liste');
        } else {
            sendJsonResponse($usersArrayFiltered, 'liste vide', 404);
        }
    }

    public function updateUser($userModel)
    {
        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        if (!isset($parameters->id) || !$parameters->nom) {
            http_response_code(400);
            return json_encode(["Error" => "input manquants"]);
        }

        $updatedUser = new User();
        $updatedUser->id = $parameters->id;
        $updatedUser->nom = $parameters->nom;
        $userModel->update($updatedUser);
        if ($updatedUser != null) {
            sendJsonResponse($updatedUser->objectToArray(), 'utilisateur mis à jour');
        } else {
            sendJsonResponse($updatedUser->objectToArray(), 'utilisateur non mis à jour', 404);
        }
    }


    public function deleteUser($userModel)
    {
        $users = $userModel->getAllUsers();

        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        if (!isset($parameters->id)) {
            http_response_code(400);
            return json_encode(["Error" => "input manquants"]);
        }

        $userToDelete = null;

        $userToDelete = $userModel->getUserById($parameters->id);
        $userModel->delete($userToDelete);

        if ($userToDelete != null) {
            sendJsonResponse($userToDelete->objectToArray(), 'utilisateur supprimé');
        } else {
            sendJsonResponse($userToDelete->objectToArray(), 'utilisateur non supprimé', 404);
        }
    }

    public function addUser($userModel)
    {
        $users = $userModel->getAllUsers();
        $newUser = new User();

        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        if (!isset($parameters->id) || !$parameters->nom) {
            http_response_code(400);
            return json_encode(["Error" => "input manquant"]);
        }
        foreach ($users as $user) {
            if ($user->id == $parameters->id) {
                http_response_code(200);
                return json_encode(["Error" => "id deja existant"]);
            }
        }
        $newUser->id = $parameters->id;
        $newUser->nom = $parameters->nom;
        $userModel->create($newUser);
        if ($newUser != null) {
            sendJsonResponse($newUser->objectToArray(), 'utilisateur ajouté');
        } else {
            sendJsonResponse($newUser->objectToArray(), 'utilisateur non ajouté', 404);
        }
    }
}
