<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row mt-4 mb-3">
        <div class="col-12 d-flex justify-content-between">
            <h4>ผู้ใช้ระบบ</h4>
            <a class="btn btn-primary" href="add-user.php">เพิ่มข้อมูลผู้ใช้ระบบ</a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <input type="text" oninput="searchUserAjax(this);"
                   class="form-control" name="search" id="search" placeholder="ค้นหา">
        </div>
    </div>

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
                    <tbody id="tbody-user">
            
             <?php
                    $sql = "SELECT * FROM users WHERE 1 AND deleted_at IS NULL";
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
                                    <a href="./edit-user.php?id=<?php echo $row["id"]; ?>"
                                       class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="delUser(<?php echo $row["id"]; ?>);"
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
        // $('#tb-hotel').DataTable({});
    });


    function delUser(id) {
        Swal.fire({
            title: 'ลบข้อมูล',
            text: "คุณต้องการลบข้อมูลผู้ใช้งานระบบ ?",
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


    function searchUserAjax(obj) {
        let formData = new FormData();
        formData.append("search", obj.value);
        var dataTable = "";
        $.ajax({
            type: "POST",
            url: "./functions/search-user-ajax.php",
            data: formData,
            contentType: false,
            cache: false,
            dataType: "json",
            processData: false,
            success: function (res) {
                if (res.result.length) {
                    for (var index = 0; index < res.result.length; index++) {
                        dataTable += `<tr>`;
                        dataTable += `<td>${res.result[index].id}</td>`;
                        dataTable += `<td>${res.result[index].email}</td>`;
                        dataTable += `<td>${res.result[index].password}</td>`;
                        dataTable += `<td>${res.result[index].firstname}</td>`;
                        dataTable += `<td>${res.result[index].lastname}</td>`;
                        dataTable += `<td>${res.result[index].mobile}</td>`;
                        dataTable += `<td><a href="./edit-user.php?id=${res.result[index].id}"
                                       class="btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไข">
                                        <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    <button class="btn btn-danger btn-sm" onclick="delUser(${res.result[index].id});"
                                            data-toggle="tooltip"
                                            title="ลบ">
                                        <i class="fas fa-trash"></i>
                                    </button></td>`;
                        dataTable += `</tr>`;
                    }
                } else {
                    dataTable += `<tr>`;
                    dataTable += `<td colspan="7" class="text-center">ไม่มีข้อมูล</td>`;
                    dataTable += `</tr>`;
                }

                $("#tbody-user").empty().append(dataTable);
            }
        });
    }
</script>