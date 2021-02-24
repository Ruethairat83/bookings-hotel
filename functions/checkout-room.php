<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;

$sql = "UPDATE hotel_rooms SET
            status = 'available'
        WHERE id = {$_POST["id"]}";

if ($conn->query($sql) === TRUE) {

    $sqlUpdateIsCheckout = "UPDATE order_details SET is_checkout = 1 WHERE id = {$_POST["order_detail_id"]}";
    $conn->query($sqlUpdateIsCheckout);

    $sqlGetRoomTypeAmount = "SELECT t1.id AS room_type_id, t1.amount FROM room_types AS t1 
                                INNER JOIN (SELECT * FROM hotel_rooms) AS t2
                                ON t1.id = t2.room_type_id WHERE 1 AND t2.id = {$_POST["id"]}";

    $resultAmount = $conn->query($sqlGetRoomTypeAmount);
    if ($resultAmount->num_rows > 0) {
        $rowAmount = $resultAmount->fetch_assoc();
        $amount = $rowAmount["amount"] + 1;

        $sqlUpdateRoomTypeAmount = "UPDATE room_types SET amount = {$amount} WHERE id = {$rowAmount["room_type_id"]}";
        $resultUpdateAmount = $conn->query($sqlUpdateRoomTypeAmount);
        if ($resultUpdateAmount) {
            $res["result"] = [];
            $res["success"] = true;
        }
    }
}

$conn->close();


echo json_encode($res);




