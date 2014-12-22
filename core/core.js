/**
 * Cache la notification après 4 secondes
 */
$(function() {
	var notification = $("div#notification");
	if(notification.length) {
		setTimeout(function() {
			notification.slideUp();
		}, 4000);
	}
});

$("select#list").change(function() {
	$(location).attr("href", $(this).val());
});