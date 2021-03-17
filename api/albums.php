<?php
//Client ID a913ac1aa00e43a7b9cf4fde8f3fc327
//Client Secret 1cf55af2249d4543b2b8ef173298afcb
$client_id = 'a913ac1aa00e43a7b9cf4fde8f3fc327'; // Your client id
$client_secret = '1cf55af2249d4543b2b8ef173298afcb'; // Your secret
$redirect_uri = 'https://redengo.com/bots/astorbot/callback.php'; // Your redirect uri
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
$idbanda=$_GET['id'];
//https://api.spotify.com/v1/artists/0TnOYISbd1XYRBk9myaseg/albums

$custom_headers = array("Authorization: Bearer $atoken", "Accept: application/json" );
$url = "https://api.spotify.com/v1/artists/$idbanda/albums";
$response=buscarArtista($url, $custom_headers);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
echo ($response);

?>