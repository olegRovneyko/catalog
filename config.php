<?php

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'apple');

$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die('Нет соединения с БД');
mysqli_set_charset($connection, 'utf8') or die('Не установлена кодировка соединения');