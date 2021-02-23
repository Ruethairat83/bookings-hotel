<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row mt-4 mb-4">
        <div class="col-12 col-md-5 mx-auto">
            <div class="card w-100 rounded shadow">
                <div class="card-body">
                    <h4 class="mb-4 text-center">Login</h4>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button class="btn btn-primary mt-3 mb-2 w-100" onclick="checkLogin();">Login</button>
                    <hr>
                    <a href="./register.php" class="d-block text-center">ยังไม่มีบัญชีผู้ใช้ ? สมัครสมาชิก</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "./layouts/footer.php"; ?>


<script>
    $(document).ready(function () {

    });


    function checkLogin() {
        if ($("#username").val() && $("#password").val()) {
            let formData = new FormData();
            formData.append("username", $("#username").val());
            formData.append("password", $("#password").val());
            $.ajax({
                type: "POST",
                url: "./functions/checklogin.php",
                data: formData,
                contentType: false,
                cache: false,
                dataType: "json",
                processData: false,
                success: function (res) {
                    if (res.success) {
                        if(res.result[0]["role"] === "user") {
                            location.href = "index.php";
                        } else {
                            location.href = "admin-hotel.php";
                        }
                    } else {
                        Swal.fire({
                            title: 'Login',
                            text: "ชื่อผู้ใช้ไม่พบในระบบ",
                            icon: 'warning',
                            confirmButtonText: "ตกลง",
                            cancelButtonText: "ยกเลิก",
                            showCancelButton: false,
                            showCloseButton: false
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                title: 'Login',
                text: "กรุณากรอกชื่อผู้ใช้งานและรหัสผ่าน",
                icon: 'warning',
                confirmButtonText: "ตกลง",
                cancelButtonText: "ยกเลิก",
                showCancelButton: false,
                showCloseButton: false
            });
        }
    }

</script>
