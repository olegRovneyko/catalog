<?php

include 'config.php';
include 'functions.php';

$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = categories_to_string($categories_tree);

if (isset($_GET['product'])) {
	$product_id = (int)$_GET['product'];
	// массив данных продукта
	$get_one_product = get_one_product($product_id);
	// получаем ID категории
	$id = $get_one_product['parent'];
} else {
	// получаем ID категории
	$id = (int)$_GET['category'];
}



//хлебные крошки
$breadcrumbs_array = breadcrumbs($categories, $id);
if ($breadcrumbs_array) {
	$breadcrumbs = '<a href="' . PATH . '">Главная</a> / ';
	foreach ($breadcrumbs_array as $id => $title) {
		$breadcrumbs .= '<a href="' . PATH . '?category=' . $id . '">' . $title . '</a> / ';
	}

	if (!isset($get_one_product)) {
		$breadcrumbs = rtrim($breadcrumbs, ' / ');
		$breadcrumbs = preg_replace('~(.+)?<a.+>(.+)</a>~', '$1$2', $breadcrumbs);
	} else {
		$breadcrumbs .= $get_one_product['title'];
	}

} else {
	$breadcrumbs = '<a href="' . PATH . '">Главная</a> / Каталог';
}

//ID дочерних категорий
$ids = cats_id($categories, $id);
$ids = $ids ? rtrim($ids, ',') : $id;


/*=============Пагинация=============*/
// кол-во товаров на страницу
$perpage = 5;

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

