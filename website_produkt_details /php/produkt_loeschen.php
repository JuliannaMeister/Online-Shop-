<?php
if(isset($_POST["produkt_loeschen_ja"]))
{
	include("alte_produkt_daten_laden.php");
	
	unlink("uploads/$bilddatei");
	
	mysqli_query($link, "delete from lagerbestand where produkt_fk = $produkt_pk");
	
	mysqli_query($link, "delete from produkte where produkt_pk = $produkt_pk");
	
	
	header("Location: ?seite=verwaltung");
	exit;	
}
else if(isset($_POST["produkt_loeschen_nein"]))
{
	
	header("Location: ?seite=verwaltung");
	exit;	
}
else
{
	echo "<h2>Produkt Löschen</h2><br /><hr /><br />";
	
	include("alte_produkt_daten_laden.php");
	include("produkt_loeschbestaetigung.php");
}
