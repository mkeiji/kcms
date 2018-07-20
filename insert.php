<?php
/* navigation variables
-----------------------------------------------*/
//just FYI
//$_SESSION['lastPage1']; ITS usually the page that calls the editor page
//$_SESSION['lastPage2']; ITS usually the editor page

/* db connection ans session start
-----------------------------------------------*/
session_start();
include ('connect.php');


/* sanitized variables (from register.html)
-----------------------------------------------*/
$email      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$username   = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$firstname  = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastname   = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$phone      = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
$recaptchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// use password_hash('pwdVar', PASSWORD_DEFAULT) and
// http://php.net/manual/en/function.password-hash.php
// password_verify ( string $password , string $hash ) *** its a boolean
// http://php.net/manual/en/function.password-verify.php
$password   = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$hashedPwd  = password_hash($password, PASSWORD_DEFAULT);


/* sanitized variables (for comments inserts)
-----------------------------------------------*/
$projectId  = $_SESSION['projectId'];
$userId     = $_SESSION['userId'];
$userType   = $_SESSION['userType'];
//setting the location of the page that requested the CRUD
$pageRequest = $_SESSION['pageRequest'];
$title      = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$content    = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$postId     = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);

/* CAPTCHA & inserts
-----------------------------------------------*/
//first check if submit button is CANCEL
if (isset($_POST['cancel'])) {
    //send to previous page
    header('Location: ' . $baseHostAddress . $_SESSION['lastPage1']);
}

/*-- FOR REGISTER --*/
//check if submit button is to register new user
if (isset($_POST['register'])) {
    //inserting registration info
    //creating query to insert rows in the database table
    $query = "INSERT INTO users (userName ,  firstName,  lastName,  phone,  email,  password)
              values            (:username, :firstname, :lastname, :phone, :email, :password)";
    //$query = "INSERT INTO Users (userName) values (:username)";
    //using $db from connect.php and calling prepare function to load the query
    $statement = $db->prepare($query);
    //binding value :tweet with $tweet
    $statement->bindValue(':username', $username);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hashedPwd);
    //Execute the INSERT.
    $statement->execute();
    //Determine the primary key of the inserted row.
    $insert_id = $db->lastInsertId();

    //redirect to a page
    //if user is an admin, send to administrative page
    if ($_SESSION['userType'] == 'admin') {
        header('Location: ' . $baseHostAddress . 'manage.php?manage=users');
    }
    //else send to login page with a new session
    else {
        //set username session variable
        $_SESSION['username'] = $username;
        //send user to loginpage
        header('Location: ' . $baseHostAddress . 'login.html');
    }

}  //--end if register


/*-- FOR POSTS w/ CAPTCHA --*/
//checking if captcha variable (post) have been set and is not null
//OR if the user is an admin it wont ask for captcha
if ((isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) ||  $userType == 'admin') {
    /*--variables--*/
    //google secret key
    $secret = '6LfK6QwUAAAAAGjsBHPLC3DpIkiJ--NdxcQbUSDc';
    //user ip address
    $ip = $_SERVER['REMOTE_ADDR'];
    //post variable response from form
    $captcha = $recaptchaResponse;
    //google api verification
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");

    //using json to store all the response from google server
    $json = json_decode($response, true);

    //checking if verification from google were successful
    //OR if the user is an admin it wont ask for captcha
    if ($json['success'] == 1 || $userType == 'admin') {
        //if true, do the inserts
        /* inserts
        -----------------------------------------------*/

        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //check if submit button is to create new post
                if (isset($_POST['newPost'])) {
                    //checking if the title and content sections are not null
                    //echo error msg if empty
                    if (empty($title) || empty($content)) {
                        echo nl2br('title and content cannot be blank');
                        exit;
                    }

                    //creating query to insert rows in the database table
                    $query = "INSERT INTO posts (projectId , userId , title ,  content)
                              values            (:projectId, :userId, :title, :content)";
                    //$query = "INSERT INTO Users (userName) values (:username)";
                    //using $db from connect.php and calling prepare function to load the query
                    $statement = $db->prepare($query);
                    //binding value :tweet with $tweet
                    $statement->bindValue(':projectId', $projectId);
                    $statement->bindValue(':userId', $userId);
                    $statement->bindValue(':title', $title);
                    $statement->bindValue(':content', $content);
                    //Execute the INSERT.
                    $statement->execute();
                    //Determine the primary key of the inserted row.
                    $insert_id = $db->lastInsertId();

                    //send user to previous page
                    header('Location: ' . $baseHostAddress . $_SESSION['lastPage1']);
                    //header('Location: http://localhost/project/' . $pageRequest);
                }  //--end of newPost

                //checking if the button is update (post)
                if (isset($_POST['update'])) {
                    //checking if the title and content sections are not null
                    //echo error msg if empty
                    if (empty($title) || empty($content)) {
                        echo nl2br('title and content cannot be blank');
                        exit;
                    }

                    // Build the parameterized SQL query and bind to the above sanitized values.
                    $query = "UPDATE posts SET title = :title, content = :content WHERE postId = :postId";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':title', $title);
                    $statement->bindValue(':content', $content);
                    $statement->bindValue(':postId', $postId, PDO::PARAM_INT);

                    // Execute the INSERT.
                    $statement->execute();

                    //using header function to redirect the page to the previous page after the insertion
                    header('Location: ' . $baseHostAddress . $_SESSION['lastPage1']);
                    //header('Location: http://localhost/project/' . $pageRequest);
                }  //--end of update

                //checking if the button is delete (post)
                if (isset($_POST['delete'])) {
                    $query = "DELETE FROM posts WHERE postId = :postId";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':postId', $postId, PDO::PARAM_INT);
                    $statement->execute();

                    //using header function to redirect the page to the previous page after the insertion
                    header('Location: ' . $baseHostAddress . $_SESSION['lastPage1']);
                    //header('Location: http://localhost/project/' . $pageRequest);
                }  //--end of delete
            }  //--end if that checks if method is post

        }  //--end try
        catch (Exception $e) {
            echo nl2br("something went wrong");
        }
    }  //--end of success verification
    else {
        //display some error message
    }
}  //--end of captcha
else {
    echo nl2br('click the captcha checkbox');
}



