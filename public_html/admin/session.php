<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'].'/phpincludes/auth.php';

    if (mysqli_connect_errno()) {
        echo "COULD NOT CONNECT TO DATABASE";
        exit();
    }
    if (!isset($_SESSION['username'])){
        header("location:../admin.php");
    }

    $user = $_SESSION['username'];
    if ($location = mysqli_prepare($con, "SELECT * FROM admin WHERE username= ?")){
        mysqli_stmt_bind_param($location, "s", $user);
        mysqli_stmt_execute($location);
        $result = mysqli_stmt_get_result($location);
        $num = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
    }
    if ($location = mysqli_prepare($con, "SELECT * FROM brs_member WHERE brs_id= ?")){
        mysqli_stmt_bind_param($location, "s", $row['brs_id']);
        mysqli_stmt_execute($location);
        $result = mysqli_stmt_get_result($location);
        $num = mysqli_num_rows($result);
    }
    $row=mysqli_fetch_assoc($result);
    $_SESSION['profile']=$row;




