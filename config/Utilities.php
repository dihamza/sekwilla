<?php

//postdata function
function postData($url, $data){
    //initialise curl session.php
    $ch = curl_init($url);

    //encode data
    $payload = json_encode($data);

    //set curl options
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
    );

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}