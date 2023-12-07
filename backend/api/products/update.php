<?php
include_once("./jwt_check.php");

if ($_POST['action'] == 'update') {
    if ($decoded->user_role != 1) {
        // Return 401 Unauthorized if the user does not have the required role (Seller)
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Access"));
        exit;
    }

    $product_name = $_POST["product_name"];
    $product_price = $_POST["product_price"];
    $stock_quantity = $_POST["stock_quantity"];
    $product_id = $_POST["product_id"];

    // Update an existing product in the database if and only if the user is the owner of the product
    $query = $con->prepare('UPDATE `products` SET `product_name` = ?, `product_price` = ?, `stock_quantity` = ? WHERE `product_id` = ? AND `user_id` = ?');
    $query->bind_param('siiii', $product_name, $product_price, $stock_quantity, $product_id, $user_id);
    $query->execute();

    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        if ($query->affected_rows > 0) {
            $response['status'] = true;
            $response['message'] = 'Product updated successfully';
        } else {
            $response['status'] = false;
            $response['message'] = 'You dont have permission to update this product';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
