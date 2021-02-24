<?php
include "../config/database.php";


$res["result"] = [];
$res["success"] = true;



foreach ($_POST["room_type_id"] as $rtkey => $roomType) {
    $_SESSION["bookings"]["results"][$rtkey]["room_type_id"] = $roomType;
}

foreach ($_POST["amount"] as $akey => $amount) {
    $_SESSION["bookings"]["results"][$akey]["amount"] = $amount;
}

foreach ($_POST["total_price"] as $pkey => $total_price) {
    $_SESSION["bookings"]["results"][$pkey]["total_price"] = $total_price;
}

$_SESSION["bookings"]["check_in"] = $_POST["check_in"];
$_SESSION["bookings"]["check_out"] = $_POST["check_out"];

echo json_encode($res);




