<?php
/*      *******************************************
	* Projekt: Alarmverfuegbarkeit		  *
	* Datei mysql.php			  *
	* Modul "Datenbankanbindung"		  *
	* Mysql Anbindung 			  *
	* *****************************************
	* SEBI | 13.10.2011 | 16:00 | 1.0.0	  *	
        ******************************************/


if ( file_exists('./cms/includes/config.avp.php') )
{
     include('./cms/includes/config.avp.php');
}
if ( file_exists('../includes/config.avp.php') )
{
     include('../includes/config.avp.php');
}

$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");
?>