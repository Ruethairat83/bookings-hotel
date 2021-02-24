<?php

include "../config/database.php";


$sql = "UPDATE room_types SET
            name = '{$_POST["name"]}',
            price = {$_POST["price"]}
        WHERE id = '{$_POST["room_type_id"]}'";

if ($conn->query($sql) === TRUE) {
    header('location: ../hotel-room-types.php?id='.$_POST["hotel_id"]);
} else {
    header('location: ../hotel-room-types.php?id='.$_POST["hotel_id"]);
}


$conn->close();

