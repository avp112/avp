<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/



 $col1="#ffffff";
 $col2="#000000";
$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");
print ' <form method="POST" action="leitstelle.php?aktion=5_storno"> ';
      // Tabellenüberschrift
 echo " <body bgcolor=#C0C0C0>
<table border=0 >
    <tr>

    <td bgcolor=D20D02 width=\"365\" align=\"center\" colspan=\"5\">Rettungsdienst Nord</a></td> 
    </tr>
    
    <tr>
    <td bgcolor=D20D02 align=\"center\" width=\"60\">Fahrzeug</td>
    <td bgcolor=D20D02 align=\"center\" width=\"75\">Bezeichnung</td>
    <td bgcolor=D20D02 align=\"center\" width=\"50\">Status KFZ</td>
    <td bgcolor=D20D02 align=\"center\" width=\"50\">Status LST</td>
    <td bgcolor=D20D02 align=\"center\" width=\"140\">Zeit</td>

  </tr>
  ";
$ergebnis = mysql_query('SELECT  `frn` , `kruz` , `so_b`, `fhztyp`,`titel`,`Zeit` , `status_fhr` , `status_lst` ,`status_fhr_save` FROM `'.$mysql_prefix.'fahrzeuge` WHERE (`so_b` = "3" and ( `status_fhr` != "'.$statussichtbar.'" and `status_fhr` != "5" ))  ORDER BY `frn` ASC;');
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
 echo "
  <tr> 
    <td align=\"center\" bgcolor=$col1><font color=$col2\">$frn</font></td>  
      ";
echo "
	<td align=\"center\" bgcolor=$col1><font color=$col2\">$kruz</font></td>";

if ($status_fhr == "5" )
{   
echo "<td align=\"center\" bgcolor=$col1><font color=\"#FFFFFF\"><a class=\"buttonn\" a href=\"?aktion=status_5_storno&auto=$frn&oldst=$status_fhr_save\" ; return false><span>$status_fhr</a></span></font></td>";}

elseif ($status_fhr == "0" )
{   
echo "<td align=\"center\" bgcolor=$col1><a class=\"buttons\"; return false><span>$status_fhr</span></td>";
}

else
{
echo "<td align=\"center\" bgcolor=$col1><a class=\"buttony\"; return false><span>$status_fhr</span></td>";
}

echo "
		<td align=\"center\" bgcolor=$col1><a class=\"buttons\"; OnClick=\"javascript: fenster1('./includes/lststatus.php?autolst=$frn','VFFMS',350,200)\" HREF=\"\" title=\"LST-Status ändern von Fahrzeug $frn \"; return false><span>$status_lst</a></span></font></td>


	<td align=\"center\" bgcolor=$col1><font color=$col2\">$Zeit</font></td>	


  </tr>
  ";
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
	
	


