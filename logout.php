<?php
include ('env.php');

session_destroy();
header('Location: ' . $baseHostAddress . 'index.html');