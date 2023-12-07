<?php
include_once("./jwt_check.php");


if ($_POST['action'] == 'getAllProducts') {
    if ($decoded->user_role != 2) {
        // Return 401 Unauthorized if the user does not have the required role (Buyer)
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }
    $query = $con->prepare('SELECT * FROM `products`');
    $query->execute();

    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $result = $query->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $response['status'] = true;
        $response['message'] = 'Products fetched successfully';
        $response['products'] = $products;
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
