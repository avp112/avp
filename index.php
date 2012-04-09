<?php
if (!isset($_SESSION)) {
//Wenn das NICHT derfall ist, starte einfach mal eine
  session_start();
}


include ("./cms/includes/header.php");
print '<center><a href="'.$_SERVER['PHP_SELF'].'" target="_blank"><img src="./cms/images/banner.png" border="0" alt=""></a></center><p>';

//include ("/cms/includes/menue.php");

print ' <div style="position:absolute; top:25mm;  left: 50%; margin-left: -600px;  z-index:1"> ';
print " <iframe name=\"I2b\" src=\"./cms/includes/menue.php\"  width=\"1200\" height=\"50\" border=\"0\"  scrolling=\"no\" frameborder=\"0\">";
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';

print ' <div style="position:absolute; top:45mm;  left: 50%; margin-left: -600px;  z-index:1"> ';
print " <iframe name=\"I2a\" src=\"./cms/pages/news.php\"  width=\"1200\" height=\"50\" border=\"0\"  scrolling=\"no\" frameborder=\"0\">";
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';


print ' <div style="position:absolute; top:65mm;  left: 50%; margin-left: -600px;  z-index:1"> ';
print " <iframe name=\"I2\" src=\"./cms/pages/kalender.php\"  width=\"1200\"  height=\"550\" border=\"0\" scrolling=\"yes\" frameborder=\"0\">";
print ' Ihr Browser unterstützt Inlineframes nicht oder zeigt sie in der derzeitigen Konfiguration nicht an.</iframe>';
print ' </div> ';



?>
<script type="text/javascript">
function change_parent_url(url)
 {
	    document.location=url; 
    }		
 </script>