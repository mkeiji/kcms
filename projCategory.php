<?php
/* session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('authenticate.php');


/* variables
-----------------------------------------------*/
$_SESSION['lastPage']  = $_SESSION['thisPage'];
$_SESSION['thisPage']  = 'academicProj.php';


//sanitized category GET value (char)
$category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


/* DB queries
-----------------------------------------------*/
//getting data from projects table
$query = "SELECT * FROM projects WHERE category = '$category'";
//prepare a PDOStatement object, $db is a PDO object that comes from connect.php
$statement = $db->prepare($query);
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
                    <!--<button type="button" class="btn btn-default btn-sm navbar-btn" id="btnLogin">Login</button>-->
                    <a href="home.php">Hello, <?= $_SESSION['userFirstName']; ?></a>
                </li>
                <li class="nav-item">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- homepage -->
<!--<div id="home">-->
    <!--<h3 id="kName" class="visible-lg visible-md"> guilherme KEIJI maeda</h3>-->
    <!--<div id="homeIconsLeft" class="div-wrapper">-->
        <!--<a href="#"><img id="fbHome" class="hoverTransform" src="css/img/fb_icon.png" alt="" height="40"></a>-->
        <!--<a href="#"><img id="googlePlusHome" class="hoverTransform" src="css/img/googlePlus_icon.png" alt="" height="40"></a>-->
        <!--<a href="#"><img id="linkedinHome" class="hoverTransform" src="css/img/linkedin_icon.png" alt="" height="40"></a>-->
    <!--</div>-->
    <!--<div id="homeIconsRight" class="div-wrapper">-->
        <!--<a href="#"><img id="emailHome" class="hoverTransform" src="css/img/email_icon.png" alt="" height="40"></a>-->
    <!--</div>-->
<!--</div>-->

<!-- section 1 -->
<section id="one">
    <div class="container">
        <div class="row">
            <div class="feature-content">
                <?php foreach ($data as $x): ?>
                <div class="col-lg-offset-1 col-lg-5" style="margin-bottom: auto;">
                    <a href="projects.php?orderBy=dateCreated&projectId=<?= $x['projectId'] ?>"><img class="visible-lg visible-md" src="<?= $x['imgPath']; ?>" alt="" height="300"></a>
                </div>
                <div class="col-lg-5 col-lg-offset-1">
                    <h1><?= $x['title']; ?>,</h1>
                    <p class="lead"><?= $x['summary']; ?></p>
                    <p><?= html_entity_decode($x['content']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!--<section id="two" class="feature-dark">-->
    <!--<div class="container">-->
        <!--<div class="row">-->
            <!--<div class="feature-content">-->
                <!--<div class="col-lg-6 feature-caption">-->
                    <!--<h6>all about versatility</h6>-->
                    <!--<h1>Check out some of my Skills</h1>-->
                    <!--<p class="lead">So far, I'm good at:</p>-->
                    <!--<p>Web Development, Application Development and Database. <br>-->
                        <!--Here is some stuff I can do: HTML5, CSS3, PHP, JavaScript, XML, XSLT, C# .NET (MVC, WebServices and Windows Applications),-->
                        <!--Java, Python, Ruby, PL/SQL, MySQL and SQL Server</p><br>-->
                    <!--<a href="" type="button" class="btn btn-default btn-lg">Check all the action</a>-->
                <!--</div>-->
                <!--<div class="col-lg-6 text-sm-center">-->
                    <!--<img class="visible-lg visible-md" src="css/img/phone.png" alt="skillsimg" height="500">-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</section>-->

<!--<section id="three">-->
    <!--<div class="container">-->
        <!--<div class="row">-->
            <!--<div class="feature-content">-->
                <!--<div class="col-lg-8 col-lg-offset-2">-->
                    <!--<h6>all about versatility</h6>-->
                    <!--<h2>Check out some of my Skills</h2>-->
                    <!--<p class="lead">So far, I'm good at:</p>-->
                    <!--<p>Web Development, Application Development and Database. <br>-->
                        <!--Here is some stuff I can do: HTML5, CSS3, PHP, JavaScript, XML, XSLT, C# .NET (MVC, WebServices and Windows Applications),-->
                        <!--Java, Python, Ruby, PL/SQL, MySQL and SQL Server</p>-->
                    <!--<a href="" type="button" class="btn btn-success btn-lg">Check all the action</a>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--</section>-->

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
