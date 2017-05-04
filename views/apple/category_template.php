<?php defined('CATALOG') or die('Access denied'); ?>

<li>
	<a href="<?= PATH ?>category/<?= $data['id'] ?>"><?= $data['title'] ?></a>
	<?php if (isset($data['childs']) && $data['childs']) : ?>
		<ul>
			<? echo array_to_string($data['childs']); ?>
		</ul>
	<?php endif; ?>

</li>