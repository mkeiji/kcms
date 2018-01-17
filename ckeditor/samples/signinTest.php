<?php

/* reCaptcha
-----------------------------------------------*/
//send request to google api
$curl = curl_init();

//setup an array
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => [
        'secret' => '6LfK6QwUAAAAAGjsBHPLC3DpIkiJ--NdxcQbUSDc',
        'response' => $_POST['g-recaptcha-response'],
    ],
]);

//getting the response
$response = json_decode(curl_exec($curl));

if ($response -> success) {
	//good, do ur magic
}
else {

}

var_dump($response);

/*source: https://www.youtube.com/watch?v=FFbp-0VgUHc&index=3&list=PLfdtiltiRHWFtQmpKZOXruLgYp9vPOZcq*/