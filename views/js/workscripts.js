$(function() {
	$('#fogot-link').click(function() {
		$('#auth').fadeOut(300, function() {
			$('#fogot').fadeIn();
		});
		return false;
	});

	$('#auth-link').click(function() {
		$('#fogot').fadeOut(300, function() {
			$('#auth').fadeIn();
		});
	});
	return false;
});