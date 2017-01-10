// Initialisation de TinyMCE
tinymce.init({
	selector: ".editor",
	language: language,
	plugins: "advlist anchor autolink autoresize code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media paste preview searchreplace tabfocus table textcolor textpattern wordcount",
	toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
	body_class: "editor",
	extended_valid_elements: "script[language|type|src]",
	content_css: [
		baseUrl + "core/main.css",
		baseUrl + "site/data/theme.css"
	],
	relative_urls: false,
	document_base_url: baseUrl,
	filemanager_access_key: privateKey,
	external_filemanager_path: baseUrl + "core/vendor/filemanager/",
	external_plugins: {
		"filemanager": baseUrl + "core/vendor/filemanager/plugin.min.js"
	},
	// Permet de détecter un changement dans la textearea, utile pour le message des modifications non enregistrées du formulaire
	setup: function(editor) {
		editor.on("keydown", function() {
			$(editor.targetElm).trigger("keydown");
		});
	}
});