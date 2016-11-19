// Aperçu en direct
$("input, select").on("change", function() {
	// Import des polices de caractères
	var titleFont = $("#themeTitleFont").val();
	var textFont = $("#themeTextFont").val();
	var css = "@import url('https://fonts.googleapis.com/css?family=" + titleFont + "|" + textFont + "');";
	// Couleurs des boutons
	var colors = colorVariants($("#themeButtonBackgroundColor").val());
	css += ".button,input[type='submit'],pagination a,input[type='checkbox']:checked + label:before,input[type='radio']:checked + label:before,.helpContent{background-color:" + colors.normal + ";color:" + colors.text + "}";
	css += ".tabTitle.current,.helpButton span{color:" + colors.normal + "}";
	css += "input[type='text']:hover,input[type='password']:hover,.inputFile:hover,select:hover,textarea:hover{border: 1px solid " + colors.normal + "}";
	css += ".button:hover,input[type='submit']:hover,.pagination a:hover,input[type='checkbox']:not(:active):checked:hover + label:before,input[type='checkbox']:active + label:before,input[type='radio']:checked:hover + label:before,input[type='radio']:not(:checked):active + label:before{background-color:" + colors.darken + ";color:" + colors.text + "}";
	css += ".helpButton span:hover{color:" + colors.darken + "}";
	css += ".button:active,input[type='submit']:active,.pagination a:active{background-color:" + colors.veryDarken + ";color:" + colors.text + "}";
	// Couleurs des liens
	colors = colorVariants($("#themeLinkTextColor").val());
	css += "a{color:" + colors.normal + "}";
	css += "a:hover{color:" + colors.darken + "}";
	css += "a:active{color:" + colors.veryDarken + "}";
	// Couleur et polices de caractères des titres
	css += "h1,h2,h3,h4,h5,h6{color:" + $("#themeTitleTextColor").val() + ";font-family:'" + titleFont.replace("+", " ") + "',sans-serif}";
	// Police de caractères du texte
	css += "body{font-family:'" + textFont.replace("+", " ") + "',sans-serif}";
	// Largeur du site
	css += ".container{max-width:" + $("#themeSiteWidth").val() + "}";
	// Arrondi sur les coins du site et ombre sur les bords du site
	css += "#site{border-radius:" + $("#themeSiteRadius").val() + ";box-shadow:" + $("#themeSiteShadow").val() + " #3C3C3C}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});