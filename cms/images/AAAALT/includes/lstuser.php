<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856
error_reporting(0);
*/
$datum = date("d.m.Y");
$uhrzeit = date("H:i"); 
//echo $datum;
if (($_SERVER['PHP_AUTH_USER'] == "sebi" && $_SERVER['PHP_AUTH_PW'] === "ap13" )  ||
   ($_SERVER['PHP_AUTH_USER'] == "firetrainer" && $_SERVER['PHP_AUTH_PW'] === "lahr211703" )  ||  	
   ($_SERVER['PHP_AUTH_USER'] == "chrisviper" && $_SERVER['PHP_AUTH_PW'] === "papa2006" )  ||     
   ($_SERVER['PHP_AUTH_USER'] == "kilroy" && $_SERVER['PHP_AUTH_PW'] === "kilroy112" )  ||  
   ($_SERVER['PHP_AUTH_USER'] == "scuby" && $_SERVER['PHP_AUTH_PW'] === "scuby324563" )  || 
   ($_SERVER['PHP_AUTH_USER'] == "marzel" && $_SERVER['PHP_AUTH_PW'] === "marzel2326" )  ||  
   ($_SERVER['PHP_AUTH_USER'] == "cheese" && $_SERVER['PHP_AUTH_PW'] === "cheese298762" )  ||  
   ($_SERVER['PHP_AUTH_USER'] == "JPK" && $_SERVER['PHP_AUTH_PW'] === "eishockey66" )  || 
   ($_SERVER['PHP_AUTH_USER'] == "freital" && $_SERVER['PHP_AUTH_PW'] === "dlk07")  ||
   ($_SERVER['PHP_AUTH_USER'] == "eaglemove" && $_SERVER['PHP_AUTH_PW'] === "house")  ||
   ($_SERVER['PHP_AUTH_USER'] == "grafrs" && $_SERVER['PHP_AUTH_PW'] === "Brighton98")  ||
   ($_SERVER['PHP_AUTH_USER'] == "basti" && $_SERVER['PHP_AUTH_PW'] === "ap14"))   

{
//echo "Hallo Willkommen : <b>".strtoupper($_SERVER['PHP_AUTH_USER'])."</b><br>Hier die Uhrzeit:  <b>".$uhrzeit,"</b> Uhr - und das Datum: <b>".$datum."</b>"; 
//echo "<br>";
}


elseif (($_SERVER['PHP_AUTH_USER'] == "Frenzel" && $_SERVER['PHP_AUTH_PW'] === "daniel1234" ) || 
       ($_SERVER['PHP_AUTH_USER'] == "Simon" && $_SERVER['PHP_AUTH_PW'] === "simon112" ))
{
//echo "Herzlich willkommen : <b>".strtoupper($_SERVER['PHP_AUTH_USER'])."</b><br>Hier die Uhrzeit:  <b>".$uhrzeit,"</b> Uhr - und das Datum: <b>".$datum."</b>"; 
//echo "<br>";
}


else
{
  header("WWW-Authenticate: Basic realm=\"Online Einsaetze\"");  
  header("HTTP/1.0 401 Unauthorized");
  die("Zugriff verweigert.");  
}

$fremd ="1";

$test112 = $_SERVER['PHP_AUTH_USER'];
 if ($_SERVER['PHP_AUTH_USER']=="sebi") {
$test111= "Leiter-Lst-";
$_SESSION['fms-log'] ="1";
}

elseif ($_SERVER['PHP_AUTH_USER']=="chrisviper") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
elseif ($_SERVER['PHP_AUTH_USER']=="marzel") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
elseif ($_SERVER['PHP_AUTH_USER']=="grafrs") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
elseif ($_SERVER['PHP_AUTH_USER']=="freital") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
elseif ($_SERVER['PHP_AUTH_USER']=="scuby") {
$test111= "Disponent-";
$_SESSION['fms-log'] ="0";
}
 elseif ($_SERVER['PHP_AUTH_USER']=="cheese") {
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

elseif ($_SERVER['PHP_AUTH_USER']=="") {
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

?>