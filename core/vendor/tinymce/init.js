// Langue de TinyMCE
var language = "fr";
if(navigator.languages !== undefined && navigator.languages.length) {
	language = navigator.languages[0].split("-")[0];
}
else if(navigator.language !== undefined) {
	language = navigator.language;
}
else if(navigator.userLanguage !== undefined) {
	language = navigator.userLanguage;
}
// Initialisation de TinyMCE
tinymce.init({
	selector: ".editor",
	language: language,
	plugins: "advlist anchor autolink autoresize charmap code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media nonbreaking noneditable paste preview print searchreplace tabfocus table textcolor textpattern visualchars wordcount",
	toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
	body_class: "editor",
	extended_valid_elements: "script[language|type|src]",
	content_css: [
		"core/core.css"
		//, "core/cache/' . core::$cssVersion . '.css",
	],
	relative_urls: true
});