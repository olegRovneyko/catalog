<?php defined('CATALOG') or die('Access denied'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= strip_tags($breadcrumbs) ?></title>
	<link rel="stylesheet" href="<?= PATH . VIEW ?>css/style.css">
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
			<h3>Восстановление пароля</h3>
			<?php if (isset($_SESSION['forgot']['change_error'])) : ?>
				<div class="error"><?= $_SESSION['forgot']['change_error'] ?></div>
				<?php unset($_SESSION['forgot']) ?>
				<div class="auth form">
					<form action="<?= PATH ?>forgot" method="POST">
						<p>
							<label for="new_password">Введите новый пароль: </label>
							<input type="text" name="new_password" id="new_password">
						</p>
						<input type="hidden" name="hash" value="<?= $_GET['forgot'] ?>">
						<p class="submit">
							<input type="submit" value="Изменить пароль" name="cange_pass">
						</p>
					</form>
				</div>
			<?php elseif (isset($_SESSION['forgot']['ok'])) : ?>
				<div class="ok"><?= $_SESSION['forgot']['ok'] ?></div>
				<?php unset($_SESSION['forgot']['ok']) ?>
			<?php elseif (isset($_SESSION['forgot']['errors'])) : ?>
				<div class="error"><?= $_SESSION['forgot']['errors'] ?></div>
				<?php unset($_SESSION['forgot']['errors']) ?>
			<?php else : ?>
				<div class="auth form">
					<form action="<?= PATH ?>forgot" method="POST">
						<p>
							<label for="new_password">Введите новый пароль: </label>
							<input type="text" name="new_password" id="new_password">
						</p>
						<input type="hidden" name="hash" value="<?= $_GET['forgot'] ?>">
						<p class="submit">
							<input type="submit" value="Изменить пароль" name="change_pass">
						</p>
					</form>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<script src="<?= PATH . VIEW ?>js/jquery-1.9.0.min.js"></script>
	<script src="<?= PATH . VIEW ?>js/jquery.accordion.js"></script>
	<script src="<?= PATH . VIEW ?>js/jquery.cookie.js"></script>
	<script>
		$(document).ready(function() {
			$(".category").dcAccordion();
		});
	</script>
	<script src="<?= PATH .VIEW ?>js/workscripts.js"></script>
</body>
</html>