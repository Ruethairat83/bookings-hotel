<?php

include "../config/database.php";
$res["result"] = [];
$res["success"] = false;

$now = date("Y-m-d H:i:s");
$sql = "INSERT INTO comments (hotel_id, user_id, comment, created_at)
        VALUES ('{$_POST["hotel_id"]}', {$_SESSION["user_data"][0]["id"]}, '{$_POST["comment"]}', 
                '{$now}')";
if ($conn->query($sql) === TRUE) {
    $res["result"] = [];
    $res["success"] = true;
}

$conn->close();

echo json_encode($res);
