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
			<h3>Регистрация</h3>
			<?php if (isset($_SESSION['reg']['success'])) : ?>
				<div class="ok"><?= $_SESSION['reg']['success']; ?></div>
			<?php elseif (!isset($_SESSION['auth']['user'])) : ?>
				<div class="form">
					<form action="<?= PATH ?>reg" method="POST">
						<p>
							<label for="name_reg">имя:</label>
							<input type="text" name="name_reg" id="name_reg">
						</p>
						<p>
							<label for="email_reg">e-mail:</label>
							<input type="text" class="access" name="email_reg" data-field="email" id="email_reg">
							<span></span>
						</p>
						<p>
							<label for="login_reg">логин:</label>
							<input type="text" class="access" name="login_reg" data-field="login" id="login_reg">
							<span></span>
						</p>
						<p>
							<label for="password_reg">пароль:</label>
							<input type="password_reg" name="password_reg" id="password_reg">
						</p>
						<p class="submit">
							<input type="submit" value="зарегистрироваться" name="reg">
						</p>
					</form>
				</div>
				<br>
				<?php if (isset($_SESSION['reg']['errors'])) : ?>
					<div class="error">
						<?= $_SESSION['reg']['errors'];	?>
					</div>
				<?php endif; ?>
			<?php endif; unset($_SESSION['reg']); ?>
		</div>
	</div>
	<script src="<?= PATH ?>views/js/jquery-1.9.0.min.js"></script>
	<script src="<?= PATH ?>views/js/jquery.accordion.js"></script>
	<script src="<?= PATH ?>views/js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function() {
			$(".category").dcAccordion();

			$("[data-field]").change(function() {
				var $this = $(this);
				var val = $.trim($this.val());
				var dataField = $this.attr('data-field');
				var span = $this.next();

				if (val == '') {
					span.removeClass().addClass('reg_cross');
				} else {
					span.removeClass().addClass('reg_loader');
					$.ajax({
						url: '<?= PATH ?>reg',
						type: 'POST',
						data: {val: val, dataField: dataField},
						success: function(res) {
							if (res === 'no') {
								span.removeClass().addClass('reg_cross');
							} else {
								span.removeClass().addClass('reg_check');
							}
						}
					});
				}

				
			});
		});
	</script>
	<script src="<?= PATH ?>views/js/workscripts.js"></script>
</body>
</html>