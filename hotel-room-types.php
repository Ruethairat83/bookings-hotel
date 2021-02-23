<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row mt-4 mb-3">
        <div class="col-12 d-flex justify-content-between">
            <h4>ประเภทห้อง</h4>
            <a class="btn btn-primary" href="add-room-type.php?hotel_id=<?php echo $_GET["id"]; ?>">เพิ่มประเภทห้อง</a>
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
                        <th>ห้อง</th>
                        <th style="width: 8rem;">คำสั่ง</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM room_types 
                            WHERE 1 AND hotel_id = '{$_GET["id"]}' AND deleted_at IS NULL";
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
                                <td><?php echo $row["name"]; ?></td>
                                <td>
                                    <a type="button"
                                       href="./rooms.php?room_type_id=<?php echo $row["id"] . "&hotel_id=" . $_GET["id"]; ?>"
                                       class="btn btn-info btn-sm">ห้อง</a>
                                </td>
                                <td>
                                    <a href="./edit-room-type.php?id=<?php echo $row["id"]; ?>&hotel_id=<?php echo $_GET["id"]; ?>"
                                       class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="delRoomType(<?php echo $row["id"]; ?>);"
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


    function delRoomType(id) {
        Swal.fire({
            title: 'ลบข้อมูล',
            text: "คุณต้องการลบข้อมูลประเภทห้องพัก ?",
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
                    url: "./functions/delete-room-type.php",
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