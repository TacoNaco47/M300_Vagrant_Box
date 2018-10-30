<?php
require_once("config/db_connect.inc.php");
require_once("config/functions.inc.php");

include("../view/header.inc.php");

?>


<section style="margin: 0 10em;"> 
	<br>
	<h1>Kontaktformular</h1>
	<form method="post" action="contact_mail.php">
		<label for="Name"><b>Name:</b></label>
		<input type="text" id="Name" name="Name">
		 
		<label for="Email"><b>E-Mail:</b></label>
		<input type="text" id="Email" name="Email">
		 
		<label for="Betreff"><b>Betreff:</b></label>
		<input type="text" id="Betreff" name="Betreff">
		 
		<label for="Nachricht"><b>Nachricht:</b></label>
		<textarea id="Nachricht" name="Nachricht" rows="10" cols="50"></textarea>
		<br>
		<input type="submit" name="submit">
	</form>
</section>

<?php 
include("../view/footer.inc.php")
?>