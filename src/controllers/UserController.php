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
        $params = array_map('trim', $_GET);
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
            http_response_code(200);
            sendJsonResponse($usersArrayFiltered, 'liste', 200);
        } else {
            http_response_code(200);
            sendJsonResponse($usersArrayFiltered, 'liste vide', 200);
        }
    }

    public function updateUser($userModel)
    {
        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        $id = filter_var($parameters->id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        $nom = trim($parameters->nom);

        if (!isset($id) || !$nom) {
            http_response_code(400);
            return json_encode(["Error" => "input manquants"]);
        }

        $updatedUser = new User();
        $updatedUser->id = $id;
        $updatedUser->nom = $nom;
        $result = $userModel->update($updatedUser);

        if ($result) {
            http_response_code(201);
            sendJsonResponse($updatedUser->objectToArray(), 'utilisateur mis à jour', 201);
        } else {
            http_response_code(500);
            sendJsonResponse($updatedUser->objectToArray(), 'utilisateur non mis à jour', 500);
        }
    }


    public function deleteUser($userModel)
    {
        $users = $userModel->getAllUsers();

        $input = file_get_contents("php://input");
        $parameters = json_decode($input);
        $id = filter_var($parameters->id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

        if (!isset($id)) {
            http_response_code(400);
            return json_encode(["Error" => "input manquants"]);
        }

        $userToDelete = null;

        $userToDelete = $userModel->getUserById($id);
        if ($userToDelete == null) {
            http_response_code(404);
            return json_encode(["Error" => "User non trouvé"]);
        }
        $result = $userModel->delete($userToDelete);

        if ($result) {
            http_response_code(200);
            sendJsonResponse($userToDelete->objectToArray(), 'utilisateur supprimé', 200);
        } else {
            http_response_code(500);
            sendJsonResponse($userToDelete->objectToArray(), 'utilisateur non supprimé', 404);
        }
    }

    public function addUser($userModel)
    {
        $users = $userModel->getAllUsers();
        $newUser = new User();

        $input = file_get_contents("php://input");
        $parameters = json_decode($input);

        $id = filter_var($parameters->id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        $nom = trim($parameters->nom);

        if (!isset($id) || !isset($nom)) {
            http_response_code(400);
            return json_encode(["Error" => "input manquant"]);
        }
        foreach ($users as $user) {
            if ($user->id == $id) {
                http_response_code(400);
                return json_encode(["Error" => "id deja existant"]);
            }
        }
        $newUser->id = $id;
        $newUser->nom = $nom;
        $result = $userModel->create($newUser);
        if ($result) {
            http_response_code(201);
            sendJsonResponse($newUser->objectToArray(), 'utilisateur ajouté', 201);
        } else {
            http_response_code(500);
            sendJsonResponse($newUser->objectToArray(), 'utilisateur non ajouté', 500);
        }
    }
}
