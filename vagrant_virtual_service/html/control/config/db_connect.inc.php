<?php


//Datenbank-Verbindung
$db_host = '10.4.184.131';
$db_name = 'db_nbs_bank';
$db_user = 'db_nbs_bank_root';
$db_password = 'verySecure';

$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password); //Verbindung mit PDO
