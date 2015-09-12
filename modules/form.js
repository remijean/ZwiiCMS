/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2015, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Copie du champ type
 */
var copy = $('#copy').html();

/**
 * Crée un nouveau champ à partir du champ type
 */
$('#add').on('click', function() {
	// Colle le nouveau champ
	$('#inputs')
		.append($(copy).hide())
		.find('.row').last().slideDown();
	// Check les types
	$('.type').trigger('change');
	// Actualise les positions
	position();
});

/**
 * Actions sur les champs
 */
$('#inputs')
	// Tri entre les champs
	.sortable({
		axis: 'y',
		containment: '#inputs',
		retard: 150,
		handle: '.move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		tolerance: 'pointer',
		start: function(e, ui) {
			// Calcul la hauteur du placeholder
			ui.placeholder.height(ui.helper.outerHeight());
		},
		update: function() {
			// Actualise les positions
			position();
		}
	})
	// Suppression du champ
	.on('click', '.delete', function() {
		// Cache le champ
		$(this).parents('.row').slideUp(400, function() {
			// Supprime le champ
			$(this).remove();
			// Actualise les positions
			position();
		});
	})
	// Affiche/cache le champ "Valeurs" en fonction du type de champ
	.on('change', '.type', function() {
		var typeCol = $(this).parent();
		var valuesCol = $(this).parents('.row').find('.values').parent();
		typeCol.removeClass();
		if($(this).val() === 'select') {
			typeCol.addClass('col2');
			valuesCol.show();
		}
		else {
			typeCol.addClass('col5');
			valuesCol.hide();
		}
	});

/**
 * Simule un changement de type au chargement de la page
 */
$('.type').trigger('change');

/**
 * Calcul des positions
 */
function position() {
	$('#inputs').find('.position').each(function(i) {
		$(this).val(i + 1);
	});
}