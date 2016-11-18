// Aperçu en direct
$("input, select").on("change", function() {
	// Couleur du fond
	var css = "body{background-color:" + $("#themeBodyBackgroundColor").val() + "}";
	// Image du fond
	css += "body{background-image:url('private/source/" + $("#themeBodyBackgroundImage").val() + "')}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});
// Affiche / Cache les options de l'image du fond
$("#themeBodyBackgroundImage").on("change", function() {
	if($(this).val()) {
		$("#themeBodyBackgroundImageOptions").slideDown();
	}
	else {
		$("#themeBodyBackgroundImageOptions").slideUp();
	}
}).trigger("change");