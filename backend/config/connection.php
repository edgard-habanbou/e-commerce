<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$host = "localhost";
$db_user = "root";
$db_password = null;
$db_name = "e_commerce";
$con = new mysqli($host, $db_user, $db_password, $db_name);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
