<?php


?>

<!DOCTYPE html>
<!--
Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or http://ckeditor.com/license
-->
<html>
<head>
  <meta charset="utf-8">
  <title>CKEditor Sample</title>
  <script src="../ckeditor.js"></script>
  <script src="js/sample.js"></script>
  <link rel="stylesheet" href="toolbarconfigurator/lib/codemirror/neo.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body id="main">

  <form action="signinTest2.php" method="POST">
    <textarea class="ckeditor" name="content"></textarea>

    <div class="g-recaptcha" data-sitekey="6LfK6QwUAAAAAMSGyYIQlKxWnGjFdfmbmdElT4qT"></div>
    <input type="submit" name="insert">
  </form>

</body>
</html>
