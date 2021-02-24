<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;

$find = "SELECT * FROM hotels WHERE id = '{$_POST["id"]}' LIMIT 1";
$resultFind = $conn->query($find);
$thumbnail_img = "";
if ($resultFind->num_rows > 0) {
    $row = $resultFind->fetch_assoc();
    $thumbnail_img = $row["thumbnail_img"];
}

$now = date("Y-m-d H:i:s");
$sql = "UPDATE hotels SET deleted_at = '{$now}' WHERE id = '{$_POST["id"]}'";
$result = $conn->query($sql);
if ($result) {
    $sqlDelRoomType = "UPDATE room_types SET deleted_at = '{$now}' WHERE hotel_id = '{$_POST["id"]}'";
    $resultDelRoomType = $conn->query($sqlDelRoomType);
    if ($resultDelRoomType) {
        $sqlDelRoom = "UPDATE hotel_rooms SET deleted_at = '{$now}' WHERE hotel_id = '{$_POST["id"]}'";
        $resultDelRoom = $conn->query($sqlDelRoom);
        if ($resultDelRoom) {
            $res["success"] = true;
        }
    }
}

//$fileToDelete = "../uploads/" . $thumbnail_img;
//if (is_file($fileToDelete)) {
//    unlink($fileToDelete); // delete file
//}

echo json_encode($res);

$conn->close();

