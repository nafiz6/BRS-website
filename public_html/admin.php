<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BUET Robotics Society</title>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald|Oxygen" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/blog/admin.css">
    <link rel="stylesheet" href="assets/css/blog/blog-styles.css">

    <?php include $_SERVER['DOCUMENT_ROOT'].'/../phpincludes/auth.php';

    if (mysqli_connect_errno()) {
        echo "COULD NOT CONNECT TO DATABASE";
        exit();
    }

    session_start();


    ?>


</head>

<body>
    <header>
        <a href="#"><img src="assets/img/logo.png" alt="logo"></a>
        <nav>
            <li><a href="index.php">Home</a></li>
            <li><a href="carnival.html">Events</a></li>
            <li><a href="blog.php">Blog</a></li>
                <!-- <li><a href="#">About</a></li> -->
                <!-- <li><a href="contact.html">Contacts</a></li> -->
        </nav>
    </header>
    <section>

        <div class='content-wrap'>
            <div class="form-block">
            <?php
                if ($_SERVER['REQUEST_METHOD']=='POST'){
                    $num=0;
                    if ($location = mysqli_prepare($con, "SELECT * FROM admin WHERE username= ?")){
                        mysqli_stmt_bind_param($location, "s", $_POST['username']);
                        mysqli_stmt_execute($location);
                        $result = mysqli_stmt_get_result($location);
                        $num = mysqli_num_rows($result);
                    }
                    if ($num==0){
                        $_SESSION['message']="The username doesn't exist";
                    }
                    else{
                        $user = mysqli_fetch_assoc($result);
                        if (password_verify($_POST['password'],$user['pass'])){
                            $id= $user['brs_id'];
                            $res=mysqli_query($con,"SELECT * FROM admin WHERE brs_id='$id'");
                            $userProfile = mysqli_fetch_array($res);

                            $_SESSION['message']="Hi ". $userProfile['name'];
                            $_SESSION['username']=$userProfile['username'];
                            header("location: ./admin/");

                        }
                        else{
                            $_SESSION['message']="You shall not pass!";
                        }
                    }
                    echo "<h2>".$_SESSION['message']."</h2>";


                }
                else {
            ?>

                    <h1>Login</h1>
                    <form action="admin.php" method="post">
                        <input type="text" name="username" placeholder="Username"><br>
                        <input type="password" name="password" placeholder="Password">
                        <input type="submit" value="Login">
                    </form>
                </div>

            <?php
                }
            ?>

        </div>
    </section>
</body>
</html>