<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
include("./includes/config.oe.inc.php");
$aktion = $_GET['aktion'];
$st5auto = $_GET['auto'];
$st5status = $_GET['oldst'];
$aktion1 = $_GET['aktion1'];
$aktion2 = $_GET['aktion2'];
$aktion5 = $GET['aktioneinsatz'];
$idn1 = 6734;
$idn1 = $GET['nummer']; 

$statusneu = $GET['stneu'];



$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");



//------------------------------------------------------------Status 5 resetten
if ($aktion == "status_5_storno")
{
mysql_query('UPDATE `'.$mysql_prefix.'fahrzeuge` SET `status_fhr` = "'.$st5status.'", `status_fhr_save` = " " WHERE (`frn` = "'.$st5auto.'");');

}

if ($aktion1 == "einsatzliste")
{
$_SESSION['lst-seite'] = "einsatzliste";
}
elseif ($aktion1 == "fmsliste")
{
$_SESSION['lst-seite'] = "fmsliste";
}
elseif ($aktion1 == "fmslog")
{
$_SESSION['lst-seite'] = "fmslog";
}

elseif ($aktion1 == "fmsliste2")
{
$_SESSION['lst-seite'] = "fmsliste2";
}
elseif ($aktion1 == "einsatzliste2")
{
$_SESSION['lst-seite'] = "einsatzliste2";
}

if ($aktion2 == "ec")
{
mysql_query('UPDATE `'.$mysql_prefix.'lst` SET `status` = "0" WHERE (`id` = "'.$idn1.'");');
}
elseif ($aktion2 == "eo")
{
mysql_query('UPDATE `'.$mysql_prefix.'lst` SET `status` = "1" WHERE (`id` = "'.$idn1.'");');
   

}


?>
