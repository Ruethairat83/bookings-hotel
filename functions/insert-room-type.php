<?php

include "../config/database.php";


$now = date("Y-m-d H:i:s");
$sql = "INSERT INTO room_types (name, price, hotel_id, created_at)
        VALUES ('{$_POST["name"]}', {$_POST["price"]}, {$_POST["hotel_id"]}, '{$now}')";
if ($conn->query($sql) === TRUE) {
    header('location: ../hotel-room-types.php?id='.$_POST["hotel_id"]);
} else {
    header('location: ../hotel-room-types.php?id='.$_POST["hotel_id"]);
}
$conn->close();





