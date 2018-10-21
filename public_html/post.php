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
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/blog/blog-styles.css">

    <?php include $_SERVER['DOCUMENT_ROOT'].'/../phpincludes/auth.php';

    if (mysqli_connect_errno()) {
        echo "COULD NOT CONNECT TO DATABASE";
        exit();
    }

    $url = $_GET["url"];

    if ($location = mysqli_prepare($con, "SELECT *,DATE_FORMAT(date, '%d %M %Y') FROM posts WHERE url= ?")){
        mysqli_stmt_bind_param($location, "s", $url);
        mysqli_stmt_execute($location);
        $result = mysqli_stmt_get_result($location);
        $num = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
    }
    if ($location = mysqli_prepare($con, "SELECT * FROM content WHERE id= ?")){
        mysqli_stmt_bind_param($location, "s", $row["id"]);
        mysqli_stmt_execute($location);
        $result = mysqli_stmt_get_result($location);
        $content = mysqli_fetch_assoc($result);
    }

    $popular = mysqli_query(
        $con,
        "SELECT title, medialink, author,url, DATE_FORMAT(date, '%d %M %Y') FROM posts WHERE 1 ORDER BY views DESC LIMIT 4"
    );

    $latest = mysqli_query(
        $con,
        "SELECT title, medialink, author,url, DATE_FORMAT(date, '%d %M %Y') FROM posts WHERE 1 ORDER BY date DESC LIMIT 3"
    );

    session_start();

    if (!isset($_SESSION[$row["url"]])){
        if ($location = mysqli_prepare($con, "UPDATE posts SET views=views + 1 WHERE id=?")){
            mysqli_stmt_bind_param($location, "s", $row["id"]);
            mysqli_stmt_execute($location);
            $_SESSION[$row["url"]] = 1;

        }

    }

    ?>

</head>

<body>
    <header>
        <a href="#"><img src="../assets/img/logo.png" alt="logo"></a>
        <nav>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../carnival.html">Events</a></li>
            <li><a href="../blog.php">Blog</a></li>
                <!-- <li><a href="#">About</a></li> -->
                <!-- <li><a href="contact.html">Contacts</a></li> -->
        </nav>
    </header>
    <section>

        <div class='content-wrap'>
            <div class="post-container">
                <h1><?php echo $row["title"];?></h1>
                <a><?php echo $row["DATE_FORMAT(date, '%d %M %Y')"];?>&nbsp &nbsp By <?php echo $row["author"];?></a>

                <img src="../assets/img/blog/<?php echo $row["medialink"];?>">

                <?php echo $content["story"];?>


            </div>

            <div class="blog-popular-container">
                <h1>Popular>></h1>
                <?php
                while($row = mysqli_fetch_array($popular)) {
                    ?>
                    <div class="blog-popular">
                        <a href="<?php echo $row["url"];?>"><img class="blog-popular-img" src="../assets/img/blog/<?php echo $row["medialink"];?>"></a>
                        <div class="blog-desc">
                            <a href="<?php echo $row["url"];?>"><h3><?php echo $row["title"];?></h3></a>
                            <a><?php echo $row["DATE_FORMAT(date, '%d %M %Y')"];?> &nbsp &nbsp By <?php echo $row["author"];?></a>
                        </div>

                    </div>
                    <?php
                }
                ?>

            </div>

            <div class="related-container">
                <h1>Other Posts</h1>
                <?php
                    while($row = mysqli_fetch_array($latest)){
                ?>

                <div class="related">
                    <a href="<?php echo $row["url"];?>"><img src="../assets/img/blog/<?php echo $row["medialink"];?>"></a>

                    <a href="<?php echo $row["url"];?>"><h2><?php echo $row["title"];?></h2></a>
                    <a><?php echo $row["DATE_FORMAT(date, '%d %M %Y')"];?> &nbsp &nbsp By <?php echo $row["author"];?></a>

                </div>
                <?php } ?>

            </div>




        </div>
    </section>
</body>
</html>