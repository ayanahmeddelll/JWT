<?php
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../utils/utility_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    // Check if both username and password are provided
    if (empty($data->username) || empty($data->password)) {
        sendErrorResponse("Both username and password are required.", 400);
    } else {
        $user = new User();

        // Attempt to register the user
        if ($user->register($data->username, $data->password,$data->role)) {
            sendJsonResponse(array("message" => "User registered successfully"));
        } else {
            sendErrorResponse("User registration failed", 500);
        }
    }
} else {
    sendErrorResponse("Invalid request method", 405);
}