<?php defined('CATALOG') or die('Access denied'); ?>

<ul class="wrap">
	<?php foreach ($pages as $link => $item_page) : ?>
		<?php if ($link == 'index') : ?>
			<li><a href="<?php echo PATH ?>"><?= $item_page ?></a></li>
		<?php else : ?>
			<li><a href="<?php echo PATH . 'page/' . $link ?>"><?= $item_page ?></a></li>
	<?php endif; ?>
	<?php endforeach; ?>
</ul>