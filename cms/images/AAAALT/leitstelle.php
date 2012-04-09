<?php session_start();
error_reporting(0);	

//$reloadpage="leitstelle_inc.php";
include("./functions/header.php");
include("./includes/config.oe.inc.php");



print ' <div style="position:absolute; top:1mm; left:1mm; z-index:1"> ';
print ' <iframe name="I1" src="http://testleitstelle.online-einsaetze.de/alarmierung.php" width="1200" height="300" scrolling="no" border="0" frameborder="0">';
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';

print ' <div style="position:absolute; top:70mm; left:1mm; z-index:1"> ';
print ' <iframe name="I2" src="http://testleitstelle.online-einsaetze.de/leitstelle2_inc.php" width="1200" height="35" border="0" scrolling="no" frameborder="0">';
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';


print ' <div style="position:absolute; top:90mm; left:1mm; z-index:1"> ';
print ' <iframe name="I2" src="http://testleitstelle.online-einsaetze.de/leitstelle_inc.php" width="1200" height="800" border="0" scrolling="yes" frameborder="0">';
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';

?>
<script type="text/javascript">
function change_parent_url(url)
 {
	    document.location=url; 
    }		
 </script>