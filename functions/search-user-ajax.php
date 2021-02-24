<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;

$sql = "SELECT * FROM users WHERE 1 AND deleted_at IS NULL 
                AND (firstname LIKE '%{$_POST["search"]}%' 
                        OR lastname LIKE '%{$_POST["search"]}%' 
                        OR mobile LIKE '%{$_POST["search"]}%')";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $res["result"] = $result->fetch_all(MYSQLI_ASSOC);
    $res["success"] = true;
}

echo json_encode($res);

$conn->close();

