<?php

include "../config/database.php";

$res["result"] = [];
$res["success"] = false;


$target_dir = "../uploads/";
$file_name = "hotel_" . rand(0, 9) . "_" . date("Ymd_His") . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
$target_file = $target_dir . $file_name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO hotels (name, address, description, telephone, thumbnail_img)
                VALUES ('{$_POST["name"]}', '{$_POST["address"]}', '{$_POST["description"]}', 
                        '{$_POST["telephone"]}', '{$file_name}')";

        if ($conn->query($sql) === TRUE) {
            header("location: ../admin-hotel.php");
        } else {
            header("location: ../admin-hotel.php");
        }
        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}




