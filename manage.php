<?php

/* db connection and session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('authenticate.php');

/* variables
-----------------------------------------------*/
//sanitized category GET value (char)
$manage = filter_input(INPUT_GET, 'manage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$userType = $_SESSION['usertype'];


/* last page nav
-----------------------------------------------*/
$_SESSION['lastPage1'] = $_SESSION['lastPage2'];
$_SESSION['lastPage2'] = 'manage.php?manage=' . $manage;


/* script & queries
-----------------------------------------------*/
//SELECT statement for USERS management
if ($manage == 'users') {
    //create a SELECT query on table users to check if it exist
    $query = "SELECT * FROM users";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fetch in the variable
    $users = $statement->fetchAll();
}


//SELECT statement for PROJECT management
if ($manage == 'projects') {
    //create a SELECT query on table projects to check if it exist
    $query = "SELECT * FROM projects";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fetch in the variable
    $projects = $statement->fetchAll();
}

//SELECT statement for POSTS management
if ($manage == 'posts') {
    //create a SELECT query on table posts to check if it exist
    $query = "SELECT * FROM posts";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fetch in the variable
    $posts = $statement->fetchAll();
}

//SELECT statement for CATEGORIES (projects) management
//create a SELECT query on table categories to check if it exist
$query = "SELECT * FROM categories";
//prepare a PDOStatement object, $db is a PDO object that comes from connect.php
$statement = $db->prepare($query);
//run it
$statement->execute();
//save fetch in the variable
$categories = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>K' Website</title>

    <!-- CSS -->
    <link rel="stylesheet" href="style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/manage.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="css/login.css">

    <!-- JScript & JQuery -->
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
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Projects <span class="caret"></span></a>
                        <ul class="dropdown-menu">

                            <!-- looping through categories and displaying in the droptdown -->
                            <?php foreach ($categories as $category): ?>
                                <li><a href="projCategory.php?category=<?= $category['category'] ?>"> <?= $category['category'] ?> </a></li>
                            <?php endforeach; ?>

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
                        <a href="home.php">Hello,  <?= $_SESSION['userFirstName'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php"> Logout</a> <!-- logout.php -->
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div id="homeContainer" class="container">
        <div id="cardContainer" class="card card-container">
            <img id="profile-img" class="profile-img-card" src="css/img/K_LOGO.png" alt="logo1" height="25" />
            <!-- loading manager tools for USERS page -->
            <?php if ($manage == 'users'): ?>
                <table border="2">
                    <tr>
                        <th colspan="1">
                            <h3>USERS</h3><br>
                        </th>
                    </tr>
                    <tr id="tableHeader">
                        <th>userId</th>
                        <th>userType</th>
                        <th>userName</th>
                        <th>firstName</th>
                        <th>lastName</th>
                        <th>phone</th>
                        <th>email</th>
                        <th></th>
                    </tr>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['userId'] ?></td>
                            <td><?= $user['userType'] ?></td>
                            <td><?= $user['userName'] ?></td>
                            <td><?= $user['firstName'] ?></td>
                            <td><?= $user['lastName'] ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td>
                                <a href="manageEdit.php?edit=<?= $manage ?>&id=<?= $user['userId'] ?>"> edit </a>
<!--                                <a href=""> | </a>-->
<!--                                <a href="manageEdit.php?edit=--><?//= $manage ?><!--&id=--><?//= $user['userId'] ?><!--"> delete</a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a href="register.html" name="register" type="submit" class="btn btn-primary button">New</a>
            <?php endif; ?>

            <!-- loading manager tools for PROJECTS page -->
            <?php if ($manage == 'projects'): ?>
                <table>
                    <tr>
                        <th colspan="1">
                            <h3>PROJECTS</h3><br>
                        </th>
                    </tr>
                    <tr id="tableHeader">
                        <th class="centralized">projectId</th>
                        <th>category</th>
                        <th>title</th>
<!--                        <th>summary</th>-->
                        <th>content</th>
<!--                        <th>imgPath</th>-->
                        <th></th>
                    </tr>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td class="centralized"><?= $project['projectId'] ?></td>
                            <td><?= $project['category'] ?></td>
                            <td><?= $project['title'] ?></td>
<!--                            <td>--><?//= $project['summary'] ?><!--</td>-->
                            <?php if (strlen($project['content']) < 200): ?>
                                <td id="projectContent"><?= html_entity_decode($project['content']) ?></td>
                            <?php else: ?>
                                <?php
                                    //cutting the comment if too big
                                    $contentCut = substr($project['content'], 0, 200);
                                    /*making sure the comment ends in a word and dont cut it in half using strrpos()*/
                                    $newContent = substr($contentCut, 0, strrpos($contentCut, ' '));
                                ?>
                                <td id="projectContent">
                                    <?= html_entity_decode($newContent); ?>
                                    <a href="#">...</a>
                                </td>
                            <?php endif; ?>
<!--                            <td>--><?//= $project['imgPath'] ?><!--</td>-->
                            <td>
                                <a href="manageEdit.php?edit=<?= $manage ?>&id=<?= $project['projectId'] ?>"> edit </a>
<!--                                <a href=""> | </a>-->
<!--                                <a href="#"> delete</a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a name="newProject" href="manageNew.php?new=project" type="submit" class="btn btn-primary button">New</a>
            <?php endif; ?>

            <!-- loading manager tools for POSTS page -->
            <?php if ($manage == 'posts'): ?>
                <table>
                    <tr>
                        <th colspan="1">
                            <h3>POSTS</h3><br>
                        </th>
                    </tr>
                    <tr id="tableHeader">
                        <th class="centralized">postId</th>
                        <th class="centralized">dateCreated</th>
                        <th class="centralized">dateModified</th>
                        <th class="centralized">projectId</th>
                        <th class="centralized">userId</th>
                        <th class="centralized">title</th>
                        <th class="centralized">content</th>
                        <th></th>
                    </tr>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td class="centralized"><?= $post['postId'] ?></td>
                            <td class="centralized"><?= date("Y/m/d H:i", strtotime($post['dateCreated'])) ?></td>

                            <!-- check if the post have been modified, if not, show msg -->
                            <?php if ($post['dateModified'] == null): ?>
                                <td class="centralized">not modified</td>
                            <!-- IF the post have been modified, display the modification date -->
                            <?php else: ?>
                                <td class="centralized"><?= date("Y/m/d H:i", strtotime($post['dateModified'])) ?></td>
                            <?php endif; ?>

                            <td class="centralized"><?= $post['projectId'] ?></td>
                            <td class="centralized"><?= $post['userId'] ?></td>
                            <td class="centralized"><?= $post['title'] ?></td>

                            <!-- check if the content is too big, if so, limit the characters -->
                            <?php if (strlen($post['content']) < 200): ?>
                                <td id="postContent" class="centralized"><?= html_entity_decode($post['content']) ?></td>
                            <?php else: ?>
                                <?php
                                //cutting the comment if too big
                                $contentCut = substr($post['content'], 0, 200);
                                /*making sure the comment ends in a word and dont cut it in half using strrpos()*/
                                $newContent = substr($contentCut, 0, strrpos($contentCut, ' '));
                                ?>
                                <td id="postContent">
                                    <?= $newContent; ?>
                                    <a href="#">...</a>
                                </td>
                            <?php endif; ?>

                            <td id="editcolumn">
                                <a href="manageEdit.php?edit=<?= $manage ?>&id=<?= $post['postId'] ?>"> edit </a>
<!--                                <a href=""> | </a>-->
<!--                                <a href="#"> delete</a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

            <!-- loading manager tools for project CATEGORIES page -->
            <?php if ($manage == 'categories'): ?>
                <table>
                    <tr>
                        <th colspan="1">
                            <h3>CATEGORIES</h3><br>
                        </th>
                    </tr>
                    <tr id="tableHeader">
                        <th class="centralized">categoryId</th>
                        <th>category</th>
                        <th></th>
                    </tr>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td class="centralized"><?= $category['categoryId'] ?></td>
                            <td><?= $category['category'] ?></td>
                            <!--                            <td>--><?//= $project['imgPath'] ?><!--</td>-->
                            <td>
                                <a href="manageEdit.php?edit=<?= $manage ?>&id=<?= $category['categoryId'] ?>"> edit </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a name="newCategory" href="manageNew.php?new=category" type="submit" class="btn btn-primary button">New</a>
            <?php endif; ?>

        </div><!-- /card-container -->
    </div><!-- /container -->
</div>
</body>