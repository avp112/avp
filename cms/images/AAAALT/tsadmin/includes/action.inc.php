<?php

/**
 * @author Martin Grulich
 * @copyright 2007
 */

	switch($_GET['action']){
		case 'login':
			$MYSQL->MySQLQuery('SELECT * FROM `'.$MYSQL_PREFIX['main'].'user` WHERE `username` = "'.mysql_escape_string($_POST['username']).'" AND `password` = "'.mysql_escape_string(md5($_POST['password'])).'"');
			while($row = $MYSQL->MySQLResult()){
                $_SESSION['authenticated'] = true;
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['user_id'] = $row['id'];
                header('Location: http://artwork.htn-contact.de');
            }
            $login_error = 'Benutzername oder Passwort falsch';
		break;

		case 'logout':
			if(session_unset()){
				$SUCCESS_login = 'Sie wurden erfolgreich ausgeloggt';
			}
			header('Location: http://artwork.htn-contact.de');
		break;
	}

?>