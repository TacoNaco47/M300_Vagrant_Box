<?php
session_start();
require_once("config/db_connect.inc.php");
require_once("config/functions.inc.php");

//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
$user = check_user();

include("../view/header.inc.php");
?>

<div class="container main-container">
<br>
<h1>Herzlich Willkommen!</h1>

Guten Tag Herr/Frau <?php echo htmlentities($user['vorname']); ?>,<br>
Herzlich Willkommen im internen Bereich!<br><br>

<div class="panel panel-default">
 
<table class="table">
<tr>
	<th>#</th>
	<th>Vorname</th>
	<th>Nachname</th>
	<th>E-Mail</th>
</tr>
<?php 
$statement = $pdo->prepare("SELECT * FROM users ORDER BY id");
$result = $statement->execute();
$count = 1;
while($row = $statement->fetch()) {
	echo "<tr>";
	echo "<td>".$count++."</td>";
	echo "<td>".$row['vorname']."</td>";
	echo "<td>".$row['nachname']."</td>";
	echo '<td><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td>';
	echo "</tr>";
}
?>
</table>
</div>


</div>
<?php 
include("../view/footer.inc.php")
?>
