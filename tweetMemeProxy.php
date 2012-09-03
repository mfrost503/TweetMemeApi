<?php

$url = $_POST['url'];

$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
header('Content-type:application/json');
print $response;
