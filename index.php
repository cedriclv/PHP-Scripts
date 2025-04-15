<?php
require __DIR__ . '/controllers/UserController.php';

route();

function route()
{
    $userController = new UserController();
    $db = new Database();
    $pdo = $db->getConnect();
    $user = new User($pdo);

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            echo ($userController->getUsers($user));
            break;
        case "POST":
            echo ($userController->addUser($user));
            break;
        case "DELETE":
            echo ($userController->deleteUser($user));
            break;
        case "PUT":
            echo ($userController->updateUser($user));
            break;
        default:
            echo ("mauvaise direction");
    }
}
