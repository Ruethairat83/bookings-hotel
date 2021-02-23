<?php include "./layouts/header.php"; ?>

<?php

$sqlHotel = "SELECT * FROM hotels WHERE 1 AND id = {$_GET["id"]} LIMIT 1";
$fetchHotel = $conn->query($sqlHotel);
$results = [];
if ($fetchHotel->num_rows > 0) {
    $hotel = $fetchHotel->fetch_assoc();
    $results["hotel"] = $hotel;
}

if (isset($_GET["checkin"]) && isset($_GET["checkout"])) {
    $sqlRoomType = "SELECT *
                    FROM room_types AS t1
                    WHERE 1 AND t1.hotel_id = {$_GET["id"]}
                      AND NOT EXISTS
                        (SELECT *
                         FROM order_details AS st1
                         INNER JOIN
                           (SELECT *
                            FROM orders) AS st2 ON st1.order_id = st2.id
                         WHERE 1
                           AND DATE(st2.check_out) < '{$_GET["checkout"]}')";
    $fetchRoomType = $conn->query($sqlRoomType);
    if ($fetchRoomType->num_rows > 0) {
        $resultRoomTypes = $fetchRoomType->fetch_all(MYSQLI_ASSOC);
        foreach ($resultRoomTypes as $rtkey => $resultRoomType) {
            $results["hotel"]["room_types"][$rtkey] = $resultRoomType;
            $sqlRoomTypeFacility = "SELECT * FROM room_type_facilities 
                                        WHERE 1 AND room_type_id = {$resultRoomType["id"]}";
            $fetchRoomTypeFacility = $conn->query($sqlRoomTypeFacility);
            if ($fetchRoomTypeFacility->num_rows > 0) {
                $results["hotel"]["room_types"][$rtkey]["facilities"] = $fetchRoomTypeFacility->fetch_all(MYSQLI_ASSOC);
            } else {
                $results["room_types"][$rtkey]["facilities"] = [];
            }
        }
    } else {
        $results["hotel"]["room_types"] = [];
    }
}

?>

