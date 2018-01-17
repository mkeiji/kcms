<?php
/* navigation variables
-----------------------------------------------*/
//just FYI
//$_SESSION['lastPage1']; ITS usually the page that calls the editor page
//$_SESSION['lastPage2']; ITS usually the editor page

/* db connection ans session start
-----------------------------------------------*/
session_start();
include ('authenticate.php');
include ('connect.php');
//include ('fileUD.php');


/* sanitized variables (from manageEdit.php)
-----------------------------------------------*/
/*-- for USERS --*/
$userId    = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$userType  = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$userName  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$firstName = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastName  = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$phone     = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
$email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


/* sanitized variables (from manageNew.php)
-----------------------------------------------*/
/*-- for CATEGORY --*/
$categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$categoryId   = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);


/*-- for PROJECTS --*/
$projectId       = filter_input(INPUT_POST, 'projectId', FILTER_SANITIZE_NUMBER_INT);
$projectCategory = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectTitle    = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectSummary  = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectContent  = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectImgPath  = filter_input(INPUT_POST, 'imgPath', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


/* Creates, Updates, Deletes
-----------------------------------------------*/
try {
    //checking if there is a server request for POST method
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //check if submit button is CANCEL
        if (isset($_POST['cancel'])) {
            //send to previous page
            header('Location: http://keiji.pcriot.com/site/' . $_SESSION['lastPage1']);
        }
        /*then check to see if the cancel button comes from NEWPROJECTS...
        the redirection needs to be direct to the page because the user can try to input
        diferent images files more than once, by doing that will set last pages 1 and 2
        o be the same*/
        if (isset($_POST['cancelNewProject'])) {
            //check if user tryied to upload an image, if yes, delete it
            //note: will only work for the last image uploaded
            if (file_exists($_SESSION['currentProjImg'])) {
                //set bool var holding the result of the file deletion (true or false)
                $fileDeleted = unlink($_SESSION['currentProjImg']);
            }

            //send send straight to manage projects
            header('Location: http://keiji.pcriot.com/site/manage.php?manage=projects');
        }

        /********************** CREATES ***********************/
        //for **NEW CATEGORY (project)**
        if (isset($_POST['newCategory'])) {

            //creating query to insert rows in the database table
            $query = "INSERT INTO categories (category)
                      VALUES                 (:category)";
            //using $db from connect.php and calling prepare function to load the query
            $statement = $db->prepare($query);
            //binding value :tweet with $tweet
            $statement->bindValue(':category', $categoryName);
            //Execute the INSERT.
            $statement->execute();
            //Determine the primary key of the inserted row.
            $insert_id = $db->lastInsertId();

            //send user to previous page
            header('Location: http://keiji.pcriot.com/site/' . $_SESSION['lastPage1']);
        }  //--end of create category

        //for **NEW PROJECT**
        if (isset($_POST['newProject'])) {

            //creating query to insert rows in the database table
            $query = "INSERT INTO projects (category , title , summary , content , imgPath )
                      VALUES               (:category, :title, :summary, :content, :imgPath)";
            //using $db from connect.php and calling prepare function to load the query
            $statement = $db->prepare($query);
            //binding value :tweet with $tweet
            $statement->bindValue(':category', $projectCategory);
            $statement->bindValue(':title', $projectTitle);
            $statement->bindValue(':summary', $projectSummary);
            $statement->bindValue(':content', $projectContent);
            $statement->bindValue(':imgPath', $projectImgPath);
            //Execute the INSERT.
            $statement->execute();
            //Determine the primary key of the inserted row.
            $insert_id = $db->lastInsertId();

            //debugging
            //echo $statement -> errorCode();
            //$error = $statement -> errorCode();
            //print_r($error);

            //IMPORTANT: unset current project path session variable (otherwise the file will be deleted)
            unset($_SESSION['currentProjImg']);

            //send send straight to manage projects
            header('Location: http://keiji.pcriot.com/site/manage.php?manage=projects');
        }  //--end of create category


        /********************** UPDATES ***********************/
        /*-- start check of which action needs to be done --*/
        //for **UPDATE PROJECTS**
        if (isset($_POST['updateProject'])) {
            // Build the parameterized SQL query and bind to the above sanitized values.
            $query = "UPDATE projects
                      SET category = :category,
                          title = :title,
                          summary = :summary,
                          content = :content,
                          imgPath = :imgPath
                      WHERE projectId = :projectId";
            $statement = $db->prepare($query);
            $statement->bindValue(':category', $projectCategory);
            $statement->bindValue(':title', $projectTitle);
            $statement->bindValue(':summary', $projectSummary);
            $statement->bindValue(':content', $projectContent);
            $statement->bindValue(':imgPath', $projectImgPath);
            $statement->bindValue(':projectId', $projectId, PDO::PARAM_INT);

            // Execute the UPDATE.
            $statement->execute();

            //debugging
            //echo $statement -> errorCode();
//            echo nl2br($projectId . "\n");
//            echo nl2br($projectCategory . "\n");
//            echo nl2br($projectTitle . "\n");
//            echo nl2br($projectSummary . "\n");
//            echo nl2br($projectContent . "\n");
//            echo nl2br($projectImgPath . "\n");

            //send send straight to manage projects
            header('Location: http://keiji.pcriot.com/site/manage.php?manage=projects');
        }  //--end if - update user


        //for **UPDATE USER**
        if (isset($_POST['updateUser'])) {
            // Build the parameterized SQL query and bind to the above sanitized values.
            $query = "UPDATE users 
                      SET userType = :userType,
                          userName = :userName,
                          firstName = :firstName,
                          lastName = :lastName,
                          phone = :phone,
                          email = :email
                      WHERE userId = :userId";
            $statement = $db->prepare($query);
            $statement->bindValue(':userType', $userType);
            $statement->bindValue(':userName', $userName);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':phone', $phone);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':userId', $userId, PDO::PARAM_INT);

            // Execute the UPDATE.
            $statement->execute();

            //using header function to redirect the page after the action
            header('Location: http://keiji.pcriot.com/site/' . $_SESSION['lastPage1']);
        }  //--end if - update user

        //for **UPDATE CATEGORY**
        if (isset($_POST['updateCategory'])) {
            // Build the parameterized SQL query and bind to the above sanitized values.
            $query = "UPDATE categories 
                      SET category = :category
                      WHERE categoryId = :categoryId";
            $statement = $db->prepare($query);
            $statement->bindValue(':category', $categoryName);
            $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);

            // Execute the UPDATE.
            $statement->execute();

            //using header function to redirect the page after the action
            header('Location: http://keiji.pcriot.com/site/' . $_SESSION['lastPage1']);
        }  //--end if - update user


        /********************** DELETES ***********************/
        //for **DELETE PROJECT**
        //check if post request is deleteProject
        if (isset($_POST['deleteProject'])) {
            $query = "DELETE FROM projects 
                      WHERE projectId = :projectId";
            $statement = $db->prepare($query);
            $statement->bindValue(':projectId', $projectId, PDO::PARAM_INT);
            $statement->execute();

            //delete the image from img folder
            if (file_exists($projectImgPath)) {
                //set bool var holding the result of the file deletion (true or false)
                $fileDeleted = unlink($projectImgPath);
            }

            //send send straight to manage projects
            header('Location: http://keiji.pcriot.com/site/manage.php?manage=projects');
        }  //--end if - delete project

        //for **DELETE USER**
        //check if post request is deleteUser
        if (isset($_POST['deleteUser'])) {
            $query = "DELETE FROM users 
                      WHERE userId = :userId";
            $statement = $db->prepare($query);
            $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
            $statement->execute();

            //using header function to redirect the page to the after the action
            header('Location: http://keiji.pcriot.com/site/' . $_SESSION['lastPage1']);
        }  //--end if - delete user

        //for **DELETE CATEGORY**
        //check if post request is deleteCategory
        if (isset($_POST['deleteCategory'])) {
            $query = "DELETE FROM categories 
                      WHERE categoryId = :categoryId";
            $statement = $db->prepare($query);
            $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $statement->execute();

            //using header function to redirect the page to the after the action
            header('Location: http://keiji.pcriot.com/site/' . $_SESSION['lastPage1']);
        }  //--end if - delete category

    } //--end of server request check
}
catch (Exception $e) {
    echo nl2br("something went wrong");
}









