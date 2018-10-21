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

    $latest = mysqli_query(
        $con,
        "SELECT title, description, medialink, author, DATE_FORMAT(date, '%d %M %Y'), url FROM posts WHERE 1 ORDER BY date DESC"
    );
    $num = mysqli_num_rows($latest);
    $popular = mysqli_query(
        $con,
        "SELECT title, medialink, author, DATE_FORMAT(date, '%d %M %Y'),url FROM posts WHERE 1 ORDER BY views DESC LIMIT 4"
    );
    $num_pop = mysqli_num_rows($latest);


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
            <div class="blog-latest-container">
                <?php if ($num>0){?>
                <h1>Latest</h1>
                <?php

                    for ($x=0;$x<min($num,4);$x++){
                        $row = mysqli_fetch_array($latest);
                ?>
                <div class="blog-latest">
                    <a href="post/<?php echo $row["url"];?>"><div class="latest-img-container"><img src="assets/img/blog/<?php echo $row["medialink"]; ?>"></a></div>

                    <a  href="post/<?php echo $row["url"];?>"><h2><?php echo $row["title"];?></h2></a>
                    <a class="credits"><?php echo $row["DATE_FORMAT(date, '%d %M %Y')"];?> &nbsp &nbsp By <?php echo $row["author"];?></a>
                    <?php echo $row["description"]?>
                    <a href="post/<?php echo $row["url"];?>"><div class="read-more">Read More</div></a>

                </div>
                <?php }}?>

            </div>

            <div class="blog-popular-container">
                <?php if ($num_pop>0){?>
                <h1>Popular</h1>
                <?php
                    while($row = mysqli_fetch_array($popular)) {
                ?>
                        <div class="blog-popular">
                            <a href="post/<?php echo $row["url"];?>"><img class="blog-popular-img" src="assets/img/blog/<?php echo $row["medialink"];?>"></a>
                            <div class="blog-desc">
                                <a href="post/<?php echo $row["url"];?>"><h3><?php echo $row["title"];?></h3></a>
                                <a class="credits"><?php echo $row["DATE_FORMAT(date, '%d %M %Y')"];?> &nbsp &nbsp By <?php echo $row["author"];?></a>
                            </div>

                        </div>
                <?php
                    }}
                ?>

            </div>

            <div class="blog-archives-container">

                <?php
                if ($num>4){?>

                <h1>Archives</h1>
                <?php
                while($row = mysqli_fetch_array($latest)){
                    ?>
                <div class="blog-content">

                    <a href="post/<?php echo $row["url"];?>"><img class="blog-img" src="assets/img/blog/<?php echo $row["medialink"];?>"></a>
                    <div class="blog-desc">
                        <a href="post/<?php echo $row["url"];?>"><h1><?php echo $row["title"];?></h1></a>
                        <a class="credits"><?php echo $row["DATE_FORMAT(date, '%d %M %Y')"];?> &nbsp &nbsp By <?php echo $row["author"];?></a>
                        <?php echo $row["description"]?>
                        <br>
                        <br>
                        <a href="post/<?php echo $row["url"];?>"><div class="read-more">Read More</div></a>
                    </div>
                </div>
                <?php
                }}
                ?>

            </div>

        </div>
    </section>
</body>
</html>