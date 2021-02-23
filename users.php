<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="tb-hotel">
                    <thead>
                    <tr>
                    <th>รหัสพนักงาน</th>
                        <th>อีเมล</th>
                        <th>รหัสผ่าน</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>เบอร์โทร</th>
                        <th style="width: 8rem;">คำสั่ง</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM users ";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                            <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["password"]; ?></td>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td><?php echo $row["lastname"]; ?></td>
                                <td><?php echo $row["mobile"]; ?></td>
                                <td>
                                    <a href="./edit-users.php?id=<?php echo $row["id"]; ?>"
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
            text: "คุณต้องการลบข้อมูลพนักงาน ?",
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
                    url: "./functions/delete-users.php",
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