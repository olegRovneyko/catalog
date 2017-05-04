<?php defined('CATALOG') or die('Access denied'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= strip_tags($breadcrumbs) ?></title>
	<link rel="stylesheet" href="<?= PATH . VIEW ?>css/style.css">
	<link rel="stylesheet" href="<?= PATH . VIEW ?>css/jquery-ui.min.css">
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
			<h3>Отзывы к товару (<?= $count_comments ?>)</h3>
			<ul class="comments">
				<?php echo $comments; ?>
			</ul>

			<button class="open-form">Добавить отзыв</button>

			<div id="form-wrap">
				<form action="<?= PATH ?>add_comment" method="POST" class="form">
				<?php if (isset($_SESSION['auth']['user'])) : ?>
					<p style="display: none">
						<label for="comment_author">Имя:</label>
						<input type="text" name="comment_author" id="comment_author" value="<?= htmlspecialchars($_SESSION['auth']['user']) ?>">
					</p>
				<?php else : ?>
					<p>
						<label for="comment_author">Имя:</label>
						<input type="text" name="comment_author" id="comment_author">
					</p>
				<?php endif; ?>
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

			<div id="loader"><span></span></div>
			<div id="error-comment"></div>

		</div>
	</div>
	<script src="<?= PATH . VIEW ?>js/jquery-1.9.0.min.js"></script>
	<script src="<?= PATH . VIEW ?>js/jquery-ui.min.js"></script>
	<script src="<?= PATH . VIEW ?>js/jquery.accordion.js"></script>
	<script src="<?= PATH . VIEW ?>js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function() {
			$(".category").dcAccordion();

			$(".open-form").click(function() {
				$( "#form-wrap" ).dialog('open');
				var parent = $(this).children().attr('data');
				$this = $(this);
				if (!parseInt(parent)) parent = 0;
				$('input[name="parent"]').val(parent);
			});

			$('#error-comment').dialog({
				autoOpen: false,
				width: 450,
				modal: true,
				title: 'сообщение об ошибке',
				resizable: false,
				draggable: false,
				show: {effect: 'blind', duration: 700},
				hide: {effect: 'explode', duration: 700},
			});

			$("#form-wrap").dialog({
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
								beforeSend: function() {
									$('#loader').fadeIn();
								},
								success: function(res) {
									var result = JSON.parse(res);

									if (result.answer == 'Комментарий добавлен') {
										// если комментарий добавлен
										var showComment = '<li class="new-comment" id="comment-' + result.id + '">' + result.code + '</li>';
										if (parent == 0) {
											// если это не ответ
											$('ul.comments').append(showComment);
										} else {
											// если это ответ
											// находим родителя LI
											var parentComment = $this.closest('li');
											// есть ли ответы?
											var childs = parentComment.children('ul');
											if (childs.length) {
												// если ответы есть
												childs.append(showComment);
											} else {
												// если ответов нет
												parentComment.append('<ul>' + showComment + '</ul>');
											}
										}
										$('#comment-' + result.id).delay(1000).show('shake', 1000);
									} else {
										// если комментарий не добавлен
										$('#error-comment').text(result.answer);
										$('#error-comment').delay(1000).queue(function() {
											$(this).dialog('open');
											$(this).dequeue();
										});
									}
								},
								error: function() {
									alert('Ошибка!');
								},
								complete: function() {
									$('#loader').delay(1000).fadeOut();
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
	<script src="<?= PATH . VIEW ?>js/workscripts.js"></script>
</body>
</html>