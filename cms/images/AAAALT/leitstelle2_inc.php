<?php
session_start(); 
error_reporting(0);
echo '<head>';

include("./functions/header2.php");
include("./actions/leitactions.php"); 



echo "<div style=\"position:absolute; top:center; left:center; z-index:1\" ><a class=\"buttonlst\" title=\"Liste der Einsätze\";  href=\"?aktion1=einsatzliste\"><span>Eigenalarme</span></a>";
echo "<a class=\"buttonlst\" title=\"FMS-STATUS Liste\";  href=\"?aktion1=einsatzliste2\"><span>Fremdalarme</span></a>";
echo "<a class=\"buttonlst\" title=\"FMS-STATUS Liste\";  href=\"?aktion1=fmsliste\"><span>Status alle</span></a>";
echo "<a class=\"buttonlst\" title=\"FMS-STATUS Liste ohne 2\";  href=\"?aktion1=fmsliste2\"><span>Status ohne \"2\"</span></a>";
echo "<a class=\"buttonlst\" title=\"FMS-IP-LOG\";  href=\"?aktion1=fmslog\"><span>FMS-LOG</span></a></div>";
echo "<div style=\"position:absolute; top:center; right:0; z-index:1\" ><a class=\"buttonlst\" title=\"Karte\"; target=\"_blank\" href=\"./karte.php\"><span>Karte</span></a>";
echo "<a class=\"buttonlst\" title=\"News\"; target=\"_blank\" href=\"./news.php\"><span>NEWS</span></a>";
echo "<a class=\"buttonlst\" title=\"Leitstellen Status\"; target=\"_blank\" href=\"./leitstellen_status_2.php\"><span>Leitstellen Status</span></a></div>";

?>