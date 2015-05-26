$(document).ready(function() {
	$('#print').click(function() {
		window.print();
		return false;
	});
	$('#close').click(function() {
		window.close();
		return false;
	});
});