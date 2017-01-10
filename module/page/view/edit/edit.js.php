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

/**
 * Confirmation de suppression
 */
$("#pageEditDelete").on("click", function() {
	return confirm("<?php echo helper::translate('Êtes-vous sûr de vouloir supprimer cette page ?'); ?>");
});

/**
 * Enregistrement du module de la page en AJAX
 */
$("#pageModuleId").on("change", function() {
	var moduleId = $(this).val();
	var moduleIdOldDOM = $("#pageEditModuleIdOld");
	var moduleConfigDOM = $("#pageEditModuleConfig");
	var confirm = true;
	if(moduleIdOldDOM.val() !== "") {
		confirm = confirm("<?php echo helper::translate('Si vous confirmez, les données du module précédent seront supprimées !'); ?>");
	}
	if(confirm) {
		$.ajax({
			type: "POST",
			url: "<?php echo helper::baseUrl(); ?> . 'page/modulesave/" + <?php echo $this->getUrl(2); ?>,
			data: {moduleId: moduleId},
			success: function() {
				moduleIdOldDOM.val(moduleId);
				if(moduleId === "") {
					moduleConfigDOM.addClass("disabled");
				}
				else {
					moduleConfigDOM
						.removeClass("disabled")
						.attr("target", "_blank");
				}
			},
			error: function() {
				alert("<?php echo helper::translate('Impossible d\'enregistrer le module !'); ?>");
				moduleConfigDOM.addClass("disabled");
			}
		});
	}
});

/**
 * Affiche les pages en fonction de la page parent dans le choix de la position
 */
var hierarchy = <?php echo json_encode($this->getHierarchy()); ?>;
var pages = <?php echo json_encode($this->getData(['page'])); ?>;
$("#pageEditParentPageId").on("change", function() {
	var positionDOM = $("#pageEditPosition");
	positionDOM.empty().append(
		$("<option>").val(0).text("<?php echo helper::translate('Ne pas afficher'); ?>"),
		$("<option>").val(1).text("<?php echo helper::translate('Au début'); ?>")
	);
	var parentSelected = $(this).val();
	var positionSelected = 0;
	var positionPrevious = 1;
	// Aucune page parent selectionnée
	if(parentSelected === "") {
		// Liste des pages sans parents
		for(var key in hierarchy) {
			if(hierarchy.hasOwnProperty(key)) {
				// Sélectionne la page avant si il s'agit de la page courante
				if(key === "<?php echo $this->getUrl(2); ?>") {
					positionSelected = positionPrevious;
				}
				// Sinon ajoute la page à la liste
				else {
					// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
					positionPrevious++;
					// Ajout à la liste
					positionDOM.append(
						$("<option>").val(positionPrevious).text("<?php echo helper::translate('Après'); ?> \"" + pages[key].title + "\"")
					);
				}
			}
		}
	}
	// Un page parent est selectionnée
	else {
		// Liste des pages enfants de la page parent
		for(var i = 0; i < hierarchy[parentSelected].length; i++) {
			// Pour page courante sélectionne la page précédente (pas de - 1 à positionSelected à cause des options par défaut)
			if(hierarchy[parentSelected][i] === "<?php echo $this->getUrl(2); ?>") {
				positionSelected = positionPrevious;
			}
			// Sinon ajoute la page à la liste
			else {
				// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
				positionPrevious++;
				// Ajout à la liste
				positionDOM.append(
					$("<option>").val(positionPrevious).text("<?php echo helper::translate('Après'); ?> \"" + pages[hierarchy[parentSelected][i]].title + "\"")
				);
			}
		}
	}
	// Sélectionne la bonne position
	positionDOM.val(positionSelected);
}).trigger("change");