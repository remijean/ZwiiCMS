/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2017, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

var core = {};

/**
 * Crée un message d'alerte
 */
core.alert = function(text) {
	var lightbox = lity(function($) {
		return $("<div>")
			.addClass("lightbox")
			.append(
				$("<span>").text(text),
				$("<div>")
					.addClass("lightboxButtons")
					.append(
						$("<a>")
							.addClass("button")
							.text("Ok")
							.on("click", function() {
								lightbox.close();
							})
					)
			)
	}(jQuery));
	// Validation de la lightbox avec le bouton entrée
	$(document).on("keyup", function(event) {
		if(event.keyCode === 13) {
			lightbox.close();
		}
	});
	return false;
};

/**
 * Génère des variations d'une couleur
 */
core.colorVariants = function(rgba) {
	rgba = rgba.match(/\(+(.*)\)/);
	rgba = rgba[1].split(", ");
	return {
		"normal": "rgba(" + rgba[0] + "," + rgba[1] + "," + rgba[2] + "," + rgba[3] + ")",
		"darken": "rgba(" + Math.max(0, rgba[0] - 15) + "," + Math.max(0, rgba[1] - 15) + "," + Math.max(0, rgba[2] - 15) + "," + rgba[3] + ")",
		"veryDarken": "rgba(" + Math.max(0, rgba[0] - 20) + "," + Math.max(0, rgba[1] - 20) + "," + Math.max(0, rgba[2] - 20) + "," + rgba[3] + ")",
		"text": core.relativeLuminanceW3C(rgba) > .22 ? "inherit" : "white"
	};
};

/**
 * Crée un message de confirmation
 */
core.confirm = function(text, yesCallback, noCallback) {
	var lightbox = lity(function($) {
		return $("<div>")
			.addClass("lightbox")
			.append(
				$("<span>").text(text),
				$("<div>")
					.addClass("lightboxButtons")
					.append(
						$("<a>")
							.addClass("button grey")
							.text("Non")
							.on("click", function() {
								lightbox.options('button', true);
								lightbox.close();
								if(typeof noCallback !== "undefined") {
									noCallback();
								}
						}),
						$("<a>")
							.addClass("button")
							.text("Oui")
							.on("click", function() {
								lightbox.options('button', true);
								lightbox.close();
								if(typeof yesCallback !== "undefined") {
									yesCallback();
								}
						})
					)
			)
	}(jQuery));
	// Callback lors d'un clic sur le fond et sur la croix de fermeture
	lightbox.options('button', false);
	$(document).on('lity:close', function(event, instance) {
		if(
			instance.options('button') === false
			&& typeof noCallback !== "undefined"
		) {
			noCallback();
		}
	});
	// Validation de la lightbox avec le bouton entrée
	$(document).on("keyup", function(event) {
		if(event.keyCode === 13) {
			lightbox.close();
			if(typeof yesCallback !== "undefined") {
				yesCallback();
			}
		}
	});
	return false;
};

/**
 * Scripts à exécuter en dernier
 */
core.end = function() {
	/**
	 * Modifications non enregistrées du formulaire
	 */
	var keysNb = 0;
	var formDOM = $("form");
	formDOM.data("serialize", formDOM.serialize());
	$(document).on("keydown", function() {
		keysNb++;
	});
	$(window).on("beforeunload", function() {
		if(formDOM.length && formDOM.serialize() !== formDOM.data("serialize") && keysNb > 2) {
			return "Les modifications que vous avez apportées ne seront peut-être pas enregistrées.";
		}
	});
	formDOM.submit(function() {
		$(window).off("beforeunload");
	});
};
$(function() {
	core.end();
});

/**
 * Ajoute une notice
 */
core.noticeAdd = function(id, notice) {
	$("#" + id + "Notice").text(notice).removeClass("displayNone");
	$("#" + id).addClass("notice");
};

/**
 * Supprime une notice
 */
core.noticeRemove = function(id) {
	$("#" + id + "Notice").text("").addClass("displayNone");
	$("#" + id).removeClass("notice");
};

/**
 * Scripts à exécuter en premier
 */
core.start = function() {
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
	 * Cache les notifications
	 */
	if($("#notification").length) {
		setTimeout(function() {
			$("#notification").fadeOut();
		}, 5000);
	}
	$("#notificationClose").on("click", function() {
		$("#notification").fadeOut();
	});
	/**
	 * Affiche / Cache le menu en mode responsive
	 */
	var menuDOM = $("#menu");
	$("#toggle").on("click", function() {
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
	 * Choix de page dans la barre de membre
	 */
	$("#barSelectPage").on("change", function() {
		var pageUrl = $(this).val();
		if(pageUrl) {
			$(location).attr("href", pageUrl);
		}
	});
	/**
	 * Champs d'upload de fichiers
	 */
	// Mise à jour de l'affichage ds champs d'upload
	$(".inputFileHidden").on("change", function() {
		var inputFileHiddenDOM = $(this);
		var fileName = inputFileHiddenDOM.val();
		if(fileName === "") {
			fileName = "Choisissez un fichier";
			$(".inputFileDelete").addClass("disabled");
		}
		else {
			$(".inputFileDelete").removeClass("disabled");
		}
		inputFileHiddenDOM.parent().find(".inputFileLabel").text(fileName);
	}).trigger("change");
	// Suppression du fichier contenu dans le champ
	$(".inputFileDelete").on("click", function() {
		$(this).parents(".inputWrapper").find(".inputFileHidden").val("").trigger("change");
	});
	// Confirmation déconnexion
	$("#barLogout").on("click", function() {
		return core.confirm("Se déconnecter ?", function() {
			$(location).attr("href", $("#barLogout").attr("href"));
		});
	});
	/**
	 * Bloque la multi-soumission des boutons
	 */
	$("form").on("submit", function() {
		$(this).find(".uniqueSubmission")
			.addClass("disabled")
			.prop("disabled", true)
			.empty()
			.append(
				$("<span>").addClass("zwiico-spin animate-spin")
			)
	});
	/**
	 * Check adresse email
	 */
	$("[type=email]").on("change", function() {
		var _this = $(this);
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		if(pattern.test(_this.val())) {
			core.noticeRemove(_this.attr("id"));
		}
		else {
			core.noticeAdd(_this.attr("id"), "Format incorrect");
		}
	});
};
core.start();

/**
 * Calcul de la luminance relative d'une couleur
 */
core.relativeLuminanceW3C = function(rgba) {
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
};