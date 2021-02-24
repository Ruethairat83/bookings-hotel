<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row mt-4 mb-3">
        <div class="col-12 d-flex justify-content-between">
            <h4>ห้อง</h4>
            <a class="btn btn-primary"
               href="add-room.php?room_type_id=<?php echo $_GET["room_type_id"]; ?>&hotel_id=<?php echo $_GET["hotel_id"]; ?>">
                เพิ่มห้อง</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-hotel">
                    <thead>
                    <tr>
                        <th style="width: 9rem;">รูปภาพ</th>
                        <th>ชื่อ</th>
                        <th style="width: 8rem;">คำสั่ง</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM hotel_rooms 
                            WHERE 1 AND room_type_id = '{$_GET["room_type_id"]}'
                            AND deleted_at IS NULL";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <a target="_blank" href="./uploads/<?php echo $row["thumbnail_img"]; ?>">
                                        <img style="width: 8rem; height: 6.5rem;"
                                             src="./uploads/<?php echo $row["thumbnail_img"]; ?>"
                                             alt="img hotel_<?php echo $row["id"]; ?>">
                                    </a>
                                </td>
                                <td><?php echo $row["room_no"]; ?></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข"
                                       href="./edit-room.php?id=<?php echo $row["id"]; ?>&room_type_id=<?php echo $_GET["room_type_id"]; ?>&hotel_id=<?php echo $_GET["hotel_id"]; ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="delRoom(<?php echo $row["id"]; ?>);"
                                            data-toggle="tooltip"
                                            title="ลบ">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
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
        $('#tb-hotel').DataTable({});
    });


    function delRoom(id) {
        Swal.fire({
            title: 'ลบข้อมูล',
            text: "คุณต้องการลบข้อมูลห้อง ?",
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
                    url: "./functions/delete-room.php",
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