<?php
session_start();

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
error_reporting(0);
include ("./includes/lstuser.php");
include ("../actions/leitactions.php"); 

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


$einheiten = array("Feuerwache1","Feuerwache2","Rettungswache Nord","Rettungswache Süd","FAS","Kreisbrandmeister","Stadtbrandmeister","Leiter RD","ORGL-Chef","ORGL-Gruppe","TEL-Leiter","TEL-Gruppe","Leitstellenpersonal","Moderatoren","Admins");
$dateinamen = array("fw1","fw2","rd","rd2","fas","kbm","sbm","lrd","lorgl","orgl","tell","tel","lst","mod112","adm112");  
$einheiten2 = array("Hilfstadt 41-82","Hilfstadt 41-83","Feuerstadt 61-83","Brandstadt 71-82","Brandstadt 71-83","Brandstadt 72-83","Löschbach 81-83","Löschbach 82-83","Löschstadt 91-82","Löschstadt 92-82","Löschstadt 91-83","Löschstadt 92-83","Löschzug Löschstadt","Löschzug Hilfstadt","Löschzug Brandstadt","Christoph 1");
$dateinamen2 = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16");  
$_CONFIG[db][main][server] = "localhost"; 
$_CONFIG[db][main][user]   = "sql_bh";
$_CONFIG[db][main][pass]   = "96518583";
$_CONFIG[db][main][name]   = "bh_web"; 

if (!@mysql_connect($_CONFIG[db][main][server], $_CONFIG[db][main][user], $_CONFIG[db][main][pass])) {
  die("Fehler: Datenbankverbindung fehlgeschlagen.");
}
if (!@mysql_select_db($_CONFIG[db][main][name])) {
  die("Fehler: Datenbank konnte nicht ausgewählt werden: ".mysql_error());
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
 <th>Einsatz aktiv</th>
</tr>
<?php

$result = mysql_query("SELECT * FROM bh_lst WHERE fremd != '1' ORDER BY datum DESC LIMIT 700 ");
while ($alarm = mysql_fetch_assoc($result)) {
	echo "
    <tr>
      <td>".date("d.m.y - H:i", $alarm['datum'])."</td>
      <td>".$einheiten[$alarm['feuerwehr']]."</td>
      <td align=\"center\">".$alarm['art']."</td>
      <td>".$alarm['meldung']."</td>
	 <td>".$alarm['user']."</td>
	<td align=\"center\">".$alarm['einsatznummer']."</td>";
	

if ($alarm['status']== "1" )
{   
echo "<td align=\"center\" bgcolor=$col1><a href=\"?aktion2=ec&nummer=".$alarm['id']."&stneu=0\">Einsatz aktiv</a></td>";}
else
{
echo "<td align=\"center\" bgcolor=$col1><a href=\"?aktion2=eo&nummer=".$alarm['id']."&stneu=1\">Einsatz erledigt</a></td>";}




echo "    </tr>";}


?>
</table>

