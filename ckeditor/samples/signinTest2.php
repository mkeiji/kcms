<?php
    $recaptchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
        var_dump($_POST);
        $secret = '6LfK6QwUAAAAAGjsBHPLC3DpIkiJ--NdxcQbUSDc';
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $recaptchaResponse;
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");

        $json = json_decode($response, true);

        echo "<pre>\
        ";
        print_r($json);
        echo "</pre>\
        ";

        if ($json['success'] == 1) {
            echo nl2br('YES');
        }
        else {
            echo nl2br('ur a robot');
        }
    }
    else {
        echo nl2br('click the captcha');
    }