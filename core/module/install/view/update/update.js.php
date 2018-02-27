/**
 * Exécution des différentes étapes de mise à jour
 */
function step(i, data) {
	// Affiche le texte de progression
	$(".installUpdateProgressText").hide();
	$(".installUpdateProgressText[data-id=" + i + "]").show();
	// Requête ajax
	$.ajax({
		type: "POST",
		url: "<?php echo helper::baseUrl(); ?>install/steps",
		data: {
			step: i,
			data: data
		},
		// Succès de la requête
		success: function(result) {
			setTimeout(function() {
				// Succès
				if(result.success === true) {
					// Fin de la mise à jour
					if(i === 4) {
						// Affiche le message de succès
						$("#installUpdateSuccess").show();
						// Déverrouille le bouton "Terminer"
						$("#installUpdateEnd").removeClass("disabled");
						// Cache le texte de progression
						$("#installUpdateProgress").hide();
					}
					// Prochaine étape
					else {
						step(i + 1, result.data);
					}
				}
				// Échec
				else {
					// Affiche le message d'erreur
					$("#installUpdateErrorStep").text(i);
					$("#installUpdateError").show();
					// Déverrouille le bouton "Terminer"
					$("#installUpdateEnd").removeClass("disabled");
					// Cache le texte de progression
					$("#installUpdateProgress").hide();
					// Affiche le résultat dans la console
					console.error(result);
				}
			}, 2000);
		},
		// Échec de la requête
		error: function(xhr) {
			// Affiche le message d'erreur
			$("#installUpdateErrorStep").text(0);
			$("#installUpdateError").show();
			// Déverrouille le bouton "Terminer"
			$("#installUpdateEnd").removeClass("disabled");
			// Cache le texte de progression
			$("#installUpdateProgress").hide();
			// Affiche l'erreur dans la console
			console.error(xhr);
		}
	});
}
$(window).on("load", step(1, null));
