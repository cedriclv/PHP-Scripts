<?php
require __DIR__ . '/../src/controllers/UserController.php';
require __DIR__ . '/../src/models/UserModel.php';
require __DIR__ . '/../src/helpers/AuthHelper.php';

route();

function route()
{
    $role = AuthHelper::checkAuth();
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
            if ($role == "user" || $role == "admin {") {
                echo ($userController->addUser($userModel));
            } else {
                sendJsonResponse(null, "no right for this operation", 401);
            }
            break;
        case "DELETE":
            if ($role == "user" || $role == "admin {") {
                echo ($userController->deleteUser($userModel));
            } else {
                sendJsonResponse(null, "no right for this operation", 401);
            }
            break;
        case "PUT":
            if ($role == "user" || $role == "admin {") {
                echo ($userController->updateUser($userModel));
            } else {
                sendJsonResponse(null, "no right for this operation", 401);
            }
            break;
        default:
            echo ("mauvaise direction");
    }
}
