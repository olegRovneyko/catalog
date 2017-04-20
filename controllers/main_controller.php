<?php

defined('CATALOG') or die('Access denied');

include 'models/main_model.php';

$categories = get_cat();
$categories_tree = map_tree($categories);
$categories_menu = array_to_string($categories_tree);

// Получение страниц меню
$pages = get_pages();