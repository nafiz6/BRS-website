<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sufee Admin - HTML5 Admin Template</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=fnhlh7r9okafmxjej4jnq32yhr5tndinj0q1anbrxekd161f"></script>
    <script>tinymce.init({ selector:'textarea',
            plugins: "image",
            menubar1: "insert"});</script>

    <?php

    include "session.php";
    include $_SERVER['DOCUMENT_ROOT'].'/../phpincludes/auth.php';


    if (mysqli_connect_errno()) {
        echo "COULD NOT CONNECT TO DATABASE";
        exit();
    }

    $author = $_SESSION['profile']['name'];
    $date= date("d-m-y");
    $success=false;




    ?>


</head>
<body>
        <!-- Left Panel -->

        <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default">

                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
                    <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
                </div>

                <div id="main-menu" class="main-menu collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="index.php"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                        </li>
                        <li>
                            <a href="new-post.php"> <i class="menu-icon fa fa-th"></i>New Post </a>
                            <a href="stats.php"> <i class="menu-icon fa fa-bar-chart"></i>Stats </a>
                            <a href="member-info.php"> <i class="menu-icon fa fa-area-chart"></i>Member Info </a>
                        </li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </aside><!-- /#left-panel -->

        <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>

                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>
                            <a class="nav-link" href="#"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>



                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->



        <div class="content mt-3">
            <?php
            if ($_SERVER['REQUEST_METHOD']=='POST'){
                if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['story'])){
                    $url=urlencode(str_replace(' ','-',strtolower($_POST['title'])));

                    $target_dir = "../assets/img/blog/";
                    $target_file = $target_dir . basename($_FILES["file-input"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $img=$url.".".$imageFileType;


                    if ($location = mysqli_prepare($con, "SELECT id FROM posts WHERE url= ?")){
                        mysqli_stmt_bind_param($location, "s", $url);
                        mysqli_stmt_execute($location);
                        $result = mysqli_stmt_get_result($location);
                        $num = mysqli_num_rows($result);
                    }
                    include "upload.php";

                    if ($num==0 && $uploadOk==1) {


                        if ($location = mysqli_prepare($con, "INSERT INTO posts (title, medialink, author, date, description, url) "
                            . "VALUES (?, ?, ?, ?, ?, ?)")) {
                            mysqli_stmt_bind_param($location, "ssssss", $_POST['title'], $img, $author,
                                $date, $_POST['description'], $url);
                            mysqli_stmt_execute($location);

                        }
                        $res = mysqli_query($con, "SELECT * FROM posts WHERE url='$url'");
                        $id = mysqli_fetch_array($res);
                        if ($location = mysqli_prepare($con, "INSERT INTO content (id, story) VALUES (?, ?)")) {
                            mysqli_stmt_bind_param($location, "ss", $id['id'], $_POST['story']);
                            mysqli_stmt_execute($location);
                            $success = true;

                        }
                    }
                    else{
                        echo "The article already exists!";
                        $success=false;
                    }







                }
                else{
                    echo "Please enter everything";
                }
            }
            ?>
            <div class="animated fadeIn">
                <?php if ($success){?>
                <div class="alert alert-success" role="alert">
                    The post has been submitted successfully!

                </div>
                <?php }?>

                <div class="row">


                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <strong>New Post</strong>
                      </div>
                      <div class="card-body card-block">
                        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Title</label></div>
                            <div class="col-12 col-md-9"><input type="text" id="text-input" name="title" placeholder="Text" class="form-control"><small class="form-text text-muted">Enter Title</small></div>
                          </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Description</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="description" placeholder="Text" class="form-control"><small class="form-text text-muted">Description or Preview Text</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Author</label></div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static"><?php echo $author?></p>
                                </div>
                            </div>

                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Date</label></div>
                            <div class="col-12 col-md-9"><div class="input-group">
                                    <p class="form-control-static"><?php echo date("d-m-Y"); ?></p>
                                </div><small class="form-text text-muted">Publishing Date</small></div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Article</label></div>
                            <div class="col-12 col-md-9"><textarea name="story" id="textarea-input" rows="9" placeholder="Content..." class="form-control"></textarea></div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="file-input" class=" form-control-label">Thumbnail</label></div>
                            <div class="col-12 col-md-9"><input type="file" id="file-input" accept="image/*" name="file-input" class="form-control-file"></div>
                          </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-dot-circle-o"></i> Submit
                                </button>

                            </div>
                        </form>
                      </div>

                    </div>

                  </div>


                </div>


            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


</body>
</html>
