<?php
/* db connection and session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('authenticate.php');


/* variables
-----------------------------------------------*/
//sanitized postid GET value (char)
$orderBy = filter_input(INPUT_GET, 'orderBy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$_SESSION['projectId'] = $projectId = filter_input(INPUT_GET, 'projectId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//session variables
               $userType  = $_SESSION['usertype'];
               $username  = $_SESSION['username'];
                 $userId  = $_SESSION['userId'];
$_SESSION['pageRequest']  = 'projects.php?orderBy=dateCreated&projectId=' . $projectId;
   $_SESSION['lastPage']  = $_SESSION['thisPage'];
   $_SESSION['thisPage']  = 'projects.php?orderBy=dateCreated';


/* navigation variables
-----------------------------------------------*/
$_SESSION['lastPage1']  = $_SESSION['lastPage2'];
$_SESSION['lastPage2']  = 'projects.php?orderBy=' . $orderBy . '&projectId=' . $projectId;


/* DB queries
-----------------------------------------------*/
//getting the posts
$query = "SELECT * FROM projects 
          WHERE projectId = $projectId";
//prepare a PDOStatement object, $db is a PDO object that comes from connect.php
$statement = $db->prepare($query);
//run it
$statement->execute();
//save fech in the $posts variable
$project = $statement->fetchAll();

//getting all the data from users table AND posts table (using JOIN)
$query2 = "SELECT * FROM users, posts 
           WHERE users.userId = posts.userId 
           ORDER BY $orderBy DESC limit 5";
//prepare a PDOStatement object, $db is a PDO object that comes from connect.php
$statement = $db->prepare($query2);
//run it
$statement->execute();
//save fech in the $posts variable
$data = $statement->fetchAll();

//getting the categories
$query = "SELECT * 
          FROM categories";
//prepare a PDOStatement object, $db is a PDO object that comes from connect.php
$statement = $db->prepare($query);
//run it
$statement->execute();
//save fech in the $posts variable
$categories = $statement->fetchAll();

////just checking what the query is pulling
//echo "<pre>\
//";
//print_r($data);
//echo "</pre>\
//";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="css/img/K_LOGO.png"> <!-- favicon -->

    <title>K' Website</title>

    <!-- Bootstrap core CSS & onepage scroll-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="css/onepage-scroll.css" rel="stylesheet" type="text/css">-->
    <!-- custom CSS -->
    <link href="css/custom.css" rel="stylesheet">


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10.css" rel="stylesheet">

    <!-- Custom styles -->
    <!--<link href="css/navbar-fixed-top.css" rel="stylesheet">-->

</head>

<body>

<!-- navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" id="logo"><img src="css/img/K_LOGO.png" alt="logo1" height="25"></a> <!-- logo -->
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Projects <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        <!-- looping through categories and displaying in the droptdown -->
                        <?php foreach ($categories as $category): ?>
                            <li><a href="projCategory.php?category=<?= $category['category'] ?>"> <?= $category['category'] ?> </a></li>
                        <?php endforeach; ?>
                        <!--  item for later implementation -->
                        <!--                                    <li role="separator" class="divider"></li>-->
                        <!--                                    <li class="dropdown-header">Nav header</li>-->
                        <!--                                    <li><a href="#">Separated link</a></li>-->
                        <!--                                    <li><a href="#">One more separated link</a></li>-->

                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item">
                    <a href="home.php">Hello,  <?= $_SESSION['userFirstName']; ?></a>
                </li>
                <li class="nav-item">
                    <a href="logout.php"> Logout</a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- section 1 -->
<section id="oneProject">
    <div class="container">
        <div class="row">
            <div class="feature-content">
                <div class="col-lg-offset-1 col-lg-5" style="margin-bottom: auto;">
                    <img class="visible-lg visible-md" src="<?= $project[0]['imgPath'] ?>" alt="" height="300">
                </div>
                <div class="col-lg-5 col-lg-offset-1">
                    <h1><?= $project[0]['title']; ?>,</h1>
                    <p class="lead"><?= $project[0]['summary']; ?></p>
                    <p><?= html_entity_decode($project[0]['content']); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- section 2: COMMENTS -->
<section id="twoProject" class="feature-content">

    <!-- pull comments -->
    <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2" >
        <!-- comments navigation -->
        <nav id="commentNav" class = "navbar navbar-default">
            <div class = "navbar-header">
<!--                <a class = "navbar-brand" href = "#">Comments</a>-->
                <ul>
                    <li id="commentDd" class="dropdown navbar-brand">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Comments <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="projects.php?orderBy=dateCreated">By created date</a></li>
                            <li><a href="projects.php?orderBy=userName">By user</a></li>
                            <li><a href="projects.php?orderBy=dateModified">By modified date</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- navigation links -->
            <div id="commentLinks">
                <ul class = "nav navbar-nav navbar-right">
                    <li><a href = "newPost.php?projectId=<?= $projectId ?>">New post</a></li>
                    <li><a href = "">My posts</a></li>
                </ul>
            </div>
        </nav>
        <!-- comments pulled from db -->
        <div id="all_blogs">
            <div class="blog_post">
                <?php foreach ($data as $x): ?>
                <?php if ($x['projectId'] == $project[0]['projectId']): ?>
                    <h2><?= $x['title'] ?></h2>
                    <p>
                        <small>
                            <?php
                            $date = $x['dateCreated'];
                            $dateMod = $x['dateModified'];
                            echo nl2br('Posted by ' . $x['userName'] . ' in ' . date("F j, Y, g:i a", strtotime($date)));

                            if ($dateMod != null) {
                                echo nl2br("\n" . 'modified in ' . date("F j, Y, g:i a", strtotime($dateMod)));
                            }
                            ?>
                            <?php if ($userId == $x['userId'] || $userType == 'admin'): ?>
                                <a href="editPost.php?postId=<?=$x['postId']?>"> - edit</a>
                            <?php endif; ?>
                        </small>
                    </p>

                    <!-- comment from DB, because of WYSIWYG the content already has <p></p> -->
                    <?= html_entity_decode($x['content']); ?>
                        <!-- try html_entity_decode($a) -->

                <?php endif; ?>
                <?php endforeach; ?>
            </div> <!-- end blog post -->
        </div> <!-- end all blogs -->
    </div>
</section>

<footer id="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-4">
                <br><br><br>
                <p style="color: lightgrey">Copyright &copy; Guilherme Keiji Minekawa Maeda.</p>
                <p>All rights reserved.</p>
            </div>
            <div class="col-lg-4 col-lg-offset-2">
                <h6>My work</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Skills</a></li>
                    <li><a href="#">Something Else</a></li>
                </ul>
            </div>
            <!--<div class="col-md-2">-->
            <!--<ul class="list-unstyled">-->
            <!--<h6>links</h6>-->
            <!--<li><a href="#">work1</a></li>-->
            <!--<li><a href="#">work2</a></li>-->
            <!--<li><a href="#">work3</a></li>-->
            <!--<li><a href="#">work4</a></li>-->
            <!--</ul>-->
            <!--</div>-->
        </div>
    </div>
</footer>

<!-- some jumbotron example -->
<!--<div class="container">-->
<!--<div class="jumbotron">-->
<!--<h1>Navbar example</h1>-->
<!--<p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>-->
<!--<p>To see the difference between static and fixed top navbars, just scroll.</p>-->
<!--<p>-->
<!--<a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>-->
<!--</p>-->
<!--</div>-->
<!--</div> &lt;!&ndash; /container &ndash;&gt;-->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--jQuery and bootstrap script-->
<script src="js/jquery-3.1.1.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="js/jquery.onepage-scroll.js"></script>-->
<!--<script src="js/kScript.js" type="text/javascript"></script>-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>

<!-- Just for debugging purposes -->
<script src="js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>
