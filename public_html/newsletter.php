<?php
    include $_SERVER['DOCUMENT_ROOT'].'/../phpincludes/auth.php';

    if (mysqli_connect_errno()) {
        echo "COULD NOT CONNECT TO DATABASE";
        exit();
    }

    $_SESSION['newsletter-message']='';
    $valid=false;
    $err='';
    if ($_SERVER['REQUEST_METHOD']=='POST'){

        $email= $con->escape_string($_POST['email']);

        $err="";
        $valid=true;

        $num=0;
        if ($location = mysqli_prepare($con, "SELECT * FROM newsletter WHERE email= ?")){
            mysqli_stmt_bind_param($location, "s", $email);
            mysqli_stmt_execute($location);
            $result = mysqli_stmt_get_result($location);
            $num = mysqli_num_rows($result);
        }


        if (empty($_POST['email'])){
            $err="Please enter all the information.";
            $valid=false;
        }


        elseif ($num>0){
            $err="The email already exists!";
            $valid=false;
        }




        if ($valid){
            if ($location = mysqli_prepare($con, "INSERT INTO newsletter (email) "
                                                        ."VALUES (?)")){
                mysqli_stmt_bind_param($location, "s",$email);
                mysqli_stmt_execute($location);
                $_SESSION['newsletter-message']="Thanks for subscribing!";

                echo "<h2>".$_SESSION['newsletter-message']."</h2>";
            }

        }






    }
    if (!$valid) {
        echo $err;
    }?>

<script>
    var valid = "<?php echo $valid; ?>";
    if (valid){

        var newsForm = document.getElementById("news-form");
        newsForm.parentNode.removeChild(newsForm);

    }
</script>