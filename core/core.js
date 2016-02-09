/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Scripts reliés au coeur
 */

/* Cache la notification après 4 secondes */
setTimeout(function() {
	$('#notification').slideUp();
}, 4000);

/* Modifications non enregistrées du formulaire */
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

/* Affiche/cache le menu en mode responsive */
var menu = $('#menu');
$('#toggle').on('click', function() {
	menu.slideToggle();
});
$(window).on('resize', function() {
	if($(window).width() > 768) {
		menu.css('display', '');
	}
});

/* Enregistrement en AJAX du module des page */
$('#module').on('change', function() {
	var newModule = $('#module').val();
	var admin = $('#admin');
	var ok = true;
	if($('#oldModule').val() != '') {
		ok = confirm('Si vous confirmez, les données du module précédent seront supprimées !');
	}
	if(ok) {
		$.ajax({
			type: 'POST',
			url: baseUrl + 'save/' + $('#key').val(),
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

/* Charge l'éditeur de texte */
$.extend(true, $.trumbowyg.upload, {
	serverPath: baseUrl + 'upload',
	fileFieldName: 'file',
	urlPropertyName: 'link'
});
$('.editor').trumbowyg({
	btnsDef: {
		image: {
			dropdown: ['insertImage', 'upload'],
			ico: 'insertImage'
		}
	},
	btns: [
		'viewHTML',
		'|', 'formatting',
		'|', 'btnGrp-design',
		'|', 'link',
		'|', 'image',
		'|', 'btnGrp-justify',
		'|', 'btnGrp-lists',
		'|', 'horizontalRule'
	]
});

/* Aperçu de la personnalisation en direct */
$('#theme').on('change', function() {
	var body = $('body');
	// Supprime les anciennes classes
	body.removeClass();
	// Ajoute les nouvelles classes
	// Pour les selects
	$(this).find('select').each(function() {
		var select = $(this);
		var option = select.find('option:selected').val();
		// Pour le select d'ajout d'image dans la bannière
		if(select.attr('id') === 'themeImage') {
			$('#header').css('background-image', 'url("' + option + '")');
			if(select.val() === '') {
				body.removeClass('themeImage');
			}
			else {
				body.addClass('themeImage');
			}
		}
		// Pour les autres
		else {
			if(option) {
				body.addClass(option);
			}
		}
	});
	// Pour les inputs
	$(this).find('input').each(function() {
		var input = $(this);
		// Cas spécifique pour les checkbox
		if(input.is(':checkbox')) {
			if(input.is(':checked')) {
				body.addClass(input.attr('name').replace('[]', ''));
			}
		}
		// Cas simple
		else {
			body.addClass(input.val());
		}
	});
});

/**
 * Scripts reliés à la classe template
 */

/* Sélecteur de couleur */
$('.colorPicker div').on('click', function() {
	var color = $(this);
	var colorPicker = color.parents('.colorPicker');
	// Sélectionne la couleur
	colorPicker.find('.selected').removeClass('selected');
	$(this).addClass('selected');
	// Ajoute la couleur sélectionnée dans l'input caché
	colorPicker.find('input[type=hidden]').val(color.data('color')).trigger('change');
});

/* Onglets */
$('.tabTitle').on('click', function() {
	var tabTitle = $(this);
	// Aucune action pour le titre de l'onglet courant
	if(tabTitle.hasClass('current') === false) {
		// Sélectionne le titre de l'onglet courant
		$('.tabTitle.current').removeClass('current');
		tabTitle.addClass('current');
		// Affiche le contenu de l'onglet courant
		$('.tabContent:visible').hide();
		$('.tabContent[data-1=' + tabTitle.attr('data-1') + ']').show();
	}
	// Ajoute le hash dans l'URL
	window.location.hash = tabTitle.attr('data-1');
});
// Affiche le bon onglet si un hash est présent dans l'URL
var hash = window.location.hash.substr(1);
if(hash) {
	var tabTitle = $('.tabTitle[data-1="' + hash + '"]');
	if(tabTitle.length) {
		tabTitle.trigger('click');
	}
}