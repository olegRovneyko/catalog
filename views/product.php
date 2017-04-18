<?php defined('CATALOG') or die('Access denied'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= strip_tags($breadcrumbs) ?></title>
	<link rel="stylesheet" href="<?= PATH ?>views/style.css">
</head>
<body>
	<div class="wrapper">
		<div class="sidebar">
				<?php include 'sidebar.php'; ?>
		</div>
		<div class="content">
			<?php include 'menu.php' ?>
			<p><?= $breadcrumbs; ?></p>
			<br>
			<hr>
			<?php if (isset($get_one_product)) : ?>
				<?php print_arr($get_one_product) ?>
			<?php else : ?>
				Такого товара нет
			<?php endif; ?>
			<hr>
			<h3>Отзывы к товару (<?php
				if (!empty($get_comments)) {
					echo count($get_comments);
				} else {
					echo 0;
				}
			?>)</h3>
			<ul class="comments"><?php echo $comments; ?></ul>
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