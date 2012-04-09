<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/

include("config.oe.inc.php");
 $col1="#ffffff";
$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");
print ' <form method="POST" action="leitstelle.php?aktion=5_storno"> ';
      // Tabellenüberschrift
 echo " <body bgcolor=#C0C0C0>
<table border=1 >
    
    <tr>
    <td bgcolor=FFCC00 align=\"center\" width=\"60\">Fahrzeug</td>
    <td bgcolor=FFCC00 align=\"center\" width=\"75\">Bezeichnung</td>
    <td bgcolor=FFCC00 align=\"center\" width=\"60\">Status KFZ</td>
    <td bgcolor=FFCC00 align=\"center\" width=\"60\">Status LST</td>
    <td bgcolor=FFCC00 align=\"center\" width=\"160\">Bezeichnung</td>
    <td bgcolor=FFCC00 align=\"center\" width=\"160\">Fahrzeugtyp</td>
    <td bgcolor=FFCC00 align=\"center\" width=\"160\">Zeit</td>
  </tr>
  ";
$ergebnis = mysql_query('SELECT  `frn` , `kruz` , `so_b`, `fhztyp`,`titel`,`Zeit` , `status_fhr` , `status_lst` ,`status_fhr_save`FROM `'.$mysql_prefix.'fahrzeuge` WHERE `so_b` = "1" ORDER BY `frn` ASC;');
   while ($row=mysql_fetch_array($ergebnis)) {
 extract ($row);
 $col1="#33cc33";


       // Tabellen Inhalt
 echo "
  <tr> 
    <td align=\"center\" bgcolor=$col1>$frn</td>  
      ";
echo "
	<td align=\"center\" bgcolor=$col1>$kruz</td>";

if ($status_fhr == "5" )
{   
echo "<td align=\"center\" bgcolor=$col1><a href=\"leitstelle.php?aktion=status_5_storno&auto=$frn&oldst=$status_fhr_save\">$status_fhr </a></td>";}
else
{
echo "<td align=\"center\" bgcolor=$col1>$status_fhr</td>";
}

echo "
	<td align=\"center\" bgcolor=$col1>$status_lst</td>
	<td align=\"center\" bgcolor=$col1>$titel</td>
	<td align=\"center\" bgcolor=$col1>$fhztyp</td>
	<td align=\"center\" bgcolor=$col1>$Zeit</td>	

  </tr>
  ";
}
   echo "</table></body>";
print ' </form>';

  ?>

 
	
	


