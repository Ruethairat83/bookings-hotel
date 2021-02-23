<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row mt-4 mb-3">
        <div class="col-12 d-flex justify-content-between">
            <h4>โรงแรม</h4>
            <a class="btn btn-primary" href="add-hotel.php">เพิ่มโรงแรม</a>
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
                        <th>ประเภทห้อง</th>
                        <th style="width: 8rem;">คำสั่ง</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM hotels WHERE 1 AND deleted_at IS NULL";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
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
                                    <a type="button" href="./hotel-room-types.php?id=<?php echo $row["id"]; ?>" class="btn btn-info btn-sm">ประเภทห้อง</a>
                                </td>
                                <td>
                                    <a href="./edit-hotel.php?id=<?php echo $row["id"]; ?>"
                                       class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="delHotel(<?php echo $row["id"]; ?>);"
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