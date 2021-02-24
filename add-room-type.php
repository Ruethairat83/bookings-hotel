<?php include "./layouts/header.php"; ?>


<div class="container py-4">
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <h4>เพิ่มประเภทห้อง</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <form action="./functions/insert-room-type.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="hotel_id" name="hotel_id" value="<?php echo $_GET["hotel_id"]; ?>">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">ชื่อ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class="col-sm-2 col-form-label">ราคา</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" name="price" id="price" class="form-control">
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
