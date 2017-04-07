<?php

/**
	* Распечатка массива
*/
function print_arr($arr)
{
	echo '<pre>' . print_r($arr, true) . '</pre>';
}

/**
	* функция построения дерева из массива
*/
function map_tree($dataset)
{
	$tree = array();

	foreach ($dataset as $id => &$node) {
		if (!$node['parent']) {
			$tree[$id] = &$node;
		} else {
			$dataset[$node['parent']]['childs'][$id] = &$node;
		}		
	}

	return $tree;
}

/**
 * @return array Получение массива категорий
*/
function get_cat()
{
	global $connection;
	$query = 'SELECT * FROM categories';
	$res = mysqli_query($connection, $query);

	$arr_cat = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$arr_cat[$row['id']] = $row;
	}
	return $arr_cat;
}