<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;

$sql = "SELECT * FROM users WHERE 1 AND deleted_at IS NULL 
                AND email = '{$_POST["username"]}' AND password = '{$_POST["password"]}' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $res["result"] = $result->fetch_all(MYSQLI_ASSOC);
    $res["success"] = true;
    $_SESSION["user_data"] = $res["result"];
}

echo json_encode($res);

$conn->close();

