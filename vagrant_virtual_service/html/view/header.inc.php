<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>NBS | E-Banking</title>

   	<link rel="stylesheet" href="../view/assets/css/main.css" />
	<link rel="shortcut icon" type="image/x-icon" href="../view/images/graphics/favicon-16x16.png">
	
	
  </head>
  
  <body>
  
	<div id="pager-wrapper">
		
		<!-- Header -->
	  	<header id="header_inc">
			<h1><span id="logo_header_inc" class="fa fa-piggy-bank fa-fw"></span><strong>NBS</strong></h1>
		</header>
		<!-- End Header -->
   
	</div>
  
  
  
	<nav class="navbar navbar-inverse navbar-static-top">
      		
		<?php if(!is_checked_in()): ?>
              	
			<!-- do something -->
	   
	    <?php else: ?>
			
			<nav id="primary_nav_wrap">
				<ul>
					<li><a href="logout.php">Logout</a></li>  
					<li><a href="#settings">Einstellungen</a>
						<ul>
							<li><a href="settings.php">Benutzer</a></li>
							<li><a href="#2">Konto</a></li>
							<li><a href="#3">Passwort ändern</a></li>
						</ul>
					</li>
					<li><a href="#documents">Dokumente</a></li>
					<li><a href="#transaction">Überweisen</a></li>
					<li><a href="settings.php">Vermögen</a></li>
					<li><a class="current-menu-item" href="internal_area.php">Home</a></li>
				</ul>
			</nav>
		
        <?php endif; ?>
		
	</nav>
	
	
