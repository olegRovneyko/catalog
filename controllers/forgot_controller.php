<?php

defined('CATALOG') or die('Access denied');

include 'main_controller.php';
include 'models/' . $view . '_model.php';

// запрошено восстановление пароля
if (isset($_POST['fpass'])) {
	forgot();
}

//$breadcrumbs = '<a href="' . PATH . '">Главная</a> / Восстановление пароля';

//include 'views/' . $view . '.php';
