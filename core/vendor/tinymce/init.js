// Initialisation de TinyMCE
var locq = window.location.search,
	fullLang, locm, lang;
if (locq && (locm = locq.match(/lang=([a-zA-Z_-]+)/))) {
	fullLang = locm[1];
} else {
	fullLang = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
}
lang = fullLang.substr(0,2);
tinymce.init({
	selector: ".editor",
	language: lang,
	plugins: "advlist anchor autolink autoresize charmap code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media nonbreaking noneditable paste preview print searchreplace tabfocus table textcolor textpattern visualchars wordcount",
	toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
	body_class: "editor",
	extended_valid_elements: "script[language|type|src]",
	content_css: [
		baseUrl + "core/main.css",
		baseUrl + "site/data/theme.css"
	],
	external_filemanager_path: baseUrl + "core/vendor/filemanager/",
	filemanager_title: "Responsive Filemanager" ,
	external_plugins: {
		"filemanager": baseUrl + "core/vendor/filemanager/plugin.min.js"
	}
});