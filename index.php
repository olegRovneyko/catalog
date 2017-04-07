<?php

include 'config.php';
include 'functions.php';

$categories = get_cat();
$categories_tree = map_tree($categories);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<a href="/catalog/">Главная</a>
	<div class="wrapper">
		<div class="sidebar">SIDEBAR</div>
		<div class="content">
			<!-- <?php print_arr($categories); ?> -->
			<?php print_arr($categories_tree); ?>
		</div>
	</div>
</body>
</html>