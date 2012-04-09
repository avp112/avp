<?php
/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/

echo'<title>Karte</title>';
echo'<link rel="stylesheet" type="text/css" href="http://leitstelle.online-einsaetze.de/css/default.css">';
echo "<center>";
print ' <div style="position:absolute; top:1mm; left:1mm; z-index:1"> ';
print ' <iframe name="I1" src="http://online-einsaetze.de/site/map/brandhausen.php" width="1200" height="1000" scrolling="no" border="0" frameborder="0">';
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';




echo "</center>";
?>