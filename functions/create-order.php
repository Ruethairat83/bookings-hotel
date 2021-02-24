<?php
include "../config/database.php";

$contact_mobile = $_POST["contact_mobile"] ? $_POST["contact_mobile"] : "";
if (isset($_SESSION["user_data"][0]["id"])) {
    $sql = "INSERT INTO orders (user_id, contact_mobile, total_amount, grand_total, check_in, check_out)
                VALUES ({$_SESSION["user_data"][0]["id"]}, '{$contact_mobile}', '{$_POST["total_amount"]}',
                        '{$_POST["grand_total"]}', '{$_POST["check_in"]}', '{$_POST["check_out"]}')";
} else {
    $sql = "INSERT INTO orders (user_id, contact_mobile, total_amount, grand_total, check_in, check_out)
                VALUES (NULL, '{$contact_mobile}', '{$_POST["total_amount"]}',
                        '{$_POST["grand_total"]}', '{$_POST["check_in"]}', '{$_POST["check_out"]}')";
}

if ($conn->query($sql) === TRUE) {
    $orderId = $conn->insert_id;

    foreach ($_SESSION["bookings"]["results"] as $bkey => $sessionBooking) {

        $sqlGetAllAvailableRoom = "SELECT * FROM hotel_rooms
                                    WHERE 1
                                    AND room_type_id = {$sessionBooking["room_type_id"]}
                                    AND status = 'available' LIMIT {$sessionBooking["amount"]}";
        var_dump($sqlGetAllAvailableRoom);
        $sqlGetRoomTypeAmount = "SELECT * FROM room_types WHERE 1 AND id = {$sessionBooking["room_type_id"]} LIMIT 1";
        $resultAmount = $conn->query($sqlGetRoomTypeAmount);
        if ($resultAmount->num_rows > 0) {
            $rowAmount = $resultAmount->fetch_assoc();
            $amount = $rowAmount["amount"] - $sessionBooking["amount"];

            $sqlUpdateRoomTypeAmount = "UPDATE room_types SET amount = {$amount} WHERE id = {$sessionBooking["room_type_id"]}";
            $resultUpdateAmount = $conn->query($sqlUpdateRoomTypeAmount);
            $conn->query($resultUpdateAmount);

        }

        $resultRoomAvailable = $conn->query($sqlGetAllAvailableRoom);
        if ($resultRoomAvailable->num_rows > 0) {
            while ($roomAvailable = $resultRoomAvailable->fetch_assoc()) {
                $sqlCreateOrderDetail = "INSERT INTO order_details (order_id, room_type_id, room_id)
                                       VALUES ({$orderId}, {$sessionBooking["room_type_id"]},
                                        {$roomAvailable["id"]})";
                $resultOrderDetail = $conn->query($sqlCreateOrderDetail);
                if ($resultOrderDetail) {
                    $sqlUpdateStatusRoom = "UPDATE hotel_rooms SET status = 'unavailable'
                                    WHERE id = {$roomAvailable["id"]}";
                    $conn->query($sqlUpdateStatusRoom);
                }
            }
        }
    }
    unset($_SESSION["bookings"]);
    $conn->close();
    header("location: ../index.php");
}








