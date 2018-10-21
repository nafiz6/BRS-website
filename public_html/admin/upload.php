<?php



if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file-input"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}


if ($_FILES["file-input"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    $success=false;
// if everything is ok, try to upload file
} else {
    $upload_file = $target_dir.$img;
    if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $upload_file)) {
        echo "The file ". basename( $_FILES["file-input"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $success=false;
        $uploadOk=0;
    }
}
