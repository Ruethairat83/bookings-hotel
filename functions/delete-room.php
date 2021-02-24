<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;

$find = "SELECT * FROM hotel_rooms WHERE id = '{$_POST["id"]}' LIMIT 1";
$resultFind = $conn->query($find);
if ($resultFind->num_rows > 0) {
    $now = date("Y-m-d H:i:s");
    $sql = "UPDATE hotel_rooms SET deleted_at = '{$now}' WHERE id = '{$_POST["id"]}'";
    $result = $conn->query($sql);

    if ($result) {
        $res["success"] = true;
    }
}

$conn->close();

echo json_encode($res);



