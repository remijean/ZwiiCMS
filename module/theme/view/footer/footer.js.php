// Aperçu en direct
$("input, select").on("change", function() {
	// Couleurs du pied de page
	var colors = colorVariants($("#themeFooterBackgroundColor").val());
	var css = "footer{background-color:" + colors.normal + ";color:" + colors.text + "}";
	var css = "footer a{color:" + colors.text + "!important}";
	// Hauteur du pied de page
	css += "footer .container > div{margin:" + $("#themeFooterHeight").val() + " 0}";
	// Alignement du contenu
	css += "#footerSocials{text-align:" + $("#themeFooterSocialsAlign").val() + "}";
	css += "#footerText{text-align:" + $("#themeFooterTextAlign").val() + "}";
	css += "#footerCopyright{text-align:" + $("#themeFooterCopyrightAlign").val() + "}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
	// Position du pied de page
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
// Lien de connexion
$("#themeFooterLoginLink").on("change", function() {
	if($(this).is(":checked")) {
		$("<span>")
			.attr("id", "footerLoginLink")
			.append(
				$("<span>").text(" | "),
				$("<a>")
					.attr("href", "<?php echo helper::baseUrl(true); ?>user/login")
					.text("<?php echo helper::translate("Connexion"); ?>")
			).appendTo("#footerCopyright")
	}
	else {
		$("#footerLoginLink").remove();
	}
}).trigger("change");
// Aperçu du texte
$("#themeFooterText").on("keyup keydown change", function() {
	$("#footerText").text($(this).val());
});