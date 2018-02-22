/**
 * Initialisation de la palette de couleurs
 */
$(function() {
	var colorPickerDOM = $(".colorPicker");
	colorPickerDOM.colorPicker({
		renderCallback: function(element, toggled) {
			// Ouverture
			if(toggled === true) {
				// Rien
			}
			// Fermeture
			else if(toggled === false) {
				// Rien
			}
			// Pendant le choix
			else {
				// Enclenche l'événement change pour l'aperçu en direct
				$(element).trigger("change");
			}
		},
		dark: "inherit",
		light: "white",
		forceAlpha: true
	})
});