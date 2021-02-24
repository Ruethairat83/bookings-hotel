<?php

include "../config/database.php";


$now = date("Y-m-d H:i:s");
$sql = "INSERT INTO users (email, password, firstname, lastname, mobile, address, created_at)
        VALUES ('{$_POST["email"]}', '{$_POST["password"]}', '{$_POST["firstname"]}', 
                    '{$_POST["lastname"]}', '{$_POST["mobile"]}', '{$_POST["address"]}', '{$now}')";
if ($conn->query($sql) === TRUE) {

    $sqlGetUser = "SELECT * FROM users WHERE 1 AND deleted_at IS NULL 
                AND email = '{$_POST["email"]}' AND password = '{$_POST["password"]}' LIMIT 1";
    $result = $conn->query($sqlGetUser);
    if ($result->num_rows > 0) {
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $_SESSION["user_data"] = $result;
        header('location: ../index.php');
    } else {
        header('location: ../index.php');
    }
} else {
    $conn->close();
    header('location: ../index.php');
}

?>






