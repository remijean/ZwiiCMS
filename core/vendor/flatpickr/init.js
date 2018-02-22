/**
 * Initialisation du sélecteur de date
 */
$(function() {
	// Langue
	var locale = "en";
	var format = "m/d/Y H:i";
	if(language === "fr_FR") {
		locale = "fr";
		format = "d/m/Y H:i";
	}
	// Initialisation
	$(".datepicker").flatpickr({
		altInput: true,
		altFormat: format,
		enableTime: true,
		time_24hr: true,
		locale: locale,
		dateFormat: "Y-m-d H:i:s"
	});
});
