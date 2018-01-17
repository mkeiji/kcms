<?php
/* navigation variables
-----------------------------------------------*/
$_SESSION['lastPage1']  = $_SESSION['lastPage2'];
$_SESSION['lastPage2']  = 'newPost.php';

/* db connection and session start
-----------------------------------------------*/
session_start();
include ('connect.php');
//require_once('recaptchalib.php');

/* variables
-----------------------------------------------*/
$username  = $_SESSION['username'];
$userId  = $_SESSION['userId'];
//sanitized project GET value (int)
$projectId = filter_input(INPUT_GET, 'projectId', FILTER_SANITIZE_NUMBER_INT);


/* navigation variables
-----------------------------------------------*/
$_SESSION['lastPage1']  = $_SESSION['lastPage2'];
$_SESSION['lastPage2']  = 'newPost.php?projectId=' . $projectId;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>K' Website - edit comment</title>

    <!-- CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/loginFrame.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="css/login.css">

    <!-- JAVASCRIPT -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="js/loginFrame.js"></script>

    <!-- ckEditor -->
    <script src="ckeditor/ckeditor.js"></script>
    <script src="ckeditor/samples/js/sample.js"></script>
    <link rel="stylesheet" href="toolbarconfigurator/lib/codemirror/neo.css">

    <!-- reCaptcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body id="loginFrame">
<div class="container">
    <div class="card card-container" style="max-width: 800px;">
        <img id="profile-img" class="profile-img-card" src="css/img/K_LOGO.png" alt="logo1" height="25" />
        <p id="profile-name" class="profile-name-card">New Post</p><br>
        <form action="insert.php" method="post" class="form-horizontal">
            <fieldset>
                <input id="postTitle" name="title" type="text" class="form-control" placeholder="Title">
                <textarea id="WYSIWYG" class="ckeditor" name="content"></textarea>

                <!-- reCaptcha -->
                <div class="g-recaptcha" data-sitekey="6LfK6QwUAAAAAMSGyYIQlKxWnGjFdfmbmdElT4qT"></div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <button name="newPost" type="submit" class="btn btn-primary button">Post</button>
                        <button name="cancel" type="submit" class="btn btn-default button">Cancel</button>
                    </div>
                </div>
            </fieldset>
        </form>
        <!--<a href="#" class="forgot-password">-->
        <!--Forgot the password?-->
        <!--</a>-->
    </div><!-- /card-container -->
</div><!-- /container -->

<!-- ckeditor -->
<script>
    initSample();
</script>

</body>
</html>
