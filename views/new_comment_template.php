<div class="comment-content<?php if ($comment['is_admin']) echo ' manager' ?>">
	<div class="comment-meta">
		<em>
			<strong>
				<span>
					<?= htmlspecialchars($comment['comment_author']) ?>
				</span>
			</strong>
			<?= $comment['created'] ?>
		</em>
	</div>

	<div>
		<p>
			<?= nl2br(htmlspecialchars($comment['comment_text'])) ?>
		</p>
	</div>
</div>