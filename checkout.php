<?php include "./layouts/header.php"; ?>

<?php
//var_dump($_SESSION["bookings"]);exit();
?>

<div class="container py-4">
    <div class="row mt-4 mb-3">
        <div class="col-12 d-flex justify-content-between">
            <h4>สรุปรายการจองห้องพัก</h4>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-result-booking">
                    <thead>
                    <tr>
                        <th>โรงแรม</th>
                        <th>ห้อง</th>
                        <th class="text-right">จำนวน</th>
                        <th class="text-right">ราคา</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_SESSION["bookings"])) {
                        $grandTotal = 0;
                        $totalAmount = 0;
                        foreach ($_SESSION["bookings"]["results"] as $bkey => $bookingData) {
//                            var_dump($bookingData);
                            $sql = "SELECT 
                                        t1.name AS hotel_name
                                        , t2.name AS room_type_name 
                                    FROM hotels AS t1 
                                    INNER JOIN (SELECT * FROM room_types) AS t2 ON
                                    t1.id = t2.hotel_id WHERE 1 AND t2.id = {$bookingData["room_type_id"]}";

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $grandTotal += $bookingData["total_price"];
                                    $totalAmount += $bookingData["amount"];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row["hotel_name"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["room_type_name"]; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($bookingData["amount"], 0) . " ห้อง"; ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($bookingData["total_price"], 2) . " บาท"; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="3">รวม</td>
                            <td class="text-right"><?php echo number_format($grandTotal, 2) . " บาท"; ?></td>
                        </tr>
                        <?php
                    } else {
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="row mb-3">
        <div class="col-12">
            <h4>กรุณากรอกเบอร์มือถือเพื่อใช้ในการจองห้องพัก</h4>
            <form action="./functions/create-order.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $totalAmount; ?>">
                <input type="hidden" name="grand_total" id="grand_total" value="<?php echo $grandTotal; ?>">
                <input type="hidden" name="check_in" id="check_in" value="<?php echo $_SESSION["bookings"]["check_in"]; ?>">
                <input type="hidden" name="check_out" id="check_out" value="<?php echo $_SESSION["bookings"]["check_out"]; ?>">
                <?php if (!isset($_SESSION["user_data"])) { ?>
                    <div class="form-group">
                        <label for="contact_mobile">เบอร์โทรที่ติดต่อได้</label>
                        <input type="tel" class="form-control" name="contact_mobile" id="contact_mobile"
                               maxlength="10" minlength="9"
                               oninput="validateCheckout(this);">
                    </div>
                <?php } ?>
                <button class="btn btn-success" id="btn-checkout"
                    <?php echo isset($_SESSION["user_data"]) ? "" : "disabled"; ?>>ยืนยันการจองห้องพัก
                </button>
            </form>
        </div>
    </div>
</div>


<?php include "./layouts/footer.php"; ?>


<script>
    $(document).ready(function () {

    });


    function validateCheckout(obj) {
        obj.value = obj.value.replace(/[^0-9]/g, '');
        if (obj.value) {
            $("#btn-checkout").prop("disabled", false);
        } else {
            $("#btn-checkout").prop("disabled", true);
        }
    }


    function delHotel(id) {
        Swal.fire({
            title: 'ลบข้อมูล',
            text: "คุณต้องการลบข้อมูลโรงแรม ?",
            icon: 'warning',
            confirmButtonText: "ตกลง",
            cancelButtonText: "ยกเลิก",
            showCancelButton: true,
            showCloseButton: false
        }).then(function (result) {
            if (result.value) {
                let formData = new FormData();
                formData.append("id", id);
                $.ajax({
                    type: "POST",
                    url: "./functions/delete-hotel.php",
                    data: formData,
                    contentType: false,
                    cache: false,
                    dataType: "json",
                    processData: false,
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'ลบข้อมูล',
                                text: "ลบข้อมูลสำเร็จ",
                                icon: 'success',
                                confirmButtonText: "ตกลง",
                                cancelButtonText: "ยกเลิก",
                                showCancelButton: false,
                                showCloseButton: false,
                                allowOutsideClick: true,
                            }).then(function (result) {
                                if (result.value) {
                                    location.reload();
                                }
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'ลบข้อมูล',
                                text: "ลบข้อมูลไม่สำเร็จ",
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