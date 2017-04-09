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
 * Получение массива категорий
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

/**
 * Массив в структуру HTML
 */
function categories_to_string($data)
{
	foreach ($data as $item) {
		$string .= categories_to_template($item);
	}
	return $string;
}

/**
 * Шаблон вывода категорий
 */
function categories_to_template($category)
{
	ob_start();
	include 'category_template.php';
	return ob_get_clean();
}

/**
 * хлебные крошки
 * @return true (array not empty) || return false;
 */
function breadcrumbs($array, $id)
{
	if (!$id) return false;

	$count = count($array);
	$breadcrumbs_array = array();
	for ($i = 0; $i < $count; $i++) {
		if (isset($array[$id])) {
			$breadcrumbs_array[$array[$id]['id']] = $array[$id]['title'];
			$id = $array[$id]['parent'];
		} else break;
	}
	return array_reverse($breadcrumbs_array, true);
}

/**
 * получение ID дочерних категорий
 * @param  array $categories [description]
 * @param  int $id         [description]
 * @return string             [description]
 */
function cats_id($array, $id)
{
	if (!$id) return false;

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

/**
 * Постраничная навигация
 * @param  int $page        [description]
 * @param  int $count_pages [description]
 * @return [type]              [description]
 */
function pagination($page, $count_pages)
{
	// << < 3 4 5 6 7 > >>
	// $startpage
	// $back
	// $page2left
	// $page1left
	// $page1right
	// $page2right
	// $forward
	// $endpage

	$uri = '?';
	// если есть параметры в запросе
	if ($_SERVER['QUERY_STRING']) {
		foreach ($_GET as $key => $value) {
			if ($key != 'page') {
				$uri .= $key . '=' . $value . '&amp;';
			}
		}
	}

	if ($page > 1) {
		$back = '<a class="nav-link" href="' . $uri . 'page=' . ($page - 1) . '">&lt;</a>';
	}
	if ($page < $count_pages) {
		$forward = '<a class="nav-link" href="' . $uri . 'page=' . ($page + 1) . '">&gt;</a>';
	}
	if ($page > 3) {
		$startpage = '<a class="nav-link" href="' . $uri . 'page=1">&laquo;</a>';
	}
	if ($page < ($count_pages - 2)) {
		$endpage = '<a class="nav-link" href="' . $uri . 'page=' . $count_pages . '">&raquo;</a>';
	}
		if (($page - 2) > 0) {
		$page2left = '<a class="nav-link" href="' . $uri . 'page=' . ($page - 2) . '">' . ($page - 2) . '</a>';
	}
		if (($page - 1) > 0) {
		$page1left = '<a class="nav-link" href="' . $uri . 'page=' . ($page - 1) . '">' . ($page - 1) . '</a>';
	}
	if (($page + 2) <= $count_pages) {
		$page2right = '<a class="nav-link" href="' . $uri . 'page=' . ($page + 2) . '">' . ($page + 2) . '</a>';
	}
	if (($page + 1) <= $count_pages) {
		$page1right = '<a class="nav-link" href="' . $uri . 'page=' . ($page + 1) . '">' . ($page + 1) . '</a>';
	}


	return $startpage . $back . $page2left . $page1left . '<a class="nav-active">' . $page . '</a>' . $page1right . $page2right . $forward . $endpage;
}