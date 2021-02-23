<?php include "./layouts/header.php"; ?>

<?php
$sql = "SELECT * FROM hotels WHERE 1 AND id = {$_GET["id"]} LIMIT 1";
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
            <h4>แก้ไขโรงแรม</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <form action="./functions/edit-hotel.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?php echo $row[0]["id"]; ?>">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">ชื่อ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?php echo $row[0]["name"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">ที่ตั้ง</label>
                    <div class="col-sm-10">
                        <textarea name="address" id="address" rows="5"
                                  class="form-control"><?php echo $row[0]["address"]; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="telephone" class="col-sm-2 col-form-label">เบอร์โทร</label>
                    <div class="col-sm-10">
                        <input type="tel" name="telephone" id="telephone" class="form-control"
                               value="<?php echo $row[0]["telephone"]; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">คำอธิบาย</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="description" rows="5"
                                  class="form-control"><?php echo $row[0]["description"]; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="file" class="col-sm-2 col-form-label">รูปภาพ</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <a type="button" class="btn btn-outline-danger" href="admin-hotel.php">ยกเลิก</a>
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
