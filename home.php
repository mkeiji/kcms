<?php

/* session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('authenticate.php');


/* last page nav
-----------------------------------------------*/
$_SESSION['lastPage1'] = $_SESSION['lastPage2'];
$_SESSION['lastPage2'] = 'home.php';


/* variables
-----------------------------------------------*/
$userType = $_SESSION['usertype'];


/* query for project category
-----------------------------------------------*/
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
<html>
<head>
    <meta charset="utf-8">
    <title>K' Website</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/loginFrame.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="css/login.css">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="js/loginFrame.js"></script>
</head>

<body>
    <div>
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
                            <?php if ($userType == 'admin'): ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Administration Tools <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="manage.php?manage=users">Manage Users</a></li>
                                        <li><a href="manage.php?manage=projects">Manage Projects</a></li>
                                        <li><a href="manage.php?manage=posts">Manage Posts</a></li>
                                        <li><a href="manage.php?manage=categories">Manage Categories (project)</a></li>
                                        <li role="separator" class="divider"></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="nav-item">
                                <a href="#">Hello,  <?= $_SESSION['userFirstName'] ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="logout.php"> Logout</a> <!-- logout.php -->
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div id="homeContainer" class="container">
                <div class="card card-container">
                    <img id="profile-img" class="profile-img-card" src="css/img/K_LOGO.png" alt="logo1" height="25" />
                    <p id="profile-name" class="profile-name-card"></p>
                    <p>HELLO <?= $_SESSION['userFirstName'] ?>, (<?= $_SESSION['usertype'] ?>)</p>
                    <p>Ur logged in as: <?= $_SESSION['username'] ?>.</p>
                    <p>Ur user ID is: <?= $_SESSION['userId'] ?>.</p>
                    <p>Ur registered phone is: <?= $_SESSION['phone'] ?></p>
                    <p>Ur registered email is: <?= $_SESSION['email'] ?></p>
                </div><!-- /card-container -->
            </div><!-- /container -->
<!--        --><?php //endif; ?>
    </div>
</body>