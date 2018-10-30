<?php 
session_start();
require_once("config/db_connect.inc.php");
require_once("config/functions.inc.php");

include("../view/header.inc.php");
?>
<br>
 <div class="container small-container-330">
	<h2 >Passwort vergessen</h2>


<?php 
$showForm = true;
 
if(isset($_GET['send']) ) {
	if(!isset($_POST['email']) || empty($_POST['email'])) {
		$error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";
	} else {
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $_POST['email']));
		$user = $statement->fetch();		
 
		if($user === false) {
			$error = "<b>Kein Benutzer gefunden</b>";
		} else {
			
			$passwortcode = random_string();
			$statement = $pdo->prepare("UPDATE users SET passwortcode = :passwortcode, passwortcode_time = NOW() WHERE id = :userid");
			$result = $statement->execute(array('passwortcode' => sha1($passwortcode), 'userid' => $user['id']));
			
			$empfaenger = $user['email'];
			$betreff = "Neues Passwort für Ihr E-Banking";
			$from = "From: noreply@nbs-bank.com";
			$url_passwortcode = getSiteURL().'passwortzuruecksetzen.php?userid='.$user['id'].'&code='.$passwortcode; //Setzt hier eure richtige Domain ein
			$text = 'Sehr geehrter Herr/Frau'.$user['vorname'].'
Für Ihr E-Banking-Benutzerkonto der New Bank of Switzerland (NBS) wurde nach einem neuen Passwort gefragt. Um ein neues Passwort zu vergeben, rufen Sie innerhalb der nächsten 24 Stunden die folgende Website auf:
'.$url_passwortcode.'
 
Sollte Ihnen Ihr Passwort wieder eingefallen sein oder haben Sie diese Änderung nicht angefordert, können Sie diese Nachricht ignorieren.
 
Freundliche Grüsse
dein PHP-Einfach.de-Team';
			
			//echo $text;
			 
			mail($empfaenger, $betreff, $text, $from);
 
			echo "Ein Link um Ihr Passwort zurückzusetzen wurde an Ihre E-Mail-Adresse gesendet.";	
			$showForm = false;
		}
	}
}
 
if($showForm):
?> 
	Geben Sie hier Ihre E-Mail-Adresse ein, um ein neues Passwort anzufordern.<br><br>
	 
	<?php
	if(isset($error) && !empty($error)) {
		echo $error;
	}
	
	?>
	<form action="?send=1" method="post">
		<label for="inputEmail">E-Mail</label>
		<input class="form-control" placeholder="E-Mail" name="email" type="email" value="<?php echo isset($_POST['email']) ? htmlentities($_POST['email']) : ''; ?>" required>
		<br>
		<input  class="btn btn-lg btn-primary btn-block" type="submit" value="Neues Passwort">
	</form> 
<?php
endif; //Endif von if($showForm)
?>

</div> <!-- /container -->
 

<?php 
include("../view/footer.inc.php")
?>