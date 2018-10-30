<?php
require_once("config/db_connect.inc.php");
require_once("config/functions.inc.php");

include("../view/header.inc.php");

?>

<section style="margin: 0 10em;"> 
	<br>
	<h1>Newsletter abonnieren</h1>
	<form method="post" action="mail_newsletter.php">
		
		<label for="Email"><b>E-Mail:</b></label>
		<input type="text" id="Email" name="Email">
		 
		<br>
		<input type="submit" name="submit">
	</form>
</section>


<?php 
include("../view/footer.inc.php")
?>