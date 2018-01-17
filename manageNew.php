<?php
/* db connection and session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('authenticate.php');


/* variables GET Parameters (sanitized)
-----------------------------------------------*/
//new TYPE (categories and projects)
$new = filter_input(INPUT_GET, 'new', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

/* navigation variables
-----------------------------------------------*/
$_SESSION['lastPage1']  = $_SESSION['lastPage2'];
$_SESSION['lastPage2']  = 'manageNew.php?new=' . $new;



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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>K' Website - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link media="all" type="text/css" rel="stylesheet" href="css/login.css">
    <!-- CSS - apply specific stylesheet depending on whats going to be manage -->
    <?php if ($new == 'category'): ?>
        <link href="css/loginFrame.css" rel="stylesheet">
    <?php else: ?>
        <link href="css/manage.css" rel="stylesheet">
    <?php endif; ?>

    <!-- JSCRIPT -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="js/loginFrame.js"></script>
    <!-- Jscript for the ckEditor (applied for project) -->
    <?php if ($new == 'project'): ?>
        <!-- ckEditor -->
        <script src="ckeditor/ckeditor.js"></script>
        <script src="ckeditor/samples/js/sample.js"></script>
        <link rel="stylesheet" href="toolbarconfigurator/lib/codemirror/neo.css">
    <?php endif; ?>
</head>

<body id="loginFrame">
<div class="container">
    <div class="card card-container">

        <!-- K logo appears on category but NOT in projects -->
        <?php if ($new != 'project'): ?>
            <img id="profile-img" class="profile-img-card" src="css/img/K_LOGO.png" alt="logo1" height="25" />
        <?php endif; ?>


        <!-- loading form for CATEGORY -->
        <?php if ($new == 'category'): ?>
        <p id="profile-name" class="profile-name-card">New <?= $new; ?></p><br>

        <form action="managerCUD.php" method="post" class="form-signin">
            <input type="text" name="categoryName" id="categoryName" class="form-control" placeholder="Category Name" required autofocus>

            <button name="newCategory" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Add Category</button>
            <button name="cancel" type="submit" class="btn btn-default">Cancel</button>
        </form>
        <?php endif; ?>


        <!-- loading form for PROJECT -->
        <?php if ($new == 'project'): ?>
            <div id="projectImgContainer">
                <!-- uploaded image (for when user reload the page after uploading it -->
                <img id="projectImg" class="profile-img-card" src="<?= $_SESSION['currentProjImg']; ?>" alt="no image" height="25" />
                <!-- upload IMG form -->
                <form id="projectImgUp" method='post' enctype='multipart/form-data' action="fileUD.php">
                    <label for='image'>Add IMAGE:</label><br><br>
                    <input type='file' name='image' id='image'>
                    <input type='submit' name='uploadImg' value='Upload Image'>
                </form>
            </div>

            <p id="profile-name" class="profile-name-card">New <?= $new; ?></p><br>
            <form action="managerCUD.php" method="post" class="form-horizontal">
                <fieldset>
                    <input id="projectTitle"   name="title"   type="text" class="form-control" placeholder="Project Title" required>
                    <input id="projectSummary" name="summary" type="text" class="form-control" placeholder="Summary" required>
                    <select id="projectCategory" name="category" style="margin-bottom: 5px;" required>
                        <!-- just the first option used as a label -->
                        <option value="label" selected>--Choose a Category--</option>

                        <!-- looping through the categories -->
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category'] ?>"> <?= $category['category'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <textarea id="WYSIWYG" class="ckeditor" name="content" placeholder="Content" required></textarea>
                    <input type="hidden" name="imgPath" value="<?= $_SESSION['currentProjImg']; ?>" />

                    <!-- buttons -->
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button name="newProject" type="submit" class="btn btn-primary">Add Project</button>
                            <button name="cancelNewProject" type="submit" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        <?php endif; ?>
    </div><!-- /card-container -->
</div><!-- /container -->

<?php if ($new == 'project'): ?>
    <!-- ckeditor -->
    <script>
        initSample();
    </script>
<?php endif; ?>

</body>
</html>
