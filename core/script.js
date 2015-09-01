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
	var config = $('#config');
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
					config.addClass('disabled');
				}
				else {
					config.removeClass('disabled');
				}
			},
			error: function() {
				alert('Impossible d\'enregistrer le module !');
				config.addClass('disabled');
			}
		});
	}
});

/**
 * Change le thème en direct
 */
$('#theme').on('change', function() {
	var oldTheme = $('#oldTheme');
	$('link[href="themes/' + oldTheme.val() + '"]').attr('href', 'themes/' + $(this).val());
	oldTheme.val($(this).val());
});