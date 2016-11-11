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
 * Champ d'upload de fichier
 */
$(".inputFile").find(":input").on("change", function() {
	var fileDOM = $(this);
	var fileName = fileDOM.val().split("\\").pop();
	if(fileName === "") {
		fileName = "<?php echo helper::translate('Choisissez un fichier'); ?>";
	}
	fileDOM.parents(".inputFile").find(".inputFileLabel").text(fileName);
});