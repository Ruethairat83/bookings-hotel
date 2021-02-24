<?php include "./layouts/header.php"; ?>

<?php
$sql = "SELECT * FROM users WHERE 1 AND id = {$_GET["id"]} LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $row = [];
}
?>

<div class="container py-4">
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <h4>แก้ไขข้อมูลพนักงาน</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <form action="./functions/edit-users.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?php echo $row[0]["id"]; ?>">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email"
                               value="<?php echo $row[0]["email"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="password" name="password"
                               value="<?php echo $row[0]["password"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="firstname" class="col-sm-2 col-form-label">ชื่อ</label>
                    <div class="col-sm-10">
                        <input type="text" name="firstname" id="firstname" class="form-control"
                               value="<?php echo $row[0]["firstname"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lastname" class="col-sm-2 col-form-label">นามสกุล</label>
                    <div class="col-sm-10">
                        <input type="text" name="lastname" id="lastname" class="form-control"
                               value="<?php echo $row[0]["lastname"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-sm-2 col-form-label">เบอร์โทร</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" id="mobile" name="mobile"
                               value="<?php echo $row[0]["mobile"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <textarea class="form-control"
                                  id="address" name="address"><?php echo $row[0]["address"]; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <a type="button" class="btn btn-outline-danger" href="admin-user.php">ยกเลิก</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include "./layouts/footer.php"; ?>


<script>
    $(document).ready(function () {
    });
</script>
