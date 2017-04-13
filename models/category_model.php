<?php

defined('CATALOG') or die('Access denied');

/**
 * получение ID дочерних категорий
 * @param  array $categories [description]
 * @param  int $id         [description]
 * @return string             [description]
 */
function cats_id($array, $id)
{
	if (!$id) return false;

	$data = '';
	foreach ($array as $item) {
		if ($item['parent'] == $id) {
			$data .= $item['id'] . ',';
			$data .= cats_id($array, $item['id']);
		}
	}
	return $data;
}

/**
 * Получение товаров
 * @param  string $ids [description]
 * @return aray      [description]
 */
function get_product($ids, $start_pos, $perpage)
{
	global $connection;

	if ($ids) {
		$query = 'SELECT * FROM products WHERE parent IN (' . $ids . ') ORDER BY title LIMIT ' . $start_pos . ', ' . $perpage;
	} else {
		$query = 'SELECT * FROM products ORDER BY title LIMIT ' . $start_pos . ', ' . $perpage;;
	}
	$res = mysqli_query($connection, $query);
	$products = array();
	while ($row = mysqli_fetch_assoc($res)) {
		 $products[] =$row;
	}
	return $products;
}

/**
 * Кол-во товаров
 * @param  [type] $ids [description]
 * @return [type]      [description]
 */
function count_goods($ids)
{
	global $connection;

	if (!$ids) {
		$query = 'SELECT COUNT(*) FROM products';
	} else {
		$query = 'SELECT COUNT(*) FROM products WHERE parent IN (' . $ids . ')';
	}
	$res = mysqli_query($connection, $query);
	$count_goods = mysqli_fetch_row($res);
	return $count_goods[0];
}
