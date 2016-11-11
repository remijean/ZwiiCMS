// Aperçu en direct
var css = "";
$("#themeSiteForm").find(":input").on("change", function() {
	//css += "h1,h2,h3,h4,h5,h6{color:" + $("#themeTitleTextColor").val() + "}";
	css += "h1,h2,h3,h4,h5,h6{color:red}";
	$("#themeSiteStyle").remove();
	$("<style>")
		.attr("id", "themeSiteStyle")
		.text(css)
		.appendTo("head");
});