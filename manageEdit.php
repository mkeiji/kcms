<?php
/* db connection and session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('authenticate.php');


/* variables GET Parameters (sanitized)
-----------------------------------------------*/
//edit TYPE (users, projects or posts)
/*NOTE: the $id is only so the last page nav can get the ID
independent of the id being user/project/post */
$edit = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
/*-- variable for USERS management --*/
$id = $userId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/*-- variable for PROJECT management --*/
$id = $projectId = $_SESSION['projectId'] = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/*-- variable for POST management --*/
$id = $postId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/*-- variable for CATEGORY management --*/
$id = $categoryId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


/* last page nav
-----------------------------------------------*/
$_SESSION['lastPage1'] = $_SESSION['lastPage2'];
$_SESSION['lastPage2'] = 'manageEdit.php?edit=' . $edit . '&id=' . $id;


/* DB queries for loading data
-----------------------------------------------*/
//for USERS
if ($edit == 'users') {
    $query = "SELECT * FROM users
          WHERE userId = $userId";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fech in the $posts variable
    $user = $statement->fetchAll();

    /* variables
    -----------------------------------------------*/
    /*-- variables for USERS management --*/
    $userType = $user[0]['userType'];
    $userName = $user[0]['userName'];
    $firstName = $user[0]['firstName'];
    $lastName = $user[0]['lastName'];
    $phone = $user[0]['phone'];
    $email = $user[0]['email'];
}


//for PROJECTS
if ($edit == 'projects') {
    $query = "SELECT * FROM projects
          WHERE projectId = $projectId";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fech in the $posts variable
    $project = $statement->fetchAll();

    /* variables
    -----------------------------------------------*/
    /*-- variables for PROJECTS management --*/
    $pCategory = $project[0]['category'];
    $pTitle = $project[0]['title'];
    $pSummary = $project[0]['summary'];
    $pContent = $project[0]['content'];
    $pImgPath = $project[0]['imgPath'];


    /*-- querying to get all the categories --*/
    //those will be used to select the project category
    //getting the categories
    $query = "SELECT * 
          FROM categories";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fech in the $posts variable
    $categories = $statement->fetchAll();
}


//for POSTS
if ($edit == 'posts') {
    $query = "SELECT * FROM posts
              WHERE postId = $postId";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fech in the $posts variable
    $post = $statement->fetchAll();

    /* variables
    -----------------------------------------------*/
    /*-- variables for PROJECTS management --*/
    $postTitle = $post[0]['title'];
    $postContent = $post[0]['content'];
}

/*NOTE: for editing POSTS the form will call the regular
insert.php since there is no aditional info required*/


