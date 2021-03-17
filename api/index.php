<?php

$client_id = 'XX'; // Your client id
$client_secret = 'XX'; // Your secret
$redirect_uri = ''; // Your redirect uri
$yaencode =base64_encode( $client_id.":".$client_secret);

function SendPost($url, $custom_headers){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function buscarArtista($url, $custom_headers){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// buscar access token
$custom_headers = array("Authorization: Basic $yaencode", 'Content-Type: application/x-www-form-urlencoded' );
$url = "https://accounts.spotify.com/api/token";
$response=SendPost($url, $custom_headers);
$toktok = json_decode($response, true);
$atoken = $toktok["access_token"];


//la busqueda
$busqueda=urlencode($_GET['q']);

$custom_headers = array("Authorization: Bearer $atoken", "Accept: application/json" );
$url = "https://api.spotify.com/v1/search?q=$busqueda&type=artist";
$response=buscarArtista($url, $custom_headers);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
echo ($response);

?>
