<?php
    include $_SERVER['DOCUMENT_ROOT'].'/../phpincludes/auth.php';

    if (mysqli_connect_errno()) {
        echo "COULD NOT CONNECT TO DATABASE";
        exit();
    }

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
    if (!$valid) {
        echo $err;
    }?>

<script>
    var valid = "<?php echo $valid; ?>";
    if (valid){

        var msg = document.getElementById("form-message-top");
        var f = document.getElementById("form");
        msg.parentNode.removeChild(msg);
        f.parentNode.removeChild(f);

    }
</script>