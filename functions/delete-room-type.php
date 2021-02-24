<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;

$find = "SELECT * FROM room_types WHERE id = '{$_POST["id"]}' LIMIT 1";
$resultFind = $conn->query($find);
if ($resultFind->num_rows > 0) {
    $now = date("Y-m-d H:i:s");
    $sql = "UPDATE room_types SET deleted_at = '{$now}' WHERE id = '{$_POST["id"]}'";
    $result = $conn->query($sql);
    if ($result) {
        $sqlDelRoom = "UPDATE hotel_rooms SET deleted_at = '{$now}' WHERE room_type_id = '{$_POST["id"]}'";
        $resultRoom = $conn->query($sqlDelRoom);

        if($resultRoom) {
            $res["success"] = true;
        }
    }
}

$conn->close();

echo json_encode($res);



