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
	file_picker_callback : elFinderBrowser
});

function elFinderBrowser (callback, value, meta) {
	tinymce.activeEditor.windowManager.open({
		file: baseUrlQs + "file",
		title: "elFinder",
		width: 900,
		height: 544,
		resizable: "yes"
	}, {
		oninsert: function (file, elf) {
			var url, reg, info;
			url = file.url;
			reg = /\/[^/]+?\/\.\.\//;
			while(url.match(reg)) {
				url = url.replace(reg, "/");
			}
			info = file.name + " (" + elf.formatSize(file.size) + ")";
			if (meta.filetype == "file") {
				callback(url, {text: info, title: info});
			}
			if (meta.filetype == "image") {
				callback(url, {alt: info});
			}
			if (meta.filetype == "media") {
				callback(url);
			}
		}
	});
	return false;
}