<div class="container py-4">
    <div class="row mt-4 mb-4">
        <div class="col-12 col-md-5">
            <img class="img-fluid" src="./uploads/<?php echo $results["hotel"]["thumbnail_img"]; ?>" alt="img">
        </div>
        <div class="col-12 col-md-7">
            <h4><?php echo $results["hotel"]["name"]; ?></h4>
            <p><?php echo $results["hotel"]["description"]; ?></p>
            <!--            <button class="btn btn-primary w-100 mt-4">จอง</button>-->
        </div>
    </div>
    <hr>
    <div class="row mb-2 mt-5">
        <div class="col-12">
            <h4>ห้องว่าง</h4>
        </div>
    </div>
    <form action="./hotel-detail.php" method="get" class="w-100">
        <div class="row mb-2">
            <input type="hidden" name="id" id="hotel_id" value="<?php echo $_GET["id"]; ?>">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <input type="date" name="checkin" id="checkin"
                           value="<?php echo isset($_GET["checkin"]) ? $_GET["checkin"] : ""; ?>"
                           class="form-control" required>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <input type="date" name="checkout" id="checkout"
                           value="<?php echo isset($_GET["checkout"]) ? $_GET["checkout"] : ""; ?>"
                           class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-md-6 mb-3">
                <button type="submit" class="btn btn-primary w-100">ค้นหา</button>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <a href="./hotel-detail.php?id=<?php echo $_GET["id"]; ?>"
                   type="button" class="btn btn-danger w-100">ล้าง</a>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ประเภทห้องพัก</th>
                        <th>สิ่งอำนวยความสะดวก</th>
                        <th class="text-right">จำนวน</th>
                        <th class="text-right">ราคา</th>
                        <th class="text-center">สรุปผลการเลือก</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($results["hotel"]["room_types"]) && $results["hotel"]["room_types"]) {
                        foreach ($results["hotel"]["room_types"] as $tkey => $resultRoomType) {
                            $index = 1;
                            ?>
                            <tr>
                                <td><?php echo $resultRoomType["name"]; ?></td>
                                <td>
                                    <?php if (isset($resultRoomType["facilities"]) && $resultRoomType["facilities"]) { ?>
                                        <?php foreach ($resultRoomType["facilities"] as $fkey => $roomFacility) { ?>
                                            <p>
                                                <span><i class="fas fa-<?php echo $roomFacility["icon"]; ?>"></i></span>
                                                <?php echo $roomFacility["name"]; ?>
                                            </p>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <span>ไม่มี</span>
                                    <?php } ?>
                                </td>
                                <td class="text-right">
                                    <select name="amount" id="amount-<?php echo $resultRoomType["id"]; ?>"
                                            onchange="calRoomSelected(<?php echo $resultRoomType["id"]; ?>, <?php echo $resultRoomType["price"]; ?>);"
                                            class="form-control form-control-sm">
                                        <?php for ($index = 0; $index <= $resultRoomType["amount"]; $index++) { ?>
                                            <option value="<?php echo $index; ?>">
                                                <?php echo $index; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="text-right"><?php echo $resultRoomType["price"] . " บาท/ห้อง"; ?></td>
                                <?php if ($tkey === 0) { ?>
                                    <td class="text-center align-middle"
                                        rowspan="<?php echo count($results["hotel"]["room_types"]); ?>">
                                        <div id="result-selected"></div>
                                        <button class="btn btn-success text-center my-1"
                                                id="btn-booking" disabled>จอง
                                        </button>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php
                            $index++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include "./layouts/footer.php"; ?>


<script>
    $(document).ready(function () {

    });

    var arrSelectedRoom = [];

    function calRoomSelected(roomTypeId, price) {

        let amount = $(`#amount-${roomTypeId}`).val() * 1;
        var resultObject = checkRoomTypeExist(roomTypeId, arrSelectedRoom);

        if (!resultObject) {
            let sum = (price * 1) * amount;
            let arrValue = {room_type_id: roomTypeId, amount: amount, total_price: sum};
            arrSelectedRoom.push(arrValue)
        } else {
            let sum = (price * 1) * amount;
            resultObject.amount = amount;
            resultObject.total_price = sum;
        }

        let totalPrice = 0;
        let totalAmount = 0;
        arrSelectedRoom.map((item, index) => {
            totalPrice += item.total_price;
            totalAmount += item.amount;
        });

        if (totalAmount !== 0) {
            $("#btn-booking").prop("disabled", false);
            $("#btn-booking").attr("onclick", `booking();`);
            $("#result-selected").empty().append(`จำนวน ${totalAmount} ห้อง ราคารวม ${totalPrice.toFixed(2)} บาท`);
        } else {
            $("#btn-booking").prop("disabled", true);
            $("#btn-booking").removeAttribute("onclick");
            $("#result-selected").empty().append(``);
        }


    }

    function isLogin() {
        let sessionData = <?php echo isset($_SESSION["user_data"]) ? json_encode($_SESSION["user_data"]) : json_encode([]); ?>;
        if (!sessionData) {
            Swal.fire({
                title: 'จองห้องพัก',
                text: "คุณยังไม่ได้เข้าสู่ระบบ กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ",
                icon: 'warning',
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก",
                showCancelButton: false,
                showCloseButton: false
            });

            return false;
        }

        return true;
    }


    function checkRoomTypeExist(nameKey, arr) {
        for (let i = 0; i < arr.length; i++) {
            if (arr[i].room_type_id === nameKey) {
                return arr[i];
            }
        }
    }


    function booking() {
        Swal.fire({
            title: 'จองห้องพัก',
            text: "คุณต้องการดำเนินการต่อ ?",
            icon: 'warning',
            confirmButtonText: "ตกลง",
            cancelButtonText: "ยกเลิก",
            showCancelButton: true,
            showCloseButton: false
        }).then(function (result) {
            if (result.value) {
                let formData = new FormData();
                arrSelectedRoom.map((item, index) => {
                    formData.append("room_type_id[]", item.room_type_id);
                    formData.append("total_price[]", item.total_price);
                    formData.append("amount[]", item.amount);
                });
                console.log()
                formData.append("check_in", $('#checkin').val());
                formData.append("check_out", $('#checkout').val());
                $.ajax({
                    type: "POST",
                    url: "./functions/booking-hotel.php",
                    data: formData,
                    contentType: false,
                    cache: false,
                    dataType: "json",
                    processData: false,
                    success: function (res) {
                        if (res.success) {
                            location.href = "checkout.php";
                        } else {
                            Swal.fire({
                                title: 'จองห้องพัก',
                                text: "Something went wrong!",
                                icon: 'warning',
                                confirmButtonText: "ตกลง",
                                cancelButtonText: "ยกเลิก",
                                showCancelButton: false,
                                showCloseButton: false
                            });
                        }
                    }
                });
            }
        });
    }


</script>
