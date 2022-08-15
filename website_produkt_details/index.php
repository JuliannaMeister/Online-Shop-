<?php
session_start();

# Datenbankverbindung
#########################################################################
$link = mysqli_connect("localhost",	"root", 	"", 		"onlineshop");
mysqli_query($link, "SET names utf8"); # Verbindung auf utf-8 umstellen
#########################################################################

if(isset($_GET["seite"]) && $_GET["seite"] == "logout")
{
	session_destroy();
	unset($_SESSION);
	setcookie("login_merken", "", time() -1); # cookie entfernen beim Client
	unset($_COOKIE["login_merken"]); # cookie aus dem Server RAM löschen
}





if(isset($_POST["benutzer"]) && isset($_POST["kennwort"]))
{
	if($_POST["benutzer"] == "max" && $_POST["kennwort"] == "mustermann")
	{
		$_SESSION["eingeloggt"] = true;
		$_SESSION["benutzer"] = "Max Mustermann";
		$_SESSION["mitteilung"] = "<div style='color:lightgreen'>Erfolgreich eingeloggt</div>";
		if(isset($_POST["merken"]))
		{
			setcookie("login_merken", "Max Mustermann", time() + 60*60*24*365);
		}
		
		header("Location: ?seite=verwaltung"); # Weiterleiten zur Verwaltung
		exit; # PHP - Programm Ende
	}
	else
	{
		#echo "falsch";
		$_SESSION["mitteilung"] = "<div style='color:red'>Falsche Eingabe</div>";
	}	
}

# wenn der cookie da ist
if(isset($_COOKIE["login_merken"]))
{
	# automatisch einloggen
	$_SESSION["eingeloggt"] = true;
	$_SESSION["benutzer"] = "Max Mustermann";	
}
?>
<html>
<head>
	<title>Onlineshop</title>
	<meta charset="utf-8" />	
	<link rel="stylesheet" href="css/style.css" />	
</head>
<body>

<header>
	<a href="?seite=start">Startseite</a>
	<a href="?seite=produkte">Produkte</a>
	<a href="?seite=warenkorb">Warenkorb</a>
	
	<?php
	if(isset($_SESSION["eingeloggt"]))
	{
		echo '<a href="?seite=verwaltung">Verwaltung</a>';
		echo '<a href="?seite=logout">Logout</a>';
		echo "Hallo ".$_SESSION["benutzer"];		
	}
	else
	{
		echo '<a href="?seite=login">Login</a>';
	}	
	?>
	
	
</header>

<main>
<?php
if(isset($_SESSION["mitteilung"]))
{
	echo $_SESSION["mitteilung"]; 
	unset($_SESSION["mitteilung"]);
}


if(!isset($_GET["seite"]))
{
	$_GET["seite"] = "start"; # Startseite einstellen
}

#print_r($_GET);

switch($_GET["seite"])
{
	case "start":
		include("php/startseite.php"); 
	break;
	case "produkte":
		include("php/produkte.php");	
	break;
	case "warenkorb":
		include("html/warenkorb.html");
	break;
	case "login":
		include("php/login.php"); 	
	break;
	case "logout":
		include("php/logout.php"); 	
	break;	
	case "verwaltung":
		if(isset($_SESSION["eingeloggt"]))
		{
			include("php/verwaltung.php"); 
		}
		else
		{
			header("Location: ?seite=login"); 
			exit; 
		}	
	break;	
	default:
		include("html/404.html"); 
}

?>
</main>

<footer>
Copyright 2021
</footer>

</body>
</html>
<?php


mysqli_close($link);

?>
