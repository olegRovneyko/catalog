<?php

include 'catalog.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
	<link rel="stylesheet" href="<?= PATH ?>style.css">
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


			<?php if ($products) : ?>
				<div>
					<select name="perpage" id="perpage">
						<?php foreach ($option_perpage as $option) : ?>
							<option <?php if ($perpage == $option) echo "selected" ?> value="<?= $option ?>"><?= $option ?> товаров на страницу</option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php if ($count_pages > 1) : ?>
					<div class="pagination"><?= $pagination ?></div>
				<?php endif; ?>

				<?php foreach ($products as $product) : ?>
					<a href="<?= PATH ?>product/<?= $product['id'] ?>"><?= $product['title'] ?></a><br>
				<?php endforeach; ?>
			<?php else : ?>
				<p>Здесь товаров нет</p>
			<?php endif; ?>
			<?php if ($count_pages > 1) : ?>
				<div class="pagination"><?= $pagination ?></div>
			<?php endif; ?>
		</div>
	</div>
	<script src="<?= PATH ?>js/jquery-1.9.0.min.js"></script>
	<script src="<?= PATH ?>js/jquery.accordion.js"></script>
	<script src="<?= PATH ?>js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function() {
			$(".category").dcAccordion();
			$("#perpage").change(function() {
				var perPage = $(this).val();
				$.cookie('per_page', perPage, {expires: 7});
				window.location = location.href;
			});
		});
	</script>
</body>
</html>