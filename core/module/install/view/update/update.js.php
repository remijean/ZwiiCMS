/**
 * Téléchargement de la mise à jour
 */
$.ajax({
	type: "POST",
	url: "<?php echo helper::baseUrl(); ?>install/download",
	success: function(result) {
		$("#installUpdateEnd").removeClass("disabled");
		$("#installUpdateProgress").hide();
		if(result === true) {
			$("#installUpdateSuccess").show();
		}
		else {
			$("#installUpdateError").show();
			console.error(result);
		}
	}
});