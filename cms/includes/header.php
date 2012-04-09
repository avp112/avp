<?php

/*      *******************************************
	* Projekt: Alarmverfuegbarkeit		  *
	* Datei header.php			  *
	* Modul "Header erzeugen"		  *
	* Header f�r alle Seiten			  *
	* *****************************************
	* SEBI | 24.09.2011 | 22:52 | 1.0.0	  *	
        *******************************************/  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="de">
    <head>
        <title>Alarmverf&uuml;gbarkeit 2.0</title>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
        <meta name="DC.title"       content="AVP Login">
        <meta name="DC.creator"     content="Sebastian Hahn und Dirk Grasmehr">
        <meta name="DC.subject"     content="Login">
        <meta name="copyright"      content="Copyright 2011 bei Alarmverfuegbarkeit">
        <meta name="DC.description" content="Alarmverfuegbarkeit">
        <meta name="DC.publisher"   content="Alarmverfuegbarkeit">
        <meta name="DC.contributor" content="Alarmverfuegbarkeit">
        <meta name="DC.date"        content="2008-03-08T07:21:00+01:00" scheme="DCTERMS.W3CDTF">
        <meta name="DC.type"        content="Text"                      scheme="DCTERMS.DCMIType">
        <meta name="DC.format"      content="php/mysql/text/html"       scheme="DCTERMS.IMT">
        <meta name="DC.language"    content="German"  scheme="DCTERMS.RFC3066">
        <meta name="DC.relation"    content="RELATION"                  scheme="DCTERMS.URI">
        <meta name="DC.rights"      content="Alle Rechte liegen bei Alarmverfuegbarkeit">
        <meta name="keywords"       content="Einsaetze,Feuerwehr,Leitstelle,FMS">
	 <LINK REL="SHORTCUT ICON" HREF="./blaulicht.gif">
         <?php
         if ( file_exists('./cms/css/default.css') )
{
     print'<link href="./cms/css/default.css" rel="stylesheet" type="text/css">';
}
         if ( file_exists('../css/default.css') )
{
     print'<link href="../css/default.css" rel="stylesheet" type="text/css">';
}
	
?>