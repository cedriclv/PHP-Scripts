<?php
require_once __DIR__ . '/../helpers/helpers.php';

class AuthHelper
{


    public static $acceptedKey = [
        'abcd',
        '1234'
    ];

    public static function checkAuth()
    {
        $headers = getallheaders();
        // check that authorization is in the header
        if (!isset($headers["Authorization"])) {
            http_response_code(401);
            sendJsonResponse(null, "Authorization key not provided", 401);
            exit();
        }
        // get key from header
        if (preg_match('/Bearer\s(\S+)/', $headers["Authorization"], $matches)) {
            $cleanedKey = $matches[1];
        } else {
            http_response_code(401);
            sendJsonResponse(null, "Authorization in wrong format, must be Bearer XXXX... ", 401);
            exit();
        };
        //echo message if not okay
        if (!in_array($cleanedKey, self::$acceptedKey)) {
            http_response_code(401);
            sendJsonResponse(null, "Authorization not granted", 401);
            exit();
        }
    }
}
