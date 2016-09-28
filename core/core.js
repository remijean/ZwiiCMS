/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <moi@remijean.fr>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Ajoute une notification
 * @param notificationText
 * @param notificationState
 * @param notificationAutoDelete
 */
function addNotification(notificationText, notificationState, notificationAutoDelete){
	// Valeurs par défaut
	notificationAutoDelete = (notificationAutoDelete === undefined) ? true : notificationAutoDelete;
	notificationState = notificationState ? "success" : "error";
	// Crée la notification
	var notificationId = Math.random().toString(36).substr(2, 5);
	$("<div>")
		.attr("id", notificationId + "Notification")
		.text(notificationText)
		.addClass(notificationState)
		.appendTo("#notifications")
		.fadeIn();
	// Auto-suppression de la notification
	if(notificationAutoDelete) {
		setTimeout(function() {
			deleteNotification(notificationId);
		}, 6000);
	}
}

/**
 * Supprime une notification
 * @param notificationId
 */
function deleteNotification(notificationId) {
	$("#" + notificationId + "Notification").fadeOut(function() {
		$(this).remove();
	});
}

/**
 * Crée un message de confirmation
 */
function confirm(confirmText, confirmCallback) {
	// Crée le message de confirmation
	var confirmId = Math.random().toString(36).substr(2, 5);
	$("<div>")
		.attr("id", confirmId + "Confirm")
		.addClass("lightboxOverlay")
		.css("z-index", 100 + $(".lightbox").length)
		.append(
			$("<div>").addClass("lightbox").append(
				$("<div>").addClass("row").append(
					$("<div>").addClass("col12").text(confirmText)
				),
				$("<div>").addClass("row").append(
					$("<div>").addClass("col3 offset6").append(
						$("<button>")
							.text("Annuler")
							.on("click", function() {
								$("#" + confirmId + "Confirm").remove();
							})
					),
					$("<div>").addClass("col3").append(
						$("<button>")
							.text("Confirmer")
							.on("click", function() {
								$("#" + confirmId + "Confirm").remove();
								confirmCallback();
							})
					)
				)
			)
		)
		.appendTo("body");
	return false;
}

/**
 * Routage des modules
 * @param data
 */
function router(data) {
	// Hash par défaut
	var hash = window.location.hash.substr(1);
	if(hash === '') {
		hash = homePageId;
	}
	// Requête
	$.ajax({
		data: data,
		dataType: "json",
		type: "POST",
		url: "?" + hash,
		success: function(output) {
			if(output.state === undefined) {
				addNotification("État de sortie incorrect", false);
				console.log(output);
			}
			else {
				// Données en sortie du module
				if(output.notification) {
					addNotification(output.notification, output.state);
				}
				if(output.view) {
					$("#content").html(output.view);
				}
				if(output.event) {
					$("#content").append(output.event);
				}
				if(output.hash !== null) {
					window.location.hash = output.hash;
				}
				// Affiche/Cache les liens d'authentification
				$("#loginLink").attr("href", "#user/login/" + hash);
				$("#logoutLink").attr("href", "#user/logout/" + hash);
				// Active les palettes de couleurs
				$(".colorPicker").colorPicker();
			}
		},
		error: function(output) {
			addNotification("Erreur fatale.", false);
			console.log(output);
		}
	});
}

/**
 * Routage lors du changement de hash
 */
$(window).on("hashchange", function() {
	router();
}).trigger("hashchange");

/**
 * Routage lors de la soumission de formulaire
 */
$(document).on("click", "button[type=submit]", function() {
	router($(this).parents("form").serialize());
	return false;
});

/**
 * Confirmation avant déconnexion
 */
$(document).on("click", "#logoutLink", function() {
	var logoutLink = $(this);
	return confirm("Êtes-vous sûr de vouloir vous déconnecter ?", function() {
		$(location).attr("href", logoutLink.attr("href"));
	});
});