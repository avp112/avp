<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/
    $ts2_server  = "85.25.153.62"; 
    $ts2_tcpport = 51154;
    $ts2_udpport = 8117;

    $tsadmin_username = "leitstelle";  
    $tsadmin_password = "hahn11265345";
    $ERROR = "Fehler";

    $uebergabestring = str_replace("_", " ", $uebergabestring);



    $fp = fsockopen($ts2_server,$ts2_tcpport,&$errno,&$errstr,2);
    if ($fp){
        if (fgets($fp) == "[TS]\r\n"){
            fputs($fp, "SEL $ts2_udpport\r\n");
            if (fgets($fp) == "OK\r\n"){
                fputs($fp, "SLOGIN $tsadmin_username $tsadmin_password\r\n");
                if (fgets($fp) == "OK\r\n"){
                    fputs($fp, "MSG  $uebergabestring\r\n");
                    if (fgets($fp) == "OK\r\n"){
				        $ERROR .= 'Hätte klappen sollen<br />';
                    }  else {
				        $ERROR .= 'Nachricht konnte nicht gesendet werden<br />';
			        }
                } else {
				    $ERROR .= 'TS-Server Login abgelehnt<br />';
			    }
            } else {
				$ERROR .= 'konnte TS-Server nicht auswählen<br />';
			}
        } else {
	        $ERROR .= 'TS-Server antwortet nicht<br />';
	    }
    } else {
        $ERROR .= 'keine Verbindung zum TS-Server<br />';
    }
?>