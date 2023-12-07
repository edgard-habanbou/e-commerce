<?php


include('../../config/connection.php');



if ($_POST['action'] == "signup") {


    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender']; //0 Male, 1 Female
    $role = 2; // 1 Sellers 2 User

    $hashed_password = crypt($password, PASSWORD_DEFAULT);

    $query = $con->prepare('INSERT INTO users (username, fname, lname, user_role, email, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('sssisis', $username, $fname, $lname, $role, $email, $gender, $hashed_password);
    $query->execute();

    $response = [];
    if ($query->error) {
        $response['status'] = false;
        $response['message'] = 'Error updating user: ' . $query->error;
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response['status'] = true;
        $response['message'] = 'User Created successfully';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
