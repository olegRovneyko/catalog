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