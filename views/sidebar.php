<?php defined('CATALOG') or die('Access denied'); ?>

<div class="form auth">
<?php if (!isset($_SESSION['auth']['user'])) : ?>
	<form action="<?= PATH ?>login" method="POST">
		<p>
			<label for="login">логин:</label>
			<input type="text" name="login" id="login">
		</p>
		<p>
			<label for="password">пароль:</label>
			<input type="password" name="password" id="password">
		</p>
		<p class="submit">
			<input type="submit" value="войти" name="log_in">
		</p>
	</form>
	<p><a href="#">регистрация</a> | <a href="#">забыли пароль?</a></p>

	<?php if (isset($_SESSION['auth']['errors'])) : ?>
		<div class="error"><?= $_SESSION['auth']['errors'] ?></div>
		<?php unset($_SESSION['auth']); ?>
	<?php endif; ?>

<?php else : ?>
	<p>Добро пожаловать, <strong><?= htmlspecialchars($_SESSION['auth']['user']) ?></strong></p>
	<p><a href="<?= PATH ?>logout">выйти</a></p>
<?php endif; ?>
</div>

<ul class="category">
	<?php echo $categories_menu; ?>
</ul>