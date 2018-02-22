/**
 * Initialisation de Tippy
 */
$(document).ready(function() {
	// Tooltip des aides
	tippy(".helpButton", {
		arrow: true,
		placement: "right"
	});
	// Tooltip des attributs title
	tippy("[title]", {
		arrow: true
	});
});