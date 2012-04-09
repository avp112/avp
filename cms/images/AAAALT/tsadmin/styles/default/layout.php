<?php
    echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
$_SESSION['authenticated']=true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
    <head>
        <title>TSReg-Monitor</title>

        <meta name="DC.title" content="TSReg-Monitor" />
        <meta name="DC.creator" content="Martin Grulich" />
        <meta name="DC.subject" content="TSMonitor" />
        <meta name="DC.description" content="Contact2 Browsergame" />
        <meta name="DC.publisher" content="hackXnet" />
        <meta name="DC.type" content="Text" scheme="DCTERMS.DCMIType" />
        <meta name="DC.format" content="text/html" scheme="DCTERMS.IMT" />
        <meta name="DC.language" content="de" scheme="DCTERMS.RFC3066" />
        <meta name="DC.coverage" content="Bad Muender" scheme="DCTERMS.TGN" />
        <meta name="DC.rights" content="Alle Rechte liegen bei Martin Grulich" />

		<script src="javascript/ajax.js" type="text/javascript"></script>
		<script src="javascript/actions.js" type="text/javascript"></script>

        <script type="text/javascript">
            var STYLESHEET = "<?php echo $STYLESHEET; ?>";
            document.onmousemove = moveInfoWindow;
        </script>

        <link href="styles/<?php echo $STYLESHEET; ?>/style.css" rel="stylesheet" type="text/css" media="all" />
    </head>
    <body 
    <?php
        if($_SESSION['authenticated']){
            echo ' onload="init(\''.$_GET['server'].'\', \''.$_GET['tcp'].'\', \''.$_GET['udp'].'\')"';
        }
    ?>
    >
        <div id="Content">
            <?php
                if($_SESSION['authenticated']){
                    include 'pages/layout_authenticated.php';
                } else {
                    include 'pages/layout_unauthenticated.php';
                }
            ?>
        </div>
        <div id="Info">
            keine Infos geladen !
        </div>
    </body>
</html>