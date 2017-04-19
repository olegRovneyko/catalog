<?php defined('CATALOG') or die('Access denied'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= strip_tags($breadcrumbs) ?></title>
	<link rel="stylesheet" href="<?= PATH ?>views/style.css">
	<link rel="stylesheet" href="<?= PATH ?>views/css/jquery-ui.min.css">
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
			<ul class="comments">
				<?php echo $comments; ?>
			</ul>

			<button class="open-form">Добавить отзыв</button>

			<div id="form-wrap">
				<form action="<?= PATH ?>add_comment" method="POST" class="form">
					<p>
						<label for="comment_author">Имя:</label>
						<input type="text" name="comment_author" id="comment_author">
					</p>
					<p>
						<label for="comment_text">Текст:</label>
						<textarea name="comment_text" id="comment_text" cols="30" rows="5"></textarea>
					</p>
					<input type="hidden" name="parent" id="parent" value="0">
					<!-- <p class="submit">
						<input type="submit" value="Добавить отзыв" name="submit">
					</p> -->
				</form>
			</div>
		</div>
	</div>
	<script src="<?= PATH ?>views/js/jquery-1.9.0.min.js"></script>
	<script src="<?= PATH ?>views/js/jquery-ui.min.js"></script>
	<script src="<?= PATH ?>views/js/jquery.accordion.js"></script>
	<script src="<?= PATH ?>views/js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function() {
			$(".category").dcAccordion();

			$(".open-form").click(function() {
				$( "#form-wrap" ).dialog('open');
				var parent = $(this).children().attr('data');
				if (!parseInt(parent)) parent = 0;
				$('input[name="parent"]').val(parent);
			});

			$( "#form-wrap" ).dialog({
				autoOpen: false,
				width: 450,
				modal: true,
				title: 'Добавление сообщения',
				resizable: false,
				draggable: false,
				show: {effect: 'blind', duration: 700},
				hide: {effect: 'explode', duration: 700},
				buttons: {
					'Добавить отзыв': function() {
							var commentAuthor = $.trim($('#comment_author').val());
							var commentText = $.trim($('#comment_text').val());
							var parent = $('#parent').val();
							var productId = <?= $product_id ?>;

							if (commentText == '' || commentAuthor == '') {
								alert('Все поля обязательны к заполнению');
								return;
							}

							$('#comment_text').val('');
							$(this).dialog('close');

							$.ajax({
								url: "<?= PATH ?>add_comment",
								type: 'POST',
								data: {
									commentAuthor: commentAuthor,
									commentText: commentText,
									parent: parent,
									productId: productId
								},
								success: function(res) {
									var result = JSON.parse(res);
									console.log(result);
								},
								error: function() {
									alert('Ошибка!');
								}
							});
					},
					'Отмена': function() {
						$('#comment_text').val('');
						$(this).dialog('close');
					}
				}
			});

		});
	</script>
</body>
</html>