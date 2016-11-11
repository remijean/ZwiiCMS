// Affiche / Cache les options de l'image du fond
$("#themeBodyBackgroundImage").on("change", function() {
	if($(this).val()) {
		$("#themeBodyBackgroundImageOptions").fadeIn();
	}
	else {
		$("#themeBodyBackgroundImageOptions").fadeOut();
	}
}).trigger("change");