<?PHP
/*
Diese Datei ist Teil der Leitstelle von Online-Einsätze.de
Copyright (C) 2008 Sebastian Hahn
Email: sebastian@taunussteinweb.de, ICQ: 103440856

*/

include("config.oe.inc.php");

error_reporting(E_ALL);
// DB Settings


$db_connect = mysql_connect($mysql_host,$mysql_user,$mysql_password) // MYSQL-Connection
or die ("Verbindung fehlgeschlagen");
mysql_select_db($mysql_db, $db_connect)   // DB-Connection
or die ("Datenbank existiert nicht");



$result = mysql_query("SELECT * FROM bh_lst_einheiten");

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    printf ("ID: %s  Name: %s", $row["id"], $row["name"]);
}

    mysql_free_result($result);

?>
