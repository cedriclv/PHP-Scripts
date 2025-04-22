<?php
require __DIR__ . '/../src/controllers/UserController.php';
require __DIR__ . '/../src/models/UserModel.php';
require __DIR__ . '/../src/helpers/AuthHelper.php';

route();

function route()
{
    AuthHelper::checkAuth();
    echo ("TOTO");
    $userController = new UserController();
    $db = new Database();
    $pdo = $db->getConnect();
    $userModel = new UserModel($pdo);

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            echo ($userController->getUsers($userModel));
            break;
        case "POST":
            echo ($userController->addUser($userModel));
            break;
        case "DELETE":
            echo ($userController->deleteUser($userModel));
            break;
        case "PUT":
            echo ($userController->updateUser($userModel));
            break;
        default:
            echo ("mauvaise direction");
    }
}
