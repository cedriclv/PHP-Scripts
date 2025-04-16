<?php

function sendJsonResponse($data = null, $message = '', $status = 200)
{
    $success = true;
    if ($status > 300) {
        $success = false;
    }
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
}
