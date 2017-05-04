<?php

defined('CATALOG') or die('Access denied');

/**
 * Проверка доступности поля
*/
function access_field()
{
	global $connection;
	$fields = array('login', 'email');
	$val = trim(mysqli_real_escape_string($connection, $_POST['val']));
	$field = $_POST['dataField'];

	if (!in_array($field, $fields)) {
		return 'no';
	}
	$query = "SELECT id FROM users WHERE $field = '$val'";
	$res = mysqli_query($connection, $query);
	if (mysqli_num_rows($res) > 0) {
		return 'no';
	} else {
		return 'yes';
	}
}

/**
 * регистрация
*/
function registration()
{
	global $connection;
	$fields = array('login' => 'Логин', 'email' => 'Email');
	$errors = '';
	$login = trim($_POST['login_reg']);
	$name = trim($_POST['name_reg']);
	$email = trim($_POST['email_reg']);
	$password = trim($_POST['password_reg']);
	$post = array($login, $email);

	if (empty($login)) $errors .= '<li>Не указан логин</li>';
	if (empty($name)) $errors .= '<li>Не указано имя</li>';
	if (empty($email)) $errors .= '<li>Не указан e-mail</li>';
	if (empty($password)) $errors .= '<li>Не указан пароль</li>';

	if (!empty($errors)) {
		// не заполнены обязательный поля
		$_SESSION['reg']['errors'] = 'Не заполнены обязательные поля: <ul>' . $errors . '</ul>';
		return;
	}

	$login = mysqli_real_escape_string($connection, $login);
	$name = mysqli_real_escape_string($connection, $name);
	$email = mysqli_real_escape_string($connection, $email);
	$password = md5($password);

	// проверка дублирования данных
	$query = "SELECT login, email FROM users WHERE login = '$login' OR email = '$email'";
	$res = mysqli_query($connection, $query);
	if (mysqli_num_rows($res) > 0) {
		$data = array();
		$k = array();
		while ($row = mysqli_fetch_assoc($res)) {
			// берем то, что совпадает с глобальным массивом POST
			$data = array_intersect($row, $post);
			foreach ($data as $key => $val) {
				$k[$key] = $key;
			}
		}
		foreach ($k as $key => $val) {
			$errors .= '<li>' . $fields[$key] . '</li>';
		}
		$_SESSION['reg']['errors'] = 'Выберите другие значения для полей: <ul>' . $errors . '</ul>';
		return;
	}

	$query = "INSERT INTO users (login, password, name, email) VALUES ('$login', '$password', '$name', '$email')";
	$res = mysqli_query($connection, $query);
	if (mysqli_affected_rows($connection) > 0) {
		$_SESSION['reg']['success'] = 'Регистрация прошла успешно';
		$_SESSION['auth']['user'] = stripslashes($name);
		$_SESSION['auth']['is_admin'] = 0;
	} else {
		// ошибка добавления новой записи
		$_SESSION['reg']['errors'] = 'Ошибка регистрации';
	}
}