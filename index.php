<?php include "./layouts/header.php"; ?>


    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/travel_01.jpg" class="d-block w-100" alt="slide image 1">
            </div>
            <div class="carousel-item">
                <img src="assets/images/travel_02.jpg" class="d-block w-100" alt="slide image 2">
            </div>
            <div class="carousel-item">
                <img src="assets/images/travel_03.jpg" class="d-block w-100" alt="slide image 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container py-4">
        <div class="row mt-4 mb-3">
            <div class="col-12 d-flex justify-content-between">
                <h4>โรงแรม</h4>
                <a href="#">ดูเพิ่มเติม</a>
            </div>
        </div>
        <div class="row">
            <?php
            $sql = "SELECT * FROM hotels WHERE 1 AND deleted_at IS NULL";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-4">
                        <div class="card w-100">
                            <img src="assets/images/travel_05.jpg" class="card-img-top"
                                 alt="hotel img thumbnail <?php echo $row["id"]; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["name"]; ?></h5>
                                <p class="card-text">
                                    <?php echo $row["description"]; ?>
                                </p>
                                <a href="./hotel-detail.php?id=<?php echo $row["id"]; ?>"
                                   class="btn btn-primary">ดูเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-md-12 col-12">
                    <h5 class="text-center font-weight-light">ไม่มีข้อมูล</h5>
                </div>
                <?php
            }
            ?>
        </div>

        <hr>

        <div class="row my-4">
            <div class="col-12">
                <h4>Comments</h4>
            </div>
        </div>
        <div class="row my-4">
            <?php
            $sql = "SELECT result.* FROM (SELECT t1.*, t2.firstname, t3.name FROM comments AS t1 
               INNER JOIN (SELECT * FROM users) AS t2 ON t1.user_id = t2.id
               INNER JOIN (SELECT * FROM hotels) AS t3 ON t1.hotel_id = t3.id) AS result";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-12">
                        <div class="card w-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $row["firstname"] ?></h5>
                                <h5 class="card-title"><?php echo $row["name"] ?></h5>
                                <p class="card-text"><?php echo $row["comment"] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-md-12 col-12">
                    <h5 class="text-center font-weight-light">ไม่มีข้อมูล</h5>
                </div>
                <?php
            }
            ?>
        </div>

    </div>


<?php include "./layouts/footer.php"; ?>