<?php

defined('CATALOG') or die('Access denied');


/**
 * Получение отдельного товара
 * @param  int $page_id [description]
 * @return array             [description]
 */
function get_one_page($page_alias)
{
	global $connection;

	$page_alias = mysqli_real_escape_string($connection, $page_alias);
	$query = "SELECT * FROM pages WHERE alias = '$page_alias' LIMIT 1";
	$res = mysqli_query($connection, $query);
	return mysqli_fetch_assoc($res);
}