//for CATEGORIES
if ($edit == 'categories') {
    $query = "SELECT * 
              FROM categories
              WHERE categoryId = $categoryId";
    //prepare a PDOStatement object, $db is a PDO object that comes from connect.php
    $statement = $db->prepare($query);
    //run it
    $statement->execute();
    //save fech in the $posts variable
    $category = $statement->fetchAll();

    /* variables
    -----------------------------------------------*/
    /*-- variables for PROJECTS management --*/
    $categoryName = $category[0]['category'];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>K' Website - Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- CSS - apply specific stylesheet depending on whats going to be manage -->
    <?php if ($edit == 'users' || $edit == 'categories'): ?>
        <link href="css/loginFrame.css" rel="stylesheet">
    <?php else: ?>
        <link href="css/manage.css" rel="stylesheet">
    <?php endif; ?>
    <link media="all" type="text/css" rel="stylesheet" href="css/login.css">

    <!-- JScript & JQuery -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="js/loginFrame.js"></script>

    <!-- Jscript for the ckEditor (applied for projects and posts) -->
    <?php if ($edit == 'projects' || $edit == 'posts'): ?>
        <!-- ckEditor -->
        <script src="ckeditor/ckeditor.js"></script>
        <script src="ckeditor/samples/js/sample.js"></script>
        <link rel="stylesheet" href="toolbarconfigurator/lib/codemirror/neo.css">
    <?php endif; ?>
</head>

<body id="loginFrame">
<div class="container">
    <div class="card card-container">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->

        <!-- K logo appears on users, category and post edit but NOT in projects -->
        <?php if ($edit != 'projects'): ?>
            <img id="profile-img" class="profile-img-card" src="css/img/K_LOGO.png" alt="logo1" height="25" />
        <?php endif; ?>

        <!-- loading form to edit USERS -->
        <?php if ($edit == 'users'): ?>
            <p id="profile-name" class="profile-name-card">Edit <?= $edit; ?></p><br>
            <form action="managerCUD.php" method="post" class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text"     name="userId"    id="userId"      class="form-control"  placeholder="userId"     value="<?= $userId; ?>">
                <select name="userType" style="margin-bottom: 10px;">
                    <?php if ($userType == 'guest'): ?>
                        <option value="guest" selected>guest</option>
                        <option value="admin">admin</option>
                    <?php else: ?>
                        <option value="guest">guest</option>
                        <option value="admin" selected>admin</option>
                    <?php endif; ?>
                </select>
                <input type="text"     name="username"  id="username"    class="form-control"  placeholder="username"   value="<?= $userName ?>">
                <input type="text"     name="firstname" id="firstname"   class="form-control"  placeholder="firstname"  value="<?= $firstName ?>">
                <input type="text"     name="lastname"  id="lastname"    class="form-control"  placeholder="lastname"   value="<?= $lastName ?>">
                <input type="text"     name="phone"     id="phone"       class="form-control"  placeholder="phone"      value="<?= $phone ?>"
                       pattern='[\+]\d{2}[\-]\d{3}[\-]\d{3}[\-]\d{4}'    title="Phone Number (Format: +99-999-999-9999)">
                <input type="email"    name="email"     id="inputEmail"  class="form-control"  placeholder="inputEmail" value="<?= $email ?>">

                <!-- buttons -->
                <input type="hidden" name="userId" value="<?= $userId; ?>" />
                <button name="updateUser" type="submit" class="btn btn-primary">Update</button>
                <button name="deleteUser" type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you wish to delete this user?')">Delete</button>
                <button name="cancel" type="submit" class="btn btn-default">Cancel</button>
            </form><!-- /user form -->
        <?php endif; ?>


        <!-- loading form to edit PROJECTS -->
        <?php if ($edit == 'projects'): ?>

            <div id="projectImgContainer">
                <!-- uploaded image (for when user reload the page after uploading it -->
                <img id="projectImg" class="profile-img-card" src="<?= $pImgPath; ?>" alt="no image" height="25" />
                <!-- upload IMG form -->
                <form id="projectImgUp" method='post' enctype='multipart/form-data' action="fileUD.php">
                    <label for='image'>Add IMAGE:</label><br>
                    <p>Current File Path: <?= $pImgPath; ?></p><br>
                    <input type='file' name='image' id='image'>
                    <input type="hidden" name="projectId" value="<?= $projectId; ?>" />
                    <input type="hidden" name="imgPath" value="<?= $pImgPath; ?>" />
                    <input type='submit' name='changeImg' value='Upload Image'>
                </form>
            </div>

            <p id="profile-name" class="profile-name-card">Edit <?= $edit; ?></p><br>
            <form action="managerCUD.php" method="post" class="form-horizontal">
                <fieldset>
                    <input id="projectId"   name="projectId"   type="text" class="form-control" placeholder="Project Id" value="<?= $projectId; ?>">
                    <input id="projectTitle"   name="title"   type="text" class="form-control" placeholder="Project Title" value="<?= $pTitle; ?>">
                    <input id="projectSummary" name="summary" type="text" class="form-control" placeholder="Summary" value="<?= $pSummary; ?>">
                    <select id="projectCategory" name="category" style="margin-bottom: 5px;" required>
                        <!-- looping through the categories -->
                        <?php foreach ($categories as $category): ?>
                            <?php if ($category['category'] == $pCategory): ?>
                                <option value="<?= $category['category'] ?>" selected> <?= $category['category'] ?> </option>
                            <?php else: ?>
                                <option value="<?= $category['category'] ?>"> <?= $category['category'] ?> </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <textarea id="WYSIWYG" class="ckeditor" name="content"><?= $pContent ?></textarea>

                    <!-- buttons -->
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="hidden" name="projectId" value="<?= $projectId; ?>" />
                            <input type="hidden" name="imgPath" value="<?= $pImgPath; ?>" />
                            <button name="updateProject" type="submit" class="btn btn-primary">Update</button>
                            <button name="deleteProject" type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you wish to delete this project?')">Delete</button>
                            <button name="cancel" type="submit" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        <?php endif; ?>


        <!-- loading form to edit POSTS -->
        <?php if ($edit == 'posts'): ?>
            <p id="profile-name" class="profile-name-card">Edit <?= $edit; ?></p><br>
            <form action="insert.php" method="post" class="form-horizontal">
                <fieldset>
                    <input id="postTitle" name="title" type="text" class="form-control" value="<?= $postTitle ?>">
                    <textarea id="WYSIWYG" class="ckeditor" name="content"><?= $postContent ?></textarea>

                    <!-- reCaptcha -->
                    <div class="g-recaptcha" data-sitekey="6LfK6QwUAAAAAMSGyYIQlKxWnGjFdfmbmdElT4qT"></div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="hidden" name="postId" value="<?= $postId; ?>" />
                            <button name="update" type="submit" class="btn btn-primary">Update</button>
                            <button name="delete" type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you wish to delete this post?')">Delete</button>
                            <button name="cancel" type="submit" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        <?php endif; ?>


        <!-- loading form to edit CATEGORIES -->
        <?php if ($edit == 'categories'): ?>
            <p id="profile-name" class="profile-name-card">Edit <?= $edit; ?></p><br>
            <form action="managerCUD.php" method="post" class="form-signin">
                <input type="text"     name="categoryId"    id="categoryId"      class="form-control"  placeholder="Category Id" value="<?= $categoryId; ?>">
                <input type="text"     name="categoryName"  id="categoryName"    class="form-control"  placeholder="Category Name"   value="<?= $categoryName; ?>">

                <!-- buttons -->
                <input type="hidden" name="categoryId" value="<?= $categoryId; ?>" />
                <button name="updateCategory" type="submit" class="btn btn-primary">Update</button>
                <button name="deleteCategory" type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you wish to delete this user?')">Delete</button>
                <button name="cancel" type="submit" class="btn btn-default">Cancel</button>
            </form><!-- /user form -->
        <?php endif; ?>


    </div><!-- /card-container -->
</div><!-- /container -->

<?php if ($edit == 'projects' || $edit == 'posts'): ?>
    <!-- ckeditor -->
    <script>
        initSample();
    </script>
<?php endif; ?>
</body>
</html>

