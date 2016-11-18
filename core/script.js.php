/**
 * Modifications non enregistrées du formulaire
 */
var formDOM = $("form");
formDOM.data("serialize", formDOM.serialize());
$(window).on("beforeunload", function() {
	if(formDOM.length && formDOM.serialize() !== formDOM.data("serialize")) {
		return "Attention, si vous continuez, vous allez perdre les modifications non enregistrées !";
	}
});
formDOM.submit(function() {
	$(window).off("beforeunload");
});

/**
 * Remonter en haut au clic sur le bouton
 */
var backToTopDOM = $("#backToTop");
backToTopDOM.on("click", function() {
	$("body, html").animate({scrollTop: 0}, "400");
});

/**
 * Affiche / Cache le bouton pour remonter en haut
 */
$(window).on("scroll", function() {
	if($(this).scrollTop() > 200) {
		backToTopDOM.fadeIn();
	}
	else {
		backToTopDOM.fadeOut();
	}
});

/**
 * Affiche / Cache les notifications
 */
if($("#notification").length) {
	setTimeout(function() {
		$("#notification").fadeOut();
	}, 4000);
}

/**
 * Affiche / Cache le menu en mode responsive
 */
var menuDOM = $(".menu");
$(".toggle").on("click", function() {
	menuDOM.slideToggle();
});
$(window).on("resize", function() {
	if($(window).width() > 768) {
		menuDOM.css("display", "");
	}
});

/**
 * Message sur l'utilisation des cookies
 */
if(<?php echo json_encode($this->getData(['config', 'cookieConsent'])); ?>) {
	if(document.cookie.indexOf("ZWII_COOKIE_CONSENT") === -1) {
		$("body").append(
			$("<div>").attr("id", "cookieConsent").append(
				$("<span>").text("En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies."),
				$("<span>")
					.attr("id", "cookieConsentConfirm")
					.text("OK")
					.on("click", function() {
						// Créé le cookie d'acceptation
						var expires = new Date();
						expires.setFullYear(expires.getFullYear() + 1);
						expires = "expires=" + expires.toUTCString();
						document.cookie = "ZWII_COOKIE_CONSENT=true;" + expires;
						// Ferme le message
						$(this).parents("#cookieConsent").fadeOut();
					})
			)
		);
	}
}

/**
 * Champs d'upload de fichiers
 */
// Callback de RFM
function responsive_filemanager_callback(fieldId){
	$("#" + fieldId).trigger("change");
	$(".lity-close").trigger("click");
}
// Mise à jour de l'affichage ds champs d'upload
$(".inputFileHidden").on("change", function() {
	var inputFileHiddenDOM = $(this);
	var fileName = inputFileHiddenDOM.val();
	if(fileName === "") {
		fileName = "<?php echo helper::translate('Choisissez un fichier'); ?>";
	}
	inputFileHiddenDOM.parent().find(".inputFileLabel").text(fileName);
}).trigger("change");
// Suppression du fichier contenu dans le champ
$(".inputFileDelete").on("click", function() {
	$(this).parent().find(".inputFileHidden").val("").trigger("change");
});

/**
 * Calcul de la luminance relative d'une couleur
 */
function relativeLuminanceW3C(rgba) {
	// Conversion en sRGB
	var RsRGB = rgba[0] / 255;
	var GsRGB = rgba[1] / 255;
	var BsRGB = rgba[2] / 255;
	// Ajout de la transparence
	var RsRGBA = rgba[3] * RsRGB + (1 - rgba[3]);
	var GsRGBA = rgba[3] * GsRGB + (1 - rgba[3]);
	var BsRGBA = rgba[3] * BsRGB + (1 - rgba[3]);
	// Calcul de la luminance
	var R = (RsRGBA <= .03928) ? RsRGBA / 12.92 : Math.pow((RsRGBA + .055) / 1.055, 2.4);
	var G = (GsRGBA <= .03928) ? GsRGBA / 12.92 : Math.pow((GsRGBA + .055) / 1.055, 2.4);
	var B = (BsRGBA <= .03928) ? BsRGBA / 12.92 : Math.pow((BsRGBA + .055) / 1.055, 2.4);
	return .2126 * R + .7152 * G + .0722 * B;
}

/**
 * Génère des variations d'une couleur
 */
function colorVariants(rgba) {
	rgba = rgba.match(/\(+(.*)\)/);
	rgba = rgba[1].split(", ");
	return {
		"normal": "rgba(" + rgba[0] + "," + rgba[1] + "," + rgba[2] + "," + rgba[3] + ")",
		"darken": "rgba(" + Math.max(0, rgba[0] - 20) + "," + Math.max(0, rgba[1] - 20) + "," + Math.max(0, rgba[2] - 20) + "," + rgba[3] + ")",
		"veryDarken": "rgba(" + Math.max(0, rgba[0] - 25) + "," + Math.max(0, rgba[1] - 25) + "," + Math.max(0, rgba[2] - 25) + "," + rgba[3] + ")",
		"text": relativeLuminanceW3C(rgba) > .22 ? "inherit" : "white"
	};
}