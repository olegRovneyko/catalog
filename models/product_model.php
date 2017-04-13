<?php

defined('CATALOG') or die('Access denied');


/**
 * Получение отдельного товара
 * @param  int $product_id [description]
 * @return array             [description]
 */
function get_one_product($product_alias)
{
	global $connection;

	$product_alias = mysqli_real_escape_string($connection, $product_alias);
	$query = "SELECT * FROM products WHERE alias = '$product_alias' LIMIT 1";
	$res = mysqli_query($connection, $query);
	return mysqli_fetch_assoc($res);
}