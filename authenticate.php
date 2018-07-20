<?php
/* validate session
-----------------------------------------------*/
//if there is no session then dont allow user to get in to the page
if (!isset($_SESSION['userType'])) {
    //send to login
    header('Location: ' . $baseHostAddress . 'login.html');
}