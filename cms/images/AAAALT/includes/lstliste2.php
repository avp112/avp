<php
<?php
session_start();

/*
Diese Datei ist Teil der Leitstelle von Online-Eins�tze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
error_reporting(0);
include ("./includes/lstuser.php");

$fremd= "0";

$test112 = $_SERVER['PHP_AUTH_USER'];
 if ($_SERVER['PHP_AUTH_USER']=="sebi") {
$test111= "Leiter-Lst-";
$_SESSION['fms-log'] ="1";
}

 if ($_SERVER['PHP_AUTH_USER']=="chrisviper") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
 elseif ($_SERVER['PHP_AUTH_USER']=="tim") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
 elseif ($_SERVER['PHP_AUTH_USER']=="JPK") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="1";
}

 elseif ($_SERVER['PHP_AUTH_USER']=="kilroy") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}

elseif ($_SERVER['PHP_AUTH_USER']=="bobele") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}

elseif ($_SERVER['PHP_AUTH_USER']=="firetrainer") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
 elseif ($_SERVER['PHP_AUTH_USER']=="basti") {
$test111= "Stellv. Leiter-Lst-";
$_SESSION['fms-log'] ="1";
}
elseif ($_SERVER['PHP_AUTH_USER']=="Frenzel") { 
$test111= "Disponent-";
$_SESSION['fms-log'] ="1";
}
else { 
$test111= "Praktikant-";
$_SESSION['fms-log'] ="0"; 
}


$einheiten = array("Hilfstadt 41-82","Hilfstadt 41-83","Feuerstadt 61-83","Brandstadt 71-82","Brandstadt 71-83","Brandstadt 72-83","L�schbach 81-83","L�schbach 82-83","L�schstadt 91-82","L�schstadt 92-82","L�schstadt 91-83","L�schstadt 92-83","L�schzug L�schstadt","L�schzug Hilfstadt","L�schzug Brandstadt","Christoph 1");


$_CONFIG[db][main][server] = "localhost"; 
$_CONFIG[db][main][user]   = "sql_bh";
$_CONFIG[db][main][pass]   = "96518583";
$_CONFIG[db][main][name]   = "bh_web"; 

if (!@mysql_connect($_CONFIG[db][main][server], $_CONFIG[db][main][user], $_CONFIG[db][main][pass])) {
  die("Fehler: Datenbankverbindung fehlgeschlagen.");
}
if (!@mysql_select_db($_CONFIG[db][main][name])) {
  die("Fehler: Datenbank konnte nicht ausgew�hlt werden: ".mysql_error());
}

$rss = '<?xml version="1.0"  encoding="ISO-8859-1"?>
<rss version="2.0">
  <channel>
    <title>Online Einsaetze</title>
    <link>http://www.online-einsaetze.de</link>
    <description>FME / SIRENE Brandhausen</description>
    <language>de-de</language>
    <copyright>Copyright 2008</copyright>
 
%inhalt%
  </channel>
</rss>';
if (isset($_POST['submit'])) {
  
  $art = $_POST['einsatzart'].$_POST['stufe'].$_POST['stufenerweiterung'];
  mysql_query("INSERT INTO bh_lst(datum,einsatznummer, feuerwehr, art, meldung, user) VALUES (".time().", '".$_POST['einsatznummer']."', '".$_POST['einheiten']."', '".$art."', '".$_POST['alarmtext']."', '".$test111.$test112."')");
  
  $result = mysql_query("SELECT * FROM bh_lst WHERE (feuerwehr = '".$_POST['einheiten']."' AND fremd != '".$fremd."')  ORDER BY datum DESC LIMIT 1");
  while ($alarm = mysql_fetch_assoc($result)) {
  	$meldung = $einheiten[$alarm['feuerwehr']]." - ".date("d.m. H:i", $alarm['datum']).
      " - ".$alarm['art']." - ".$alarm['meldung']." -Einsatznummer: ".$alarm['einsatznummer'];
    $inhalt .= "    <item><title>".$meldung."</title><guid isPermaLink=\"false\">http://feeds.online-einsaetze.de/alarm_bh_".$alarm['id']."</guid></item>\n";
$uebergabestring= $meldung;
include ("./includes/telnet.php");
  }
  $fp = fopen("alarm_bh_".$dateinamen[$_POST['einheiten']].".xml", "w"); 
 //$fp = fopen("/srv/www/vhosts/online-einsaetze.de/subdomains/feeds/httpdocs/alarm_bh_".$dateinamen[$_POST['einheiten']].".xml", "w");
  fwrite($fp, str_replace("%inhalt%", $inhalt, $rss));
  
  header("Location: ".$_SERVER['PHP_SELF']);
  exit;
}
?>
<title>Leitstelle Brandheim</title>
<link rel="stylesheet" type="text/css" href="http://leitstelle.online-einsaetze.de/css/default.css">

<center>



<table>
<tr>
  <th>Datum</th>
  <th>Einheitsname</th>
  <th>Art</th>
  <th>Meldung</th>
 <th>Disponent</th>
 <th>Einsatznummer</th> 
</tr>
<?php

$result = mysql_query("SELECT * FROM bh_lst WHERE fremd != '0' ORDER BY datum DESC LIMIT 700 ");
while ($alarm = mysql_fetch_assoc($result)) {
	echo "
    <tr>
      <td>".date("d.m.y - H:i", $alarm['datum'])."</td>
      <td>".$einheiten[$alarm['feuerwehr']]."</td>
      <td><center>".$alarm['art']."</center></td>
      <td>".$alarm['meldung']."</td>
	 <td>".$alarm['user']."</td>
	<td>".$alarm['einsatznummer']."</td>
    </tr>";
}
?>
</table>

