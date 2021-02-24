<?php include "./layouts/header.php"; ?>


<?php
$sql = "SELECT * FROM hotel_rooms WHERE 1 AND id = {$_GET["id"]} LIMIT 1";
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
            <h4>เพิ่มประเภทห้อง</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <form action="./functions/edit-room.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
                <input type="hidden" id="hotel_id" name="hotel_id" value="<?php echo $_GET["hotel_id"]; ?>">
                <input type="hidden" id="room_type_id" name="room_type_id" value="<?php echo $_GET["room_type_id"]; ?>">
                <div class="form-group row">
                    <label for="room_no" class="col-sm-2 col-form-label">เลขห้อง</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="room_no" name="room_no"
                               value="<?php echo $row[0]["room_no"]; ?>">
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
