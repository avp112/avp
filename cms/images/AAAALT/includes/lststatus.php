<?php
error_reporting(0);
include("../functions/header.php");
include("../actions/leitstatus.php");

$_session['autolast'] = $_GET['autolst'];


echo '<img src="../css/images/status_leitstelle4_leer.png" width="322" height="188">';
print "<div style=\"position:absolute; top:7mm; left:33mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=A&amp;autolst=".$_session['autolast']."\" title=\"Status A/Sammelruf an Alle\"; return false;\"><span>A</span></a></div>";
print "<div style=\"position:absolute; top:7mm; left:46mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=C&amp;autolst=".$_session['autolast']."\" title=\"Status C/Für Einsatz melden\"; return false;\"><span>C</span></a></div>";
print "<div style=\"position:absolute; top:7mm; left:59mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=E&amp;autolst=".$_session['autolast']."\" title=\"Status E/Einrücken/Abbrechen\"; return false;\"><span>E</span></a></div>";
print "<div style=\"position:absolute; top:7mm; left:72mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=F&amp;autolst=".$_session['autolast']."\" title=\"Status F/über IM melden\"; return false;\"><span>F</span></a></div>";
print "<div style=\"position:absolute; top:17mm; left:33mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=H&amp;autolst=".$_session['autolast']."\" title=\"Status H/Wache anfahren\"; return false;\"><span>H</span></a></div>";
print "<div style=\"position:absolute; top:17mm; left:46mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=J&amp;autolst=".$_session['autolast']."\" title=\"Status J/Sprechaufforderung\"; return false;\"><span>J</span></a></div>";
print "<div style=\"position:absolute; top:17mm; left:59mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=L&amp;autolst=".$_session['autolast']."\" title=\"Status L/Lagemeldung abgeben\"; return false;\"><span>L</span></a></div>";
print "<div style=\"position:absolute; top:17mm; left:72mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=O&amp;autolst=".$_session['autolast']."\" title=\"Status O/Notarzt kommt /RD\"; return false;\"><span>O</span></a></div>";
print "<div style=\"position:absolute; top:27mm; left:33mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=P&amp;autolst=".$_session['autolast']."\" title=\"Status P/Standort Melden\"; return false;\"><span>P</span></a></div>";
print "<div style=\"position:absolute; top:27mm; left:46mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=U&amp;autolst=".$_session['autolast']."\" title=\"Status U/Achtung Infekiös\"; return false;\"><span>U</span></a></div>";
print "<div style=\"position:absolute; top:27mm; left:59mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=c&amp;autolst=".$_session['autolast']."\" title=\"Status c/Status korrigieren\"; return false;\"><span>c</span></a></div>";
print "<div style=\"position:absolute; top:27mm; left:72mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=d&amp;autolst=".$_session['autolast']."\" title=\"Status d/Transportziel durchgeben\"; return false;\"><span>d</span></a></div>";
print "<div style=\"position:absolute; top:37mm; left:33mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=h&amp;autolst=".$_session['autolast']."\" title=\"Status h/Zielklinik verständigt\"; return false;\"><span>h</span></a></div>";
print "<div style=\"position:absolute; top:37mm; left:46mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=o&amp;autolst=".$_session['autolast']."\" title=\"Status o/Warten\"; return false;\"><span>o</span></a></div>";
print "<div style=\"position:absolute; top:37mm; left:59mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=u&amp;autolst=".$_session['autolast']."\" title=\"Status u/Verstanden\"; return false;\"><span>u</span></a></div>";
print "<div style=\"position:absolute; top:37mm; left:72mm; z-index:1\" ><a class=\"button112\" href=\"?aktion=statuswechsellst&amp;statuslst=exit&amp;autolst=".$_session['autolast']."\" title=\"Status loeschen\"; return false;\"><span>X</span></a></div>";
print "<div style=\"position:absolute; top:10.5mm; left:6mm; z-index:1\" ><gelbfett>Auto : ".$_session['autolast']."<gelbfett></div>";

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function fenster()
{
fenster0=open("./news.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=600,height=350,right=100,top=20");
}
function fenster1()
{
fenster0=open("./seiten/news/lst.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=150,right=50,top=20");
}
function fenster2()
{
fenster0=open("./seiten/news/adm.php","wk","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=600,height=150,right=50,top=20");
}
//-->
</SCRIPT>



