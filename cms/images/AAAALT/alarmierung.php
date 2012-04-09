<?php
session_start();

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
error_reporting(0);
include ("./includes/lstuser.php");



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
if (isset($_POST['submit2'])) {

$art2 = $_POST['einsatzart2'].$_POST['stufe2'].$_POST['stufenerweiterung2'];
  mysql_query("INSERT INTO bh_lst(fremd, datum,einsatznummer, feuerwehr, art, meldung, user) VALUES ('".$fremd."' , ".time().", '".$_POST['einsatznummer2']."', '".$_POST['einheiten2']."', '".$art2."', '".$_POST['alarmtext2']."', '".$test111.$test112."')");
  
  $result = mysql_query("SELECT * FROM bh_lst WHERE feuerwehr = '".$_POST['einheiten2']."' ORDER BY datum DESC LIMIT 1");
  while ($alarm2 = mysql_fetch_assoc($result)) {
  	$meldung2 = $einheiten2[$alarm2['feuerwehr']]." - ".date("d.m. H:i", $alarm2['datum']).
      " - ".$alarm2['art']." - ".$alarm2['meldung']." -Einsatznummer: ".$alarm2['einsatznummer2'];
    $inhalt .= "    <item><title>".$meldung2."</title><guid isPermaLink=\"false\">http://feeds.online-einsaetze.de/alarm_bh_".$alarm['id']."</guid></item>\n";
$uebergabestring= $meldung2;
include ("./includes/telnet.php");
  }
}
if (isset($_POST['submit3'])) {
$meldung3 = $_POST['fahrzeugfremd']."  Status: ".$_POST['statusfremd'];
$uebergabestring= $meldung3;
include ("./includes/telnet2.php");

}
if (isset($_POST['submit4'])) {
$meldung4 = "Hier ist ".strtoupper($test111.($_SERVER['PHP_AUTH_USER']))." mit Durchsage:".$_POST['freitext1'];
$uebergabestring= $meldung4;
include ("./includes/telnet.php");
}
 

?>
<title>Leitstelle Brandheim NEU</title>
<link rel="stylesheet" type="text/css" href="http://leitstelle.online-einsaetze.de/css/default.css">

<center>
<a href="http://www.online-einsaetze.de" target="_blank"><img src="http://www.online-einsaetze.de/img/oe_top_2.png" border="0" alt="" /></a><p>
<hellgelbfett>Leitstelle Brandheim</hellgelbfett><p>

<?php
echo "<gelbfett>Hallo Willkommen  : <b>".strtoupper($_SERVER['PHP_AUTH_USER'])."       </b>hier die Uhrzeit  :  <b>".$uhrzeit,"</b> Uhr - und das Datum: <b>".$datum."</b></gelbfett>  "; 
print '<font face="Arial" size="3">';
//print "<A HREF=\"./news.php\" OnClick=\"javascript: fenster1('./news.php','VFFMS',900,300)\">NEWS</a>\n"; 
//print '<font face="Arial" size="3"><A href="#" onMouseOut="fenster.close()"; onMouseOver="fenster(); return true;">News</A>&nbsp&nbsp';
//print '<font face="Arial" size="3"><A href="#" onMouseOut="fenster1.close()"; onMouseOver="fenster1(); return true; ">Karte</A>&nbsp&nbsp';
//print '<font face="Arial" size="3"><A href="#" onMouseOut="fenster2.close()"; onMouseOver="fenster2(); return true; ">LST Status</A>';
?>
<form method="post">
  <input type="hidden" name="username"  value= "<?php echo $test112; ?>" size="30"><input type="submit" name="submit"  class="knopf" value="ALARMIEREN ! !">   
<gelbfett>Einheit:</gelbfett> <select name="einheiten" class="felder">
<?php foreach ($einheiten as $i => $fw) {?>
<option value="<?php echo $i ?>"><?php echo $fw ?></option>
<?php } ?>
</select>
  <gelbfett> Einsatzart :</gelbfett> <select name="einsatzart" class="felder">
<option></option>
<option>FEU</option>
<option>TH</option>
<option>RD</option>
<option>MANV</option>
<option>BMA</option>
<option>Durchsage</option>
<option>Probealarm</option>
  </select>
 <gelbfett>Alarmstufe:</gelbfett>
<select name="stufe" class="felder">
<option></option>
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
</select>
 <gelbfett>Stufenzusatz:</gelbfett>
 
<select name="stufenerweiterung" class="felder">
<option></option>
<option>X</option>
<option>Y</option>
</select>
 <gelbfett> Alarmtext:</gelbfett>
<input type="text" name="alarmtext"size="10" class="felder">
 <gelbfett> Einsatznummer:</gelbfett>
 <input type="text" name="einsatznummer" size="10" class="felder">
</form>

<form method="post">
  <input type="hidden" name="username2"  value= "<?php echo $test112; ?>" size="30"><input type="submit" name="submit2"  class="knopf" value="Fremdalarm ! !">   
<gelbfett>Einheit:</gelbfett> <select name="einheiten2" class="felder">
<?php foreach ($einheiten2 as $i => $fw) {?>
<option value="<?php echo $i ?>"><?php echo $fw ?></option>
<?php } ?>
</select>
  <gelbfett> Einsatzart :</gelbfett> <select name="einsatzart2" class="felder">
<option></option>
<option>FEU</option>
<option>TH</option>
<option>RD</option>
<option>MANV</option>
<option>BMA</option>
<option>Durchsage</option>
<option>Probealarm</option>
  </select>
 <gelbfett>Alarmstufe:</gelbfett>
<select name="stufe2" class="felder">
<option></option>
<option>0</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
</select>
 <gelbfett>Stufenzusatz:</gelbfett>
 
<select name="stufenerweiterung2" class="felder">
<option></option>
<option>X</option>
<option>Y</option>
</select>
 <gelbfett> Alarmtext:</gelbfett>
<input type="text" titel="Text in das Teamspeak senden" name="alarmtext2"size="10" class="felder">
 <gelbfett> Einsatznummer:</gelbfett>
 <input type="text" name="einsatznummer2" size="10" class="felder">
</form>

<form method="post">
<input type="submit" name="submit3"  class="knopf" value="Fremder Status">  

<gelbfett>Fahrzeug:</gelbfett> <select name="fahrzeugfremd" class="felder">
<?php foreach ($einheiten2 as $i => $fw2) {?>
<option value="<?php echo $fw2 ?>"><?php echo $fw2 ?></option>
<?php } ?>
</select>

 <gelbfett>Status</gelbfett>
<select name="statusfremd" class="felder">
<option>Frei auf Funk</option>
<option>Frei auf Wache</option>
<option>Anfahrt E-Stelle</option>
<option>Ankunft E-Stelle</option>
<option>Sprechwunsch</option>
<option>Ausser Dienst</option>
<option>Anfahrt zum Transportziel</option>
<option>Ankunft zum Transportziel</option>
<option>Notarzt aufgenommen</option>
</select>

 <input type="text" name="freitext1" size="10" class="felder">
<input type="submit" name="submit4"  class="knopf" value="Freitext TS">  

</form>





<SCRIPT LANGUAGE="JavaScript">
<!--
function fenster()
{
fenster0=open("./news.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=600,height=350,right=100,top=20");
}
function fenster1()
{
fenster0=open("./karte.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=850,height=950,right=10,top=10");
}
function fenster2()
{
fenster0=open("./leitstellen_status_2.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=400,height=650,right=50,top=20");
}
//-->
</SCRIPT>


