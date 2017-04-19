<?php defined('CATALOG') or die('Access denied'); ?>

<li>
	<div class="comment-content<?php if ($data['is_admin']) echo ' manager' ?>">
		<div class="comment-meta">
			<em><strong><span><?= htmlspecialchars($data['comment_author']) ?></span></strong></em>
			<?= $data['created'] ?>
		</div>
		<div>
			<p><?= nl2br(htmlspecialchars($data['comment_text'])) ?></p>
			<p class="open-form">
				<a data="<?= $data['comment_id'] ?>" class="reply">Ответить</a>
			</p>
		</div>
	</div>
	<?php if (isset($data['childs']) && $data['childs']) : ?>
		<ul>
			<? echo array_to_string($data['childs'], 'comments_template.php'); ?>
		</ul>
	<?php endif; ?>

</li>