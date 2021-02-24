<?php

include "../config/database.php";


$target_dir = "../uploads/";
$file_name = "room_" . rand(0, 9) . "_" . date("Ymd_His") . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
$target_file = $target_dir . $file_name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$now = date("Y-m-d H:i:s");

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $sql = "INSERT INTO hotel_rooms (room_no, room_type_id, hotel_id, created_at, thumbnail_img)
        VALUES ('{$_POST["room_no"]}', {$_POST["room_type_id"]}, {$_POST["hotel_id"]}, '{$now}', '{$file_name}')";
    if ($conn->query($sql) === TRUE) {

        $sqlGetRoomTypeAmount = "SELECT * FROM room_types WHERE 1 AND id = {$_POST["room_type_id"]} LIMIT 1";
        $resultAmount = $conn->query($sqlGetRoomTypeAmount);
        $amount = 0;
        if ($resultAmount->num_rows > 0) {
            $rowAmount = $resultAmount->fetch_assoc();
            $amount = $rowAmount["amount"] + 1;
        }

        $sqlUpdateRoomTypeAmount = "UPDATE room_types SET amount = {$amount} WHERE id = {$_POST["room_type_id"]}";
        $resultUpdateAmount = $conn->query($sqlUpdateRoomTypeAmount);
        if ($conn->query($resultUpdateAmount) === TRUE) {
            header('location: ../rooms.php?room_type_id=' . $_POST["room_type_id"] . '&hotel_id=' . $_POST["hotel_id"]);
        } else {
            header('location: ../rooms.php?room_type_id=' . $_POST["room_type_id"] . '&hotel_id=' . $_POST["hotel_id"]);
        }
    } else {
        header('location: ../rooms.php?room_type_id=' . $_POST["room_type_id"] . '&hotel_id=' . $_POST["hotel_id"]);
    }
}









