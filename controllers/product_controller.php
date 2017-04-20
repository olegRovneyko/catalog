<?php

defined('CATALOG') or die('Access denied');

include 'main_controller.php';
include 'models/' . $view . '_model.php';

// массив данных продукта
$get_one_product = get_one_product($product_alias);
// получаем ID категории
$id = $get_one_product['parent'];

// получаем ID товара
$product_id = $get_one_product['id'];

// получаем кол-во комментариев к товару
$count_comments = count_comments($product_id);
// получаем комментарии к товару
$get_comments = get_comments($product_id);
// строим дерево
$comments_tree = map_tree($get_comments);
//получаем HTML код комментариев
$comments = array_to_string($comments_tree, 'comments_template.php');

include 'libs/breadcrumbs.php';

include 'views/' . $view . '.php';

