<?php include "./layouts/header.php"; ?>


    <div class="container py-4">
        <div class="row mt-4 mb-4">
            <div class="col-12 col-md-5 mx-auto">
                <div class="card w-100 rounded shadow">
                    <div class="card-body">
                        <h4 class="mb-4 text-center">Register</h4>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="firstname">ชื่อ</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                        <div class="form-group">
                            <label for="lastname">นามสกุล</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="form-group">
                            <label for="mobile">เบอร์มือถือ</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile">
                        </div>
                        <button class="btn btn-primary mt-3 mb-2 w-100">บันทึก</button>
                        <hr>
                        <a href="./login.php" class="d-block text-center">มีบัญชีผู้ใช้แล้ว ? เข้าสู่ระบบ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include "./layouts/footer.php"; ?>