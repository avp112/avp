<?php

/**
 * @author Martin Grulich
 * @copyright 2007
 */

	$action = $_GET['action'];
	$page = $_GET['page'];
	if($page == ""){
        $page = "home";
    }

    $MYSQL->MySQLQuery('SELECT * FROM `'.$MYSQL_PREFIX['main'].'config`');
    while($row = $MYSQL->MySQLResult()){
        $config[$row[name]] = $row[value];
    }

	$MYSQL->MySQLQuery('SELECT * FROM `'.$MYSQL_PREFIX['main'].'changelog` ORDER BY `date` DESC LIMIT 1');
    while($row = $MYSQL->MySQLResult()){
        $config['version'] = $row['version'];
    }

    $MYSQL->MySQLQuery('SELECT * FROM `'.$MYSQL_PREFIX['main'].'user` WHERE `id` = "'.$_SESSION['user_id'].'"');
    while($row = $MYSQL->MySQLResult()){
        $user['lastversion'] = $row['lastversion'];
    }

?>