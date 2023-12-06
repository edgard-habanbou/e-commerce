<?php

declare(strict_types=1);

use Firebase\JWT\JWT;

require_once('../../../vendor/autoload.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
include('../../config/connection.php');


$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];

$query = $con->prepare('SELECT user_id, password, user_role FROM users WHERE email = ?');
$query->bind_param('s', $user_email);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($user_id, $hashed_password, $user_role);
$query->fetch();

$response = [];
if ($num_rows == 0) {
    $response['status']  = 'User Not Found';
    echo json_encode($response);
} else {

    if (password_verify($user_password, $hashed_password)) {

        $secret_Key  = 'Q2FuJ3Qgd2FpdCB0byBmaW5pc2ggdGhpcyBwcm9ncmFtLg==';
        $request_data = [
            'user_id' => $user_id,
            'role_id' => $role_id,
        ];

        $jwt = JWT::encode($request_data, $secret_Key, 'HS512');
        $response['jwt'] = $jwt;
        $response['status']  = 'Login Success';
        $response['role_id'] = $role_id;

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response['status']  = 'Wrong Credentials';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
