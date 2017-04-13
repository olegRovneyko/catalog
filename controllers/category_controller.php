<?php

defined('CATALOG') or die('Access denied');

include 'main_controller.php';
include 'models/' . $view . '_model.php';

if (!isset($id)) $id = null;
include 'libs/breadcrumbs.php';

//ID дочерних категорий
$ids = cats_id($categories, $id);
$ids = $ids ? rtrim($ids, ',') : $id;

/*=============Пагинация=============*/
// кол-во товаров на страницу
$perpage = (isset($_COOKIE['per_page']) && (int)$_COOKIE['per_page']) ? $_COOKIE['per_page'] : PERPAGE;

// общее кол-во товаров
$count_goods = count_goods($ids);

// необходимое кол-во страниц
$count_pages = ceil($count_goods / $perpage);
// минимум: 1 страница
if (!$count_pages) $count_pages = 1;

// получение текущей страницы
if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
	if ($page < 1) $page = 1;
} else {
	$page = 1;
}

// если номер зепрошенной  страницы больше максимуиа
if ($page > $count_pages) $page = $count_pages;

// начальная позиция для запроса
$start_pos = ($page - 1) * $perpage;

$pagination = pagination($page, $count_pages);

/*=============Пагинация=============*/

$products = get_product($ids, $start_pos, $perpage);

include 'views/' . $view . '.php';