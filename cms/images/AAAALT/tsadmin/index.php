<?php

/**
 * @author Martin Grulich
 * @copyright 2008
 */

    session_start();

    // Konfiguration einbinden
    //include 'config.php';

    // Klassen einbinden
    //include 'classes/mysql.class.php';

    // MySQL Verbindung herstellen
    //$MYSQL = new MySQL($MYSQL_SERVER['main'], $MYSQL_USERNAME['main'], $MYSQL_PASSWORD['main'], $MYSQL_DATABASE['main']);

    // sonstige Dateien einbinden
    //include 'includes/vars.inc.php';
    include 'includes/style.inc.php';
    //include 'includes/action.inc.php';

    // Layout einbinden
	include 'styles/'.$STYLESHEET.'/layout.php';

    //$MYSQL->MySQLClose();

?>