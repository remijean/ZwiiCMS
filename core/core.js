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
 * @param test
 * @param state
 * @param autoDelete
 */
function addNotification(test, state, autoDelete){
	// Valeurs par défaut
	autoDelete = (autoDelete === undefined) ? true : autoDelete;
	state = state ? "success" : "error";
	// Crée le container des notifications
	if($("#notifications").length === 0) {
		$("<div>").attr("id", "notifications").appendTo("body");
	}
	// Crée la notification
	var notificationId = Math.random().toString(36).substr(2, 5);
	$("<div>")
		.attr("id", notificationId + "Notification")
		.text(test)
		.addClass(state)
		.appendTo("#notifications")
		.fadeIn();
	// Auto-suppression de la notification
	if(autoDelete) {
		setTimeout(function() {
			deleteNotification(notificationId);
		}, 6000);
	}
}

/**
 * Supprime une notification
 * @param id
 */
function deleteNotification(id) {
	$("#" + id + "Notification").fadeOut(function() {
		$(this).remove();
	});
}

/**
 * Ajoute un message de confirmation
 */
function addConfirm(test, callback) {
	// Crée le message de confirmation
	var id = Math.random().toString(36).substr(2, 5);
	$("<div>")
		.attr("id", id + "Confirm")
		.addClass("lightboxOverlay")
		.css("z-index", 100 + $(".lightbox").length)
		.append(
			$("<div>").addClass("lightbox").append(
				$("<div>").addClass("row").append(
					$("<div>").addClass("col12").text(test)
				),
				$("<div>").addClass("row").append(
					$("<div>").addClass("col3 offset6").append(
						$("<button>")
							.text("Annuler")
							.on("click", function() {
								deleteConfirm(id);
							})
					),
					$("<div>").addClass("col3").append(
						$("<button>")
							.text("Confirmer")
							.on("click", function() {
								deleteConfirm(id);
								callback();
							})
					)
				)
			)
		)
		.appendTo("body")
		.fadeIn();
	return false;
}

/**
 * Supprime un message de confirmation
 * @param id
 */
function deleteConfirm(id) {
	$("#" + id + "Confirm").fadeOut(function() {
		$(this).remove();
	});
}

/**
 * Ajoute le panneau
 */
function addPanel(effect) {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: "?user/panel",
		success: function(output) {
			if(output.view) {
				var panel = $("<div>").attr("id", "panel").html(output.view).prependTo("body");
				effect ? panel.slideDown() : panel.show();
				$("#loginLink").hide();
			}
		},
		error: function(output) {
			addNotification("Panneau d'administration incorrect", false);
			console.log(output);
		}
	});
}
addPanel();

/**
 * Supprime le panneau
 */
function deletePanel() {
	$("#panel").slideUp(function() {
		$(this).remove();
		$("#loginLink").show();
	});
}

/**
 * Routage des modules
 * @param data
 */
function router(data) {
	// Hash par défaut
	var hash = $(location).attr("hash").substr(1);
	if(hash === "") {
		hash = homePageId;
	}
	// Requête
	$.ajax({
		data: data,
		dataType: "json",
		type: "POST",
		url: "?" + hash,
		success: function(output) {
			if(output.callable) {
				// Notification
				if(output.notification) {
					addNotification(output.notification, output.state);
				}
				// Vue
				if(output.view) {
					$("#content").html(output.view);
				}
				// Événement
				if(output.event) {
					$("#content").append(output.event);
				}
				// Redirection
				if(output.hash !== null) {
					window.location.hash = output.hash;
				}
				// Surbrillance de la page dans le menu
				$("nav a.target").removeClass("target");
				$("nav a[data-id='" + hash + "']").addClass("target");
				// Active les palettes de couleurs
				$(".colorPicker").colorPicker();
			}
			else {
				addNotification("Données en sortie bloquées", false);
				console.log(output);
			}
		},
		error: function(output) {
			addNotification("Erreur fatale", false);
			console.log(output);
		}
	});
}

/**
 * Actions au changement de hash
 */
$(window).on("hashchange", function() {
	// Routage
	router();
	// Actualise l'url du lien de connexion en fonction du hash
	$("#loginLink").find("a").attr("href", "#user/login/" +  $(location).attr("hash").substr(1));
}).trigger("hashchange");

/**
 * Routage lors de la soumission de formulaire
 */
$(document).on("click", "button[type=submit]", function() {
	$(this).prop("disabled", true).html("<span class='zwiico-spin animate-spin'></span>");
	router($(this).parents("form").serialize());
	return false;
});