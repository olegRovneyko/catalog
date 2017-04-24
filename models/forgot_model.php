<?php

defined('CATALOG') or die('Access denied');

/**
 * начало восстановления пароля
*/
function forgot() {
	global $connection;
	$email = trim(mysqli_real_escape_string($connection, $_POST['email']));
	if (empty($email)) {
		$_SESSION['auth']['errors'] = 'Поле email не заполнено';
		redirect();
	}
}