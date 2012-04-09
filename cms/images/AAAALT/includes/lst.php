<?php

/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/




print '<table border="0"  cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="500" id="AutoNumber1">';
print '  <tr>';
print ' <td bgcolor=D20D02 width="500" align="center" colspan="4">Statusliste</a></td>'; 
print '  </tr>';
print '  <tr>';
print '    <td width="250"  valign="top">';
include "./includes/status1.php";
print '</td>';
print '    <td width="250"  valign="top">';
include "./includes/status2.php";
print '</td>';

print '    <td width="250"  valign="top">';
include "./includes/status4.php";
print '</td>';
print '<td width="250" rowspan="100" valign="top">';
include "./includes/status05.php";

print '</td>';
print '  </tr>';
print ' <td bgcolor=D20D02 width="500" align="center" colspan="3">Statusliste</a></td>'; 
print '  <tr>';
print '    <td width="250"  valign="top">';
include "./includes/status6.php";

print '</td>';
print '    <td width="250"  valign="top">';
include "./includes/status5.php";
print '</td>';
print '   <td width="250"  valign="top">';
//include "./includes/status7.php";
include "./includes/status3.php";
print '</td>';
print ' </tr>';
print '</table>';


//****









echo "</body></html>\n";
   
?>