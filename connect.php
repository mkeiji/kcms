<?php
    /*
     * Description: the connect.php is responsible for establishing the connection
     * from the script to the database. several other scripts are going to use this
     * script to connect to the database.
     * */
    define('DB_DSN','mysql:host=localhost;dbname=keijipcr_ksite;charset=utf8');
    define('DB_USER','keijipcr_keiji');
    define('DB_PASS','keijikeiji');

    //exception handling
    // Create a PDO object called $db.
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>