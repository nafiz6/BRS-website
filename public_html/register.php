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
            <li><a href="index.html">Home</a></li>
            <li><a href="carnival.html">Events</a></li>
            <li><a href="blog.html">Blog</a></li>
                <!-- <li><a href="#">About</a></li> -->
                <!-- <li><a href="contact.html">Contacts</a></li> -->
        </nav>
    </header>
    <section>

        <div class='content-wrap'>
            <div class="form-block">
            <?php
            $_SESSION['message']='';
            $valid=false;
            $err='';
            if ($_SERVER['REQUEST_METHOD']=='POST'){

                $name= $con->escape_string($_POST['name']);
                $email= $con->escape_string($_POST['email']);
                $phone= filter_var($con->escape_string($_POST['phone']), FILTER_SANITIZE_NUMBER_INT);
                $id= $con->escape_string($_POST['id']);
                $dept= $con->escape_string($_POST['dept']);
                $batch= $con->escape_string($_POST['batch']);

                $err="";
                $valid=true;

                $num=0;
                if ($location = mysqli_prepare($con, "SELECT * FROM brs_member WHERE email= ?")){
                    mysqli_stmt_bind_param($location, "s", $email);
                    mysqli_stmt_execute($location);
                    $result = mysqli_stmt_get_result($location);
                    $num = mysqli_num_rows($result);
                }


                if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) ||
                    empty($_POST['id']) || empty($_POST['dept']) || empty($_POST['batch'])){
                    $err="Please enter all the information.";
                    $valid=false;
                }
                elseif (!preg_match("/^[a-zA-Z ]*$/",$name)){
                        $err= "Please use only letters and whitespaces for Name";
                        $valid=false;
                }

                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $err= "*Please provide a valid email";
                    $valid=false;
                }

                elseif (strlen($phone) < 10 || strlen($phone) > 14){
                    $err= "Please provide a valid phone number";
                    $valid=false;
                }
                elseif (strlen($id) !=7){
                    $err= "Please provide a valid ID";
                    $valid=false;
                }

                elseif ($num>0){
                    $err="The email already exists!";
                    $valid=false;
                }




                if ($valid){
                    if ($location = mysqli_prepare($con, "INSERT INTO brs_member (name, email, phone_no, student_id, department, batch) "
                                                                ."VALUES (?, ?, ?, ?, ?, ?)")){
                        mysqli_stmt_bind_param($location, "ssssss", $name, $email, $phone, $id, $dept, $batch);
                        mysqli_stmt_execute($location);
                        $_SESSION['message']="Your registration is complete!";

                        echo "<h2>".$_SESSION['message']."</h2>";
                    }

                }






            }
            if (!$valid){
            ?>


                <h1>Register</h1>
                <form action="register.php" method="post">
                    <input type="text" name="name" placeholder="Name"><br>
                    <input type="email" name="email" placeholder="E-mail"><br>
                    <input type="number" name="phone" placeholder="Phone number"><br>
                    <input type="number" name="id" placeholder="Student ID"><br>
                    <input type="text" name="dept" placeholder="Department"><br>
                    <input type="text" name="batch" placeholder="Batch"><br>
                    <a style="color: red"><?php echo $err;?></a>
                    <input class="button" type="submit" value="Register">
                </form>

            </div>
            <?php
            }
            ?>

        </div>
    </section>
</body>
</html>