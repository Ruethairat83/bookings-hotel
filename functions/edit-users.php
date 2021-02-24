<?php

include "../config/database.php";

$sql = "UPDATE users SET
            email = '{$_POST["email"]}',
            password = '{$_POST["password"]}',
            firstname = '{$_POST["firstname"]}',
            lastname = '{$_POST["lastname"]}',
            mobile = '{$_POST["mobile"]}',
            address = '{$_POST["address"]}'
        WHERE id = {$_POST["id"]}";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    header("location: ../admin-user.php");
} else {
    $conn->close();
    header("location: ../admin-user.php");
}


