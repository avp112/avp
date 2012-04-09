<?php
if (!isset($_SESSION)) {
//Wenn das NICHT derfall ist, starte einfach mal eine
  session_start();
}
error_reporting(0);
// Herstellung der Verbindung
include("../includes/header.php");
include("../includes/mysql.php");
$_SESSION["rang"] = "100";

$target1="target";
$sele=$_GET['indexmenues'];
if (!isset($sele)) {
$sele="MAIN";
}

$ergebnis = mysql_query('SELECT  `text` , `link` ,`ziel` ,`menueart`, `rechte` ,`mouseover` ,`reihenfolge`  FROM `'.$mysql_prefix.'menue` WHERE (`menueart` = "'.$sele.'" AND (`rechte` <= ("'.$_SESSION["rang"].'"))) ORDER BY  reihenfolge ASC;');


echo '<table border="0"  width="100%" id="AutoNumber1"><tr><td width="20%">&nbsp;</td><td width="60%" align="center">';



 while ($row=mysql_fetch_array($ergebnis)) {
 extract ($row);

//echo "<a class=\"buttonlst1\" title=$mouseover ; href=$link  target=\"$ziel\" ;><span>$text</span></a>";
echo "<a class=\"buttonlst1\" href=\"javascript:parent.change_parent_url('".$link."');\"><center><span>".$text."</span></center></a>"; 

 

}

echo'</td><td width="20%">&nbsp;</td></tr></table>';

?>

<script type="text/javascript">



