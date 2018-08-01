<?php
/* db connection and session start
-----------------------------------------------*/
session_start();
include ('connect.php');
include ('env.php');


/* variables
-----------------------------------------------*/
$_SESSION['username'] = $username = $_POST['username'];
$password = $_POST['password'];


/* accessing DB
-----------------------------------------------*/
//create a SELECT query on table users to check if it exist
$query = "SELECT * FROM users WHERE userName='$username'";
//prepare a PDOStatement object, $db is a PDO object that comes from connect.php
$statement = $db->prepare($query);
//run it
$statement->execute();
//save fetch in the $posts variable
$users = $statement->fetchAll();


/* session variables (post query)
-----------------------------------------------*/
$_SESSION['userId']         = $users[0]['userId'];
$_SESSION['userType']       = $users[0]['userType'];
$_SESSION['userName']       = $users[0]['userName'];
$_SESSION['userFirstName']  = $users[0]['firstName'];
$_SESSION['userLasttName']  = $users[0]['lastName'];
$_SESSION['phone']          = $users[0]['phone'];
$_SESSION['email']          = $users[0]['email'];
$userType = $_SESSION['usertype'] = $users[0]['userType'];


/* Script
-----------------------------------------------*/
//if login is UNsuccessfull
if (!(($username == $users[0]['userName']) && (password_verify($password, $users[0]['password'])))) {
    /*
     * IMPORTANT
     * send user to a copy of a login page (but with the **wrong pwd or usrname** error)
     *
     * also: check if the user exists. if not, display error msg (maybe send
     * the user to a page to register)*/
    //send user to error page
    header('Location: http://kcms.http80.info/loginError.html');
}
//if login is successful
else {
    //send user to homepage
    header('Location: http://kcms.http80.info/home.php');
}
