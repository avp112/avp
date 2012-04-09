<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
include("../includes/config.oe.inc.php");

$_SESSION['status_auto_kennung'] = $_GET['autolst'];
$aktion = $_GET['aktion'];
$statusauto = $_GET['statuslst'];

$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");

switch($aktion){

case 	'statuswechsellst':
      	switch($statusauto){
      	case 'A':
	$_SESSION['status_lst_auto'] ="A";  
	$_SESSION['status_lst_auto2'] ="Sammelruf an Alle";
	break;
	case 'C':
	$_SESSION['status_lst_auto'] ="C"; 
	$_SESSION['status_lst_auto2'] ="für Einsatz melden";    	
	break;
	case 'E':
	$_SESSION['status_lst_auto'] ="E"; 
	$_SESSION['status_lst_auto2'] ="Einrücken";    	
	break;
	case 'F':
	$_SESSION['status_lst_auto'] ="F";   
	$_SESSION['status_lst_auto2'] ="über IM melden";  	
	break;
	case 'H':
	$_SESSION['status_lst_auto'] ="H";  
	$_SESSION['status_lst_auto2'] ="Wache anfahren";   	
	break;
	case 'J':
	$_SESSION['status_lst_auto'] ="J";     
	$_SESSION['status_lst_auto2'] ="Sprechaufforderung";	
	break;
	case 'L':
	$_SESSION['status_lst_auto'] ="L";  
	$_SESSION['status_lst_auto2'] ="Lage melden";   	
	break;
	case 'O':
	$_SESSION['status_lst_auto'] ="O";  
	$_SESSION['status_lst_auto2'] ="Notarzt kommt";   	
	break;
	case 'P':
	$_SESSION['status_lst_auto'] ="P";     
	$_SESSION['status_lst_auto2'] ="Standort melden";	
	break;
	case 'U':
	$_SESSION['status_lst_auto'] ="U";  
	$_SESSION['status_lst_auto2'] ="Achtung Infektiös";   	
	break;
	case 'c':
	$_SESSION['status_lst_auto'] ="c";   
	$_SESSION['status_lst_auto2'] ="Status korrigieren";  	
	break;
	case 'd':
	$_SESSION['status_lst_auto'] ="d";   
	$_SESSION['status_lst_auto2'] ="Ziel durchgeben";  	
	break;
	case 'h':
	$_SESSION['status_lst_auto'] ="h";  
	$_SESSION['status_lst_auto2'] ="Klinik verständigt";   	
	break;
	case 'u':
	$_SESSION['status_lst_auto'] ="u";  
	$_SESSION['status_lst_auto2'] ="Verstanden";   	
	break;
	case 'o':
	$_SESSION['status_lst_auto'] ="o";     	
	$_SESSION['status_lst_auto2'] ="Warten";
	break;
	case 'exit':
	$_SESSION['status_lst_auto'] ="_";   
	$_SESSION['status_lst_auto2'] ="________________";  	
	break;
	}
	//echo $_SESSION['status_lst_auto'].$autolst; 

mysql_query('UPDATE `'.$mysql_prefix.'fahrzeuge` SET `status_lst` =  "'.$_SESSION['status_lst_auto'].'" , `status_lst_2` =  "'.$_SESSION['status_lst_auto2'].'" WHERE `frn` = "'.$_SESSION['status_auto_kennung'].'";');
}


?> 