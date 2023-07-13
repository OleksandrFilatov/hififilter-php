<?php 
require ("dbcon.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mennyibe kerül egy euró? Beírjuk a beállítások táblába

$api_key = 'e0b3c911d6f69ad7f7fe';

$from = 'EUR';
$to = 'HUF';
$amount = 1;

// initialize CURL:
$ch = curl_init("https://free.currconv.com/api/v7/convert?q=$from"."_"."$to&compact=ultra&apiKey=$api_key");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// get the JSON data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$result = json_decode($json, true);

// access the conversion result

setSetting('eur-arfolyam', $result['EUR_HUF']+10);
echo "Az Euró ".$result['EUR_HUF']." + 10 Ft-os árfolyamát beírtuk a `beallitasok` táblába";
?>