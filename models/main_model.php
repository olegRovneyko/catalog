<?php

defined('CATALOG') or die('Access denied');


/**
	* Распечатка массива
*/
function print_arr($arr)
{
	echo '<pre>' . print_r($arr, true) . '</pre>';
}

/**
 * [redirect description]
 * @return [type] [description]
 */
function redirect($http = false)
{
	if ($http) {
		$redirect = $http;
	} else {
		$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
	}
	header('Location: ' . $redirect);
	exit;
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
 * Получение страниц меню
 * @return array [description]
 */
function get_pages()
{
	global $connection;
	$query = 'SELECT title, alias FROM pages ORDER BY position';
	$res = mysqli_query($connection, $query);

	$pages = array();
	while ($row = mysqli_fetch_assoc($res)) {
		$pages[$row['alias']] = $row['title'];
	}
	return $pages;
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
function array_to_string($data, $template = 'category_template.php')
{
	$string = '';
	foreach ($data as $item) {
		$string .= categories_to_template($item, $template);
	}
	return $string;
}

/**
 * Шаблон вывода категорий
 */
function categories_to_template($data, $template)
{
	ob_start();
	include VIEW . $template;
	return ob_get_clean();
}

/**
 * Постраничная навигация
 * @param  int $page        [description]
 * @param  int $count_pages [description]
 * @return [type]              [description]
 */
function pagination($page, $count_pages, $modrew = true)
{
	// << < 3 4 5 6 7 > >>
	$startpage = null;
	$back = null;
	$page2left = null;
	$page1left = null;
	$page1right = null;
	$page2right = null;
	$forward = null;
	$endpage = null;

	$uri = '?';
	if (!$modrew) {
		// если есть параметры в запросе
		if ($_SERVER['QUERY_STRING']) {
			foreach ($_GET as $key => $value) {
				if ($key != 'page') {
					$uri .= $key . '=' . $value . '&amp;';
				}
			}
		}
	} else {
		$url = $_SERVER['REQUEST_URI'];
		$url = explode('?', $url);
		if (isset($url[1]) && $url[1] != '') {
			$params = explode('&', $url[1]);
			foreach ($params as $param) {
				if (!preg_match('~page=~', $param)) $uri .= $param . '&amp;';
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