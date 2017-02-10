core.confirm(
	"<?php echo helper::translate('Souhaitez-vous accéder à l\'interface de modification de la page ? En cas de refus, vous serez redirigé vers l\'URL saisie dans le module de redirection.'); ?>",
	function() {
		$(location).attr("href", "<?php echo helper::baseUrl(); ?>page/edit/<?php echo $this->getUrl(0); ?>");
	},
	function() {
		$(location).attr("href", "<?php echo helper::baseUrl() . $this->getUrl(); ?>/force");
	}
);