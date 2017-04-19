<?php

defined('CATALOG') or die('Access denied');

/**
 * получение комментариев
 */
function add_comment()
{
	global $connection;
	$comment_author = trim(mysqli_real_escape_string($connection, $_POST['commentAuthor']));
	$comment_text = trim(mysqli_real_escape_string($connection, $_POST['commentText']));
	$parent = (int)$_POST['parent'];
	$comment_product = (int)$_POST['productId'];

	// если нет Id товара
	if (!$comment_product) {
		$res = array('answer' => 'Неизвестный продукт');
		return json_encode($res);
	}

	// если не заполнены поля
	if (empty($comment_author) or empty($comment_text)) {
		$res = array('answer' => 'Все поля обязательны к заполнению');
		return json_encode($res);
	}

	$query = "INSERT INTO comments (comment_author, comment_text, parent, comment_product)
		VALUES ('$comment_author', '$comment_text', $parent, $comment_product)";
	mysqli_query($connection, $query);
	if (mysqli_affected_rows($connection) > 0) {
		$comment_id = mysqli_insert_id($connection);
		$comment_html = get_last_comment($comment_id);
		return $comment_html;
	} else {
		$res = array('answer' => 'Ошибка добавления комментария');
		return json_encode($res);
	}
}

/**
 * получение добавленного коментария
 * @param  [type] $comment_id [description]
 * @return [type]             [description]
 */
function get_last_comment($comment_id)
{
	global $connection;
	$query = 'SELECT * FROM comments WHERE comment_id = ' . $comment_id;
	$res = mysqli_query($connection, $query);
	$comment = mysqli_fetch_assoc($res);

	$comment_html = '<div class="comment-content">';

	$comment_html .= '<div class="comment-meta">';
	$comment_html .= '<em><strong><span>' . htmlspecialchars($comment['comment_author']) . '</span></strong>' . $comment['created'] . '</em>';
	$comment_html .= '</div>';

	$comment_html .= '<div>';
	$comment_html .= '<p>' . nl2br(htmlspecialchars($comment['comment_text'])) . '</p>';
	$comment_html .= '</div>';

	$comment_html .= '</div>';

	$res = array('answer' => 'Комментарий добавлен', 'code' => $comment_html, 'id' => $comment_id);

	return json_encode($res);
}