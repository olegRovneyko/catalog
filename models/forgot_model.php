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
	} else {
		$query = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
		$res = mysqli_query($connection, $query);
		if (mysqli_num_rows($res) == 1) {
			$expire = time() + 3600;
			$hash = md5($expire . $email);
			$query = "INSERT INTO forgot (hash, expire, email) VALUES ('$hash', $expire, '$email')";
			$res = mysqli_query($connection, $query);
			if (mysqli_affected_rows($connection) > 0) {
				// если добавлена запись в таблицу forgot
				$link =PATH . 'forgot/?forgot=' . $hash;
				$subject = 'Запрос на восстановление пароля на сайте ' . PATH;
				$body = 'По ссылке <a href="' . $link . '">' . $link . '</a> вы найдете страницу  с формой для восстановления пароля. Ссылка активна в течение часа';
				$headers = "FROM: " . strtoupper($_SERVER['SERVER_NAME']) . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8";
				mail($email, $subject, $body, $headers);
				$_SESSION['auth']['ok'] = 'На ваш email выслана инструкция по восстановлению пароля';
			} else {
				$_SESSION['auth']['errors'] = 'Ошибка';
			}
		} else {
			$_SESSION['auth']['errors'] = 'Пользователь с таким email не найден';
		}
	}
}

/**
 * проверка права пользователя на измениение пароля
 * @return [type] [description]
 */
 function access_change()
 {
 	global $connection;
 	$hash = trim(mysqli_real_escape_string($connection, $_GET['forgot']));
 	// если нет хеша
 	if (empty($hash)) {
 		$_SESSION['forgot']['errors'] = 'Указана не полная ссылка';
 		return;
 	}
 	$query = "SELECT * FROM forgot WHERE hash = '$hash' LIMIT 1";
 	$res = mysqli_query($connection, $query);
 	// если hash не найден
 	if (!mysqli_num_rows($res)) {
 		$_SESSION['forgot']['errors'] = 'Ссылка устарела или не корректна. Пройдите процедуру восстановления пароля заново';
 		return;
 	}
 	$now = time();
 	$row = mysqli_fetch_assoc($res);

 	// усли ссылка устарела
 	if ($now > $row['expire']) {
 		$_SESSION['forgot']['errors'] = 'Ссылка устарела. Пройдите процедуру восстановления пароля заново';
 		return;
 	}
 }