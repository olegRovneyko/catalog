<li>
	<a href="<?= PATH ?>category/<?= $category['id'] ?>"><?= $category['title'] ?></a>
	<?php if (isset($category['childs']) && $category['childs']) : ?>
		<ul>
			<? echo categories_to_string($category['childs']); ?>
		</ul>
	<?php endif; ?>

</li>