<?php

include "../config/database.php";


$target_dir = "../uploads/";
$file_name = "room_" . rand(0, 9) . "_" . date("Ymd_His") . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
$target_file = $target_dir . $file_name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$thumbnail_img_cond = "";

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    $thumbnail_img_cond = ", thumbnail_img = '{$file_name}'";
} else {
    $thumbnail_img_cond = "";
    echo "Sorry, there was an error uploading your file.";
}



$sql = "UPDATE hotel_rooms SET
            room_no = '{$_POST["room_no"]}'
            {$thumbnail_img_cond}
            WHERE id = '{$_POST["id"]}'";

if ($conn->query($sql) === TRUE) {
    header('location: ../rooms.php?room_type_id=' . $_POST["room_type_id"] . '&hotel_id=' . $_POST["hotel_id"]);
} else {
    header('location: ../rooms.php?room_type_id=' . $_POST["room_type_id"] . '&hotel_id=' . $_POST["hotel_id"]);
}


$conn->close();

