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
var menu = $('.menu');
$('.toggle').on('click', function() {
	menu.slideToggle();
});
$(window).on('resize', function() {
	if($(window).width() > 768) {
		menu.css('display', '');
	}
});

/* Filtre la langue du site au format de tinyMCE */
if(!language) {
	language = 'fr_FR';
}
else if(language === 'en_EN.json') {
	language = '';
}
else {
	language = language.substring(0, language.length - 5);
}

/* Charge tinyMCE */
tinymce.init({
	selector: '.editor',
	language: language,
	plugins: 'advlist anchor autolink autoresize charmap code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media nonbreaking noneditable paste preview print searchreplace tabfocus table textcolor textpattern visualchars wordcount',
	toolbar: 'insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
	body_class: bodyClass + ' editor',
	content_css: ['core/theme.css'],
	relative_urls: false,
	file_browser_callback: function(fieldName) {
		$('#editorField').val(fieldName);
		$('#editorFile').trigger('click');
	},
	file_browser_callback_types: 'image'
});

/* Ajoute le formulaire d'upload de tinyMCE */
if($('.editor').length && !$('#editorFileForm').length) {
	$('body').append(
		$('<form>').attr({
			id: 'editorForm',
			enctype: 'multipart/form-data',
			method: 'post'
		}).append(
			$('<input>').addClass('hide').attr({
				id: 'editorFile',
				type: 'file'
			}),
			$('<input>').attr({
				id: 'editorField',
				type: 'hidden'
			})
		)
	);
}

/* Upload de tinyMCE */
$('#editorFile').on('change', function() {
	var editorField = $('#editorField').val();
	var editorFieldShort = editorField.substring(0, editorField.length - 3);
	// Affiche le statut de l'upload
	function uploadStatus(color) {
		$('#' + editorField).val('').css('border-color', color);
		$('#' + editorFieldShort + 'l').css('color', color);
		$('#' + editorFieldShort + 'action').css({
			backgroundColor: color,
			borderColor: color
		});
	}
	// Upload d'image
	var file = this.files[0];
	if(file !== undefined && file.type.substring(0, 5) === 'image') {
		var formData = new FormData();
		formData.append('file', file);
		$.ajax({
			type: 'POST',
			url: baseUrl + 'upload',
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				if(data.error) {
					uploadStatus('#E74C3C');
				}
				else {
					uploadStatus('#1ABC9C');
					$('#' + editorField).val(data.link);
				}
			},
			error: function() {
				uploadStatus('#E74C3C');
			}
		});
	}
	else {
		uploadStatus('#E74C3C');
	}
});