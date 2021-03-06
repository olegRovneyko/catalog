<?php
//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL);
session_start();

define('CATALOG', true);
include_once 'config.php';

$product_alias = null;

$routes = array(
	array('url' => '~^$|^\?~', 'view' => 'category'),
	array('url' => '~^product/(?P<product_alias>[0-9a-z-]+)~i', 'view' => 'product'),
	array('url' => '~^category/(?P<id>\d+)?~i', 'view' => 'category'),
	array('url' => '~^page/(?P<page_alias>[0-9a-z-]+)?~i', 'view' => 'page'),
	array('url' => '~^add_comment$~i', 'view' => 'add_comment'),
	array('url' => '~^login$~i', 'view' => 'login'),
	array('url' => '~^logout$~i', 'view' => 'logout'),
	array('url' => '~^forgot~i', 'view' => 'forgot'),
	array('url' => '~^reg~i', 'view' => 'reg')
);

$url = ltrim($_SERVER['REQUEST_URI'], '/');

foreach ($routes as $route) {
	if (preg_match($route['url'], $url, $match)) {
		$view = $route['view'];
		break;
	}
}

if (empty($match)) {
	include VIEW . '404.php';
	exit;
}

extract($match);

include 'controllers/' . $view . '_controller.php';