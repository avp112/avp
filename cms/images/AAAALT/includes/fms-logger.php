<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/

include("config.oe.inc.php");

 $col1="#ffffff";
 $col2="#000000";
$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");
      // Tabellenüberschrift

if ($_SESSION['fms-log'] == 1){
 echo " <body bgcolor=#C0C0C0>
<table border=0 >
    <tr>

    <td bgcolor=D20D02 width=\"365\" align=\"center\" colspan=\"5\">FMS Log</a></td> 
    </tr>
    
    <tr>
    <td bgcolor=D20D02 align=\"center\" width=\"60\">Fahrzeug</td>
    <td bgcolor=D20D02 align=\"center\" width=\"75\">Status</td>
    <td bgcolor=D20D02 align=\"center\" width=\"100\">IP-Adresse</td>
    <td bgcolor=D20D02 align=\"center\" width=\"140\">Zeit</td>
    <td bgcolor=D20D02 align=\"center\" width=\"140\">Benutzername</td>
  

  </tr>
  ";}
else 
{
 echo " <body bgcolor=#C0C0C0>
<table border=0 >
    <tr>

    <td bgcolor=D20D02 width=\"365\" align=\"center\" colspan=\"5\">FMS Log</a></td> 
    </tr>
    <tr>
    <td bgcolor=D20D02 align=\"center\" width=\"60\">Fahrzeug</td>
    <td bgcolor=D20D02 align=\"center\" width=\"75\">Status</td>
    <td bgcolor=D20D02 align=\"center\" width=\"140\">Zeit</td>
    <td bgcolor=D20D02 align=\"center\" width=\"140\">Benutzername</td>
  

  </tr>
  ";}



$ergebnis = mysql_query('SELECT  `frn` , `status` , `ip`, `zeit`, `user` FROM `'.$mysql_prefix.'fmslog`  ORDER BY `zeit` DESC;');
   while ($row=mysql_fetch_array($ergebnis)) {
 extract ($row);
 
if($status_fhr == "1" )
    {
    $col1="#33cc33";
    $col2="#000000";
    }
  elseif ($status_fhr == "2" )
    {
    $col1="#66ff33";
    $col2="#000000";
    }
 elseif ($status_fhr == "3" ) 
    {
    $col1="#ffff66";
    $col2="#000000";
    }
 elseif ($status_fhr == "4" )
    {
    $col1="#3399ff";
    $col2="#000000";
    }
 elseif ($status_fhr == "5" )
    {
    $col1="#1515A4";
    $col2="#FFFFFF";
    }
 elseif ($status_fhr == "6" )  
    {
    $col1="#999900";
    $col2="#000000";
    }
 elseif ($status_fhr == "7" )
    {
    $col1="#99cc00";
    $col2="#000000";
    }
 elseif ($status_fhr == "8" )
    {
    $col1="#0000ff";
    $col2="#000000";
    }
 elseif ($status_fhr == "9" )
    {
    $col1="#66ff33";
    $col2="#000000";
    }
 else 
    {
    $col1="#E10000";
    }


       // Tabellen Inhalt
 
if ($_SESSION['fms-log'] == 1){
echo "
  <tr> 
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$frn</font></td>  
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$status</font></td>
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$ip</font></td>
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$zeit</font></td>	
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$user</font></td>


  </tr>
  ";}
else{
echo "
  <tr> 
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$frn</font></td>  
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$status</font></td>
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$zeit</font></td>	
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$user</font></td>


  </tr>
  ";}

}
   echo "</table></body>";
print ' </form>';

  ?>

 <script type="text/javascript">
function fenster1(winname,wintitel,breite,hoehe) {
	var links=screen.width/2-breite/2;
	var oben=screen.height/2-hoehe/2;
	NewWin = window.open(winname, wintitel, "width="+breite+",height="+hoehe+",top="+oben+",left="+links+",scrollbars=no,toolbar=0,location=0");
}
function fenster2(winname,wintitel,breite,hoehe) {
	var links=screen.width/2-breite/2;
	var oben=screen.height/2-hoehe/2;
	NewWin = window.open(winname, wintitel, "width="+breite+",height="+hoehe+",top="+oben+",left="+links+",scrollbars=yes,toolbar=0,location=0");
}
</script>
	
	


