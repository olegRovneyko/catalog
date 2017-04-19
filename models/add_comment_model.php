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
		$res = array('answer' => 'Комментарий добавлен');
		return json_encode($res);
	} else {
		$res = array('answer' => 'Ошибка добавления комментария');
		return json_encode($res);
	}
}