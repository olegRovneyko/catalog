<?php
error_reporting(E_ALL & ~E_NOTICE);

define('CATALOG', true);
include 'config.php';

$product_alias = null;

$routes = array(
	array('url' => '~^$|^\?~', 'view' => 'page'),
	array('url' => '~^product/(?P<product_alias>[0-9a-z-]+)~i', 'view' => 'product'),
	array('url' => '~^category/(?P<id>\d+)?~i', 'view' => 'category'),
	array('url' => '~^page/(?P<page_alias>[0-9a-z-]+)~i', 'view' => 'page')
);

$url = ltrim($_SERVER['REQUEST_URI'], '/');

foreach ($routes as $route) {
	if (preg_match($route['url'], $url, $match)) {
		$view = $route['view'];
		break;
	}
}

if (empty($match)) {
	include 'views/404.php';
	exit;
}

extract($match);
include 'controllers/' . $view . '_controller.php';