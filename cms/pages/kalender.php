<?php
if (!isset($_SESSION)) {
//Wenn das NICHT derfall ist, starte einfach mal eine
  session_start();
}
include("../includes/header.php");
include("../includes/mysql.php");
$_SESSION['avp_userid'] = "1";
$_SESSION['avp_username'] = "Sebastian Hahn";
$monat=date('n');
$jahr=date('Y');
$abwesenheitsmerker=array();
$jahraktuell=date('Y');
if (isset($_GET['jahr'])) {
   $jahr=$_GET['jahr'];
} 

$jahrz =$jahr +1;
$jahrv = $jahr -1;
$heute=date('d');
$stellen="2";
//Eintrag in UserDB Erzeugen je Jahr sofern kein Eintrag vorhanden
	$ergebnis = mysql_query('SELECT  * FROM `'.$mysql_prefix.'userzuranwesenheit` WHERE (`Jahr` = '.$jahr.' and `userid` = '.$_SESSION['avp_userid'].');');
	        if(mysql_num_rows($ergebnis) == 1){
                //Echo "ok";
                }
                else
                {
                mysql_query("INSERT INTO ".$mysql_prefix."userzuranwesenheit(Jahr, userid) VALUES ('".$jahr."', '".$_SESSION['avp_userid']."')");
		echo "<span class=\"usgelbfett\">Eintrag hinzugef&uuml;gt<span>";
                }

$monate=array('Januar','Februar','M&auml;rz','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember');
echo '<table border=0 width=700>';
//Überschrift / Tabellenheader
echo '<th  colspan=4 align=center valign=middle style="font-family:Courier; font-size:18pt; color:#ff9900;" >';
echo "<a class=\"buttonlst2\"  href=\"".$_SERVER['PHP_SELF']."?jahr=".$jahrv."\" ; return false><span>$jahrv</a></span>";
echo "<a class=\"buttonlst6\"  href=\"".$_SERVER['PHP_SELF']."?jahr=".$jahr."\" ; return false><span>$jahr</a></span>";
echo "<a class=\"buttonlst2\"  href=\"".$_SERVER['PHP_SELF']."?jahr=".$jahrz."\" ; return false><span>$jahrz</a></span>";
//echo $jahr."-".$jahraktuell;
Echo $_SESSION['avp_username']."(".$_SESSION['avp_userid'].")";
echo '</th>';

for($reihe=1;$reihe<=3;$reihe++)
{
echo '<tr>';
for ($spalte=1;$spalte<=4;$spalte++)
{
$this_month=($reihe-1)*4+$spalte;
$erster=date('w',mktime(0,0,0,$this_month,1,$jahr));
$insgesamt=date('t',mktime(0,0,0,$this_month,1,$jahr));
if($erster==0){$erster=7;}
echo '<td width="25%" valign=top>';
echo '<table border=0 align=center style="font-size:8pt; font-family:Courier">';
//Monatsüberschriften
echo "<th colspan=7 align=center><a class=\"buttonlst4\" a href=\"#\" ; return false><span>".$monate[$this_month-1]."</a></span></th>";
//Wochentagsüberschriften
echo "<tr><td><a class=\"buttonlst5\" a href=\"#\" ; return false><span>Mo</a></span></td><td><a class=\"buttonlst5\" a href=\"#\" ; return false><span>Di</a></span></td>";
echo "<td><a class=\"buttonlst5\" a href=\"#\" ; return false><span>Mi</a></span></td><td><a class=\"buttonlst5\" a href=\"#\" ; return false><span>Do</a></span></td>";
echo "<td><a class=\"buttonlst5\" a href=\"#\" ; return false><span>Fr</a></span></td><td><a class=\"buttonlst5\" a href=\"#\" ; return false><span>Sa</a></span></td>";
echo "<td><a class=\"buttonlst1\" a href=\"#\" ; return false><span>So</a></span></td></tr>";

echo '<tr><br>';
$i=1;
while($i<$erster){echo '<td> </td>'; $i++;}
$i=1;
while($i<=$insgesamt)
{
$i=sprintf("%0".$stellen."d",$i);
$indtag = new DateTime($jahr."-".$this_month."-".$i."00:00:00");
$indtag->setDate($jahr.",".$this_month.",".$i);
$tagind = date_format($indtag, 'z')+1;
$rest=($i+$erster-1)%7;
//Aktuellen Tag errechnen
if($i==$heute && $this_month==$monat  && $jahr==$jahraktuell){echo '<td style="font-size:8pt; font-family:Courier;" align=center>';}
else{echo '<td style="font-size:8pt; font-family:Courier" align=center>';}

//echo $indtag;
//var_dump($indtag);
if ($i==$heute && $this_month==$monat && $jahr==$jahraktuell){echo "<a class=\"buttonlst\" a href=\"".$_SERVER['PHP_SELF']."?jahresausw=".$jahr."&monat=".$this_month."&tag=".$i."&indtag=".$tagind."\" ; return false><span>$i</a></span>";}
//Samstag errechnen
else if($rest==6){echo "<a class=\"buttonlst2\" a href=\"".$_SERVER['PHP_SELF']."?jahresausw=".$jahr."&monat=".$this_month."&tag=".$i."&indtag=".$tagind."\" ; return false><span>$i</a></span>";}
//Sonntag errechnen
else if($rest==0){echo "<a class=\"buttonlst2\" a href=\"".$_SERVER['PHP_SELF']."?jahresausw=".$jahr."&monat=".$this_month."&tag=".$i."&indtag=".$tagind."\" ; return false><span>$i</a></span>";}

else{
    $i=sprintf("%0".$stellen."d",$i);
    //print'<script type="text/javascript"></script>';
    //Normale Wochentage
   
    echo "<a class=\"buttonlst2\" a href=\"".$_SERVER['PHP_SELF']."?jahresausw=".$jahr."&monat=".$this_month."&tag=".$i."&indtag=".$tagind."\" ; return false><span>$i</a></span>";}
echo "</td>\n";
if($rest==0){echo "</tr>\n<tr>\n";}
//Abwesenheit eintragen der Tage in Tabelle wegschreiben
if (isset($_GET['indtag'])) {
 if ($_GET['indtag'] == $tagind) {
    mysql_query("INSERT INTO ".$mysql_prefix."anwesenheit(userid,tag,jahr,zustand) VALUES ('".$_SESSION['avp_userid']."', '".$tagind."','".$jahr."', 1)");
}	
}
//$abwesenheitsmerker[$jahr."-".$tagind] = "Anwesend";
$i++;
}
echo '</tr>';
echo '</table>';
echo '</td>';
}
echo '</tr>';
}
echo '</table>';


                



//var_dump($abwesenheitsmerker);
?> 
<script type="text/javascript">
function change_parent_url(url)
 {
	    document.location=url; 
    }		
 </script>