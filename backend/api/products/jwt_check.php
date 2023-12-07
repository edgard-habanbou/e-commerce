<?php

include('../../config/connection.php');
require_once('../../../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Extract JWT from the request headers
$jwt = null;
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $matches = [];
    if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        $jwt = $matches[1];
    }
} else {
    // Return 401 Unauthorized if Authorization header is missing
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized Access"));
    exit;
}

$secret_Key  = 'Q2FuJ3Qgd2FpdCB0byBmaW5pc2ggdGhpcyBwcm9ncmFtLg==';

$decoded = JWT::decode($jwt, new key($secret_Key, 'HS512'));
$user_id = $decoded->user_id;

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response = [];
    $response['status'] = false;
    $response['message'] = 'Invalid Request';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
