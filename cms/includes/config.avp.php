<?php 
//Session Start muss immer am Anfang stehen sonst funktioniert dies nicht
/*      *******************************************
	* Projekt: Alarmverfuegbarkeit		  *
	* Datei config.avp.php			  *
	* Modul "Zugangsdaten"		  *
	* Mysql Zugansdaten 			  *
	* *****************************************
	* SEBI | 13.10.2011 | 16:00 | 1.0.0	  *	
        *****************************************  

  Beudeutet dass keine Fehleranzeige
    error_reporting(1);       // es werden nur Fatal Error angezeigt
    error_reporting(8);       // es werden nur Notice angezeigt
    error_reporting(2+4);     // es werden nur Warnungen(2) und
                              // Parse Error(4) angezeigt
    error_reporting(6);       // siehe oben (6 = 2+4)
    error_reporting(1+2+4+8); // es werden Fatal Error, Warnings, Parse Error
                              // und Notices ausgegeben
    error_reporting(15);      // siehe oben (1+2+4+8 = 15)
    error_reporting(0);       // gibt keine Fehlermeldungen aus
    error_reporting(E_ERROR);           // nur Fatal Errors
    error_reporting(E_ERROR + E_PARSE); // nur Fatal und Parse Error
*/
error_reporting(0);
$mysql_host = "localhost";
$mysql_user = "avpsystem001";
$mysql_password = "fARJFFJLTBDzRedA";
$mysql_db = "avp_system";
$mysql_prefix = "avp_"; 
$mysql_prefixT = "avp_test"; 
$mysql_prefix1 = "wcf1_";
$hostname="alaermverfuegbarkeit.de";
$path="/cms";
$adminpath="/cms/admin/";

$vnr = "BETA 1";
$vdate = "13.10.2011";
?>