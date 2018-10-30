<?php 
session_start();
session_destroy();
unset($_SESSION['userid']);

//Remove Cookies
setcookie("identifier","",time()-(3600*24*365)); 
setcookie("securitytoken","",time()-(3600*24*365)); 

require_once("config/db_connect.inc.php");
require_once("config/functions.inc.php");

include("../view/header.inc.php");
?>

<div class="container main-container">
Der Logout war erfolgreich. <a href="login.php">Zurück zum Login</a>.
</div>
<?php 
include("../view/footer.inc.php")
?>