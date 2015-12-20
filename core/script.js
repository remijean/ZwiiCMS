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
 * Cache la notification après 4 secondes
 */
setTimeout(function() {
	$('#notification').slideUp();
}, 4000);

/**
 * Modifications non enregistrées du formulaire
 */
var form = $('form');
form.data('serialize', form.serialize());
$(window).on('beforeunload', function() {
	if(form.length && form.serialize() !== form.data('serialize')) {
		return 'Attention, si vous continuez, vous allez perdre les modifications non enregistrées !';
	}
});
form.submit(function() {
	$(window).off('beforeunload');
});

/**
 * Affiche/cache le menu en mode responsive
 */
var menu = $('#menu');
$('#toggle').on('click', function() {
	menu.slideToggle();
});
$(window).on('resize', function() {
	if($(window).width() > 768) {
		menu.css('display', '');
	}
});

/**
 * Enregistrement en AJAX du module des page
 */
$('#module').on('change', function() {
	var newModule = $('#module').val();
	var admin = $('#admin');
	var ok = true;
	if($('#oldModule').val() != '') {
		ok = confirm('Si vous confirmez, les données du module précédent seront supprimées !');
	}
	if(ok) {
		$.ajax({
			type: "POST",
			url: '?ajax/' + $("#key").val(),
			data: {module: newModule},
			success: function() {
				$('#oldModule').val(newModule);
				if(newModule == '') {
					admin.addClass('disabled');
				}
				else {
					admin.removeClass('disabled');
					admin.attr('target', '_blank')
				}
			},
			error: function() {
				alert('Impossible d\'enregistrer le module !');
				admin.addClass('disabled');
			}
		});
	}
});

/**
 * Charge l'éditeur de texte
 */
$('.editor').trumbowyg();

/**
 * Sélecteur de couleur
 */
$('.colorPicker div').on('click', function() {
	var color = $(this);
	var colorPicker = color.parents('.colorPicker');
	// Sélectionne la couleur
	colorPicker.find('.selected').removeClass('selected');
	$(this).addClass('selected');
	// Ajoute la couleur sélectionnée dans l'input caché
	colorPicker.find('input[type=hidden]').val(color.data('color')).trigger('change');
});

/**
 * Aperçu de la personnalisation en direct
 */
$('#theme').on('change', function() {
	var body = $('body');
	// Supprime les anciennes classes
	body.removeClass();
	// Ajoute les nouvelles classes
	$(this).find('input').each(function() {
		var input = $(this);
		// Cas spécifique pour les checkbox
		if(input.is(':checkbox')) {
			if(input.is(':checked')) {
				body.addClass(input.attr('name').substring(5).toLowerCase().replace('[]', ''));
			}
		}
		// Cas simple
		else {
			body.addClass(input.attr('id').substring(5).toLowerCase() + input.val());
		}
	});
});