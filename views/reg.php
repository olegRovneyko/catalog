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
			<div class="form">
				<form action="<?= PATH ?>reg" method="POST">
					<p>
						<label for="name_reg">имя:</label>
						<input type="text" name="name_reg" id="name_reg">
					</p>
					<p>
						<label for="email_reg">e-mail:</label>
						<input type="text" name="email_reg" id="email_reg">
						<span></span>
					</p>
					<p>
						<label for="login_reg">логин:</label>
						<input type="text" name="login_reg" id="login_reg">
						<span></span>
					</p>
					<p>
						<label for="password_reg">пароль:</label>
						<input type="password_reg" name="password" id="password_reg">
					</p>
					<p class="submit">
						<input type="submit" value="зарегистрироваться" name="reg">
					</p>
				</form>
			</div>
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
	<script src="<?= PATH ?>views/js/workscripts.js"></script>
</body>
</html>