// Aperçu en direct
$("input, select").on("change", function() {
	// Couleurs du bas de page
	var colors = colorVariants($("#themeFooterBackgroundColor").val());
	var css = "footer{background-color:" + colors.normal + ";color:" + colors.text + "}";
	// Hauteur du bas de page
	css += "footer > div{margin:" + $("#themeFooterHeight").val() + " 0}";
	// Alignement du contenu
	css += "#socials{text-align:" + $("#themeFooterSocialsAlign").val() + "}";
	css += "#text{text-align:" + $("#themeFooterTextAlign").val() + "}";
	css += "#copyright{text-align:" + $("#themeFooterCopyrightAlign").val() + "}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
	// Position du bas de page
	switch($("#themeFooterPosition").val()) {
		case 'hide':
			$("footer").hide();
			break;
		case 'site':
			$("footer").show().appendTo("#site");
			break;
		case 'body':
			$("footer").show().appendTo("body");
			break;
	}
});