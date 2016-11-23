// Enregistrement du module de la page en AJAX
$("#pageModuleId").on("change", function() {
	var moduleId = $(this).val();
	var moduleIdOldDOM = $("#pageModuleIdOld");
	var moduleConfigDOM = $("#pageModuleConfig");
	var confirm = true;
	if(moduleIdOldDOM.val() !== "") {
		confirm = confirm("<?php echo helper::translate('Si vous confirmez, les données du module précédent seront supprimées !'); ?>");
	}
	if(confirm) {
		$.ajax({
			type: "POST",
			url: "<?php echo helper::baseUrl(); ?> . 'page/modulesave/" + <?php echo $this->getUrl(2); ?>,
			data: {moduleId: moduleId},
			success: function() {
				moduleIdOldDOM.val(moduleId);
				if(moduleId === "") {
					moduleConfigDOM.addClass("disabled");
				}
				else {
					moduleConfigDOM
						.removeClass("disabled")
						.attr("target", "_blank");
				}
			},
			error: function() {
				alert("<?php echo helper::translate('Impossible d\'enregistrer le module !'); ?>");
				moduleConfigDOM.addClass("disabled");
			}
		});
	}
});