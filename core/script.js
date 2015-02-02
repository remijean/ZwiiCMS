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
	$(window).unbind('beforeunload');
});

/**
 * Affiche/cache le menu en mode responsive
 */
var menu = $('.menu');

$('#toggle').click(function() {
	menu.slideToggle();
});
$(window).on('resize', function() {
	if($(window).width() > 768) {
		menu.css('display', '');
	}
});