<?php

/* db connection and session start
-----------------------------------------------*/
session_start();
include ('authenticate.php');
include ('connect.php');
//require __DIR__ . '/eventviva/Image'
//include ('eventviva/ImageResize.php');
//use /eventviva/ImageResize;


/* navigation variables
-----------------------------------------------*/
//just FYI
//$_SESSION['lastPage1']; ITS usually the page that calls the editor page
//$_SESSION['lastPage2']; ITS usually the editor page


/* variables
-----------------------------------------------*/
//setting upload folder path (where the image will be sent)
$upload_folder_name = 'css/img/projects';
$projectId = filter_input(INPUT_POST, 'projectId', FILTER_SANITIZE_NUMBER_INT);
//for image resize
//$image = new ImageResize();

/* script
-----------------------------------------------*/
if (isset($_POST['uploadImg']) || isset($_POST['changeImg'])) {
    /*-- DELETE IMAGE --*/
    //for NEWprojects
    //check if user tryied to upload an image, if yes, delete it
    if (file_exists($_SESSION['currentProjImg'])) {
        //set bool var holding the result of the file deletion (true or false)
        $fileDeleted = unlink($_SESSION['currentProjImg']);
    }


    /*-- UPLOAD IMAGE --*/
    // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'css/img/projects') {
        $current_folder = dirname(__FILE__);

        // Build an array of paths segment names to be joins using OS specific slashes.
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

        // The DIRECTORY_SEPARATOR constant is OS specific.
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

        return $file_extension_is_valid && $mime_type_is_valid;
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

    if ($image_upload_detected) {
        $image_filename        = $_FILES['image']['name'];
        $temporary_image_path  = $_FILES['image']['tmp_name'];
        $new_image_path        = file_upload_path($image_filename);
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            $success = move_uploaded_file($temporary_image_path, $new_image_path);


            /* post-script variables
            -----------------------------------------------*/
            //set session variables for storing image path
            //note: clear this variable after INSERTing in DB.
            $newImgPath = $_SESSION['currentProjImg'] = $upload_folder_name . '/' . $image_filename;

        }

    if (isset($_POST['changeImg'])) {
        $query = "UPDATE projects 
                      SET imgPath = :imgPath
                      WHERE projectId = :projectId";
        $statement = $db->prepare($query);
        $statement->bindValue(':imgPath', $newImgPath);
        $statement->bindValue(':projectId', $projectId, PDO::PARAM_INT);

        // Execute the UPDATE.
        $statement->execute();
    }

        //send back to the page and load the image
        header('Location: ' . $baseHostAddress . $_SESSION['lastPage2']);

    }
}

