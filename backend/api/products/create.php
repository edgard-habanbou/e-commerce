<?php
include_once("./jwt_check.php");

if ($_POST['action'] == "create") {
    if ($decoded->user_role != 1) {

        // Return 401 Unauthorized if the user does not have the required role (Seller)
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $stock_quantity = $_POST['stock_quantity'];

    $query = $con->prepare('INSERT INTO `products` (`product_name`, `product_price`, `stock_quantity`, `user_id`) 
                            VALUES (?, ?, ?, ?);');
    $query->bind_param('siii', $product_name, $product_price, $stock_quantity, $user_id);
    $query->execute();

    $response = [];
    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response['status'] = true;
        $response['message'] = 'Product created successfully';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
