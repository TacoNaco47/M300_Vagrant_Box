<?php

//$email_from = $_POST["Email"];
//$header="From: $email_from";

$url_ok = "https://nbs-bank.com/"; //Zielseite, wenn E-Mail erfolgreich versendet wurde
$url_fehler = "https://nbs-bank.com/error_docs/internal_server_error.html"; //Zielseite, wenn E-Mail nicht gesendet werden konnte
 

//E-Mail-Adresse in Variable füllen
$address = $_POST["Email"];

// Die Nachricht
$nachricht = "subscribe address=$address";


$header .= "\nContent-type: text/plain; charset=utf-8";
   
// Verschicken
$mail_senden = mail('newsletter-join@nbs-bank.com', 'Newsletter-Anmeldung', $nachricht);


//Weiterleitung, hier konnte jetzt per echo auch Ausgaben stehen
if($mail_senden){
  header("Location: ".$url_ok); //Mail wurde gesendet
  exit();
} else{
  header("Location: ".$url_fehler); //Fehler beim Senden
  exit();
}

?>
