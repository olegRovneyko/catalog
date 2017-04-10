<?php defined('CATALOG') or die('Access denied'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
	<link rel="stylesheet" href="<?= PATH ?>views/style.css">
</head>
<body>
	<a href="<?= PATH ?>">Главная</a>
	<div class="wrapper">
		<div class="sidebar">
			<ul class="category">
				<?php echo $categories_menu; ?>
			</ul>
		</div>
		<div class="content">
			<p><?= $breadcrumbs; ?></p>
			<br>
			<hr>
			<?php if (isset($get_one_product)) : ?>
				<?php print_arr($get_one_product) ?>
			<?php else : ?>
				Такого товара нет
			<?php endif; ?>
		</div>
	</div>
	<script src="<?= PATH ?>views/js/jquery-1.9.0.min.js"></script>
	<script src="<?= PATH ?>views/js/jquery.accordion.js"></script>
	<script src="<?= PATH ?>views/js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function() {
			$(".category").dcAccordion();
		});
	</script>
</body>
</html>