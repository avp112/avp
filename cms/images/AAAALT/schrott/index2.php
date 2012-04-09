<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
error_reporting(E_ALL);
include ("./includes/lstuser.php");

$test112 = $_SERVER['PHP_AUTH_USER'];
 if ($_SERVER['PHP_AUTH_USER']=="sebi") {
$test111= "Leiter-Lst-";
$fmslog="1";
}

 if ($_SERVER['PHP_AUTH_USER']=="chrisviper") {
$test111= "Disponent-";
$fmslog="0";
}
 if ($_SERVER['PHP_AUTH_USER']=="tim") {
$test111= "Disponent-";
$fmslog="0";
}

 if ($_SERVER['PHP_AUTH_USER']=="kilroy") {
$test111= "Disponent-";
$fmslog="0";
}

 if ($_SERVER['PHP_AUTH_USER']=="bobele") {
$test111= "Disponent-";
$fmslog="0";
}

 if ($_SERVER['PHP_AUTH_USER']=="basti") {
$test111= "Disponent-";
$fmslog="0";
}
 if ($_SERVER['PHP_AUTH_USER']=="Frenzel") { 
$test111= "Chefadmin-";
$fmslog="0";
}

$einheiten = array("Feuerwache1","Feuerwache2","Rettungswache Nord","Rettungswache SEG","Leitstelle","Leiter Rettungsdienst","Kreisbrandmeister","ORG-Leiter","Stadt Brandmeister","Admins","TEL","Mods","FAS","ORGL-CHEF","Rettungswache Sued");
$dateinamen = array("fw1","fw2","rd","seg","lst","lrd","kbm","orgl","sbm","adm112","tel","mod112","fas","lorgl","rd2");  
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
  
  $result = mysql_query("SELECT * FROM bh_lst WHERE feuerwehr = '".$_POST['einheiten']."' ORDER BY datum DESC LIMIT 1");
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
<title>Leitstelle Brandstetten NEU</title>
<link rel="stylesheet" type="text/css" href="http://leitstelle.online-einsaetze.de/css/default.css">

<center>
<a href="http://www.online-einsaetze.de" target="_blank"><img src="http://www.online-einsaetze.de/img/oe_top_1.png" border="0" alt="" /></a><br>
<font size="7" color="#FFFFFF">Leitstelle Brandheim NEU</font><br>
<?php
print '<div style="position:absolute; top:27.5mm; left:10mm; z-index:1" ><a class="buttonlst" href="?aktion=einsatzliste" title="Liste der Einsätze"; return false;"><span> Liste </span></a>';
print '<a class="buttonlst" href="?aktion=fmsliste" title="FMS-STATUS Liste"; return false;"><span>Status alle</span></a>';
print '<a class="buttonlst" href="?aktion=fmsliste2" title="FMS-STATUS Liste ohne 2"; return false;"><span>Status ohne "2"</span></a></div>';
?>
<?php
echo "Hallo Willkommen  : <b>".strtoupper($_SERVER['PHP_AUTH_USER'])."       </b>hier die Uhrzeit  :  <b>".$uhrzeit,"</b> Uhr - und das Datum: <b>".$datum."</b>   "; 
print '<font face="Arial" size="3"><A href="#" onMouseOut="fenster0.close()"; onMouseOver="fenster(); return true; ">News </A><br>';
?>
<br>
<form method="post">
  <input type="hidden" name="username" class="buttonlst" value= "<?php echo $test112; ?>" size="30"><input type="submit" name="submit"  value="ALARMIEREN ! !">   
Einheit: <select name="einheiten">
<?php foreach ($einheiten as $i => $fw) {?>
<option value="<?php echo $i ?>"><?php echo $fw ?></option>
<?php } ?>
</select>
   Einsatzart : <select name="einsatzart">
<option></option>
<option>FEU</option>
<option>TH</option>
<option>RD</option>
<option>MANV</option>
<option>BMA</option>
<option>Durchsage</option>
<option>Probealarm</option>
  </select>
 Alarmstufe:
<select name="stufe">
<option></option>
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
</select>
 Stufenzusatz:
 
<select name="stufenerweiterung">
<option></option>
<option>X</option>
<option>Y</option>
</select>
  Alarmtext:
<input type="text" name="alarmtext"size="10">
  Einsatznummer:
 <input type="text" name="einsatznummer" size="10">
</form><br><br>
<?php
$aktion = $_GET['aktion'];

if ($aktion == "einsatzliste"){



include ("./includes/lstliste.php");
//echo '>';
//echo 'Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.';
//echo '</iframe></p>';
}
elseif ($aktion == "fmsliste"){
$statussichtbar = "o";
include ("./includes/lst.php");
}


else{
$statussichtbar = "2";
include ("./includes/lst.php");}
?>
</center>
<SCRIPT LANGUAGE="JavaScript">
<!--
function fenster()
{
fenster0=open("./news.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=600,height=350,right=center,top=center");
}

//-->
</SCRIPT>





