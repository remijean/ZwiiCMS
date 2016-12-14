// Confirmation de suppression
$(".userDelete").on("click", function() {
	return confirm("<?php echo helper::translate('Êtes-vous sûr de vouloir supprimer cet utilisateur ?'); ?>");
});