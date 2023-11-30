<?php
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../vendor/autoload.php'; 
require_once '../utils/utility_functions.php';

use Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    
    if (empty($data->username) || empty($data->password)) {
        sendErrorResponse("Both username and password are required.", 400);
    } else {
        $user = new User();

        
        $userInfo = $user->login($data->username, $data->password);
        

        if ($userInfo) {
          
            $secret_key = "faisalDB";
            $issuer_claim = "abc.com"; 
            $issued_at = time();
            $expiration_time = $issued_at + 3600; 

            $data = array(
                "iss" => $issuer_claim,
                "iat" => $issued_at,
                "exp" => $expiration_time,
                "data" => array(
                    "user_id" => $userInfo['id'] // Include user ID in the token
                )
            );

            $jwt = JWT::encode($data, $secret_key, 'HS256');

            sendJsonResponse(array(
                "message" => "Login successful",
                "jwt" => $jwt
            ));
        } else {
            sendErrorResponse("Login failed. Invalid username or password.", 401);
        }
    }
} else {
    sendErrorResponse("Invalid request method", 405);
}
