<?php

include "../config/database.php";


$now = date("Y-m-d H:i:s");
$sql = "INSERT INTO users (email, password, firstname, lastname, mobile, address, created_at)
        VALUES ('{$_POST["email"]}', '{$_POST["password"]}', '{$_POST["firstname"]}', 
                    '{$_POST["lastname"]}', '{$_POST["mobile"]}', '{$_POST["address"]}', '{$now}')";
if ($conn->query($sql) === TRUE) {
    $conn->close();
    header('location: ../admin-user.php');
} else {
    $conn->close();
    header('location: ../admin-user.php');
}






