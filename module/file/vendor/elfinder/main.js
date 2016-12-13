"use strict";
/**
 * elFinder client options and main script for RequireJS
 **/
(function(){
	var
		jqver = "3.1.1",
		uiver = "1.12.1",

		// Selection de fichiers
		fileBrowserDialogue = {
			init: function() {
				// Here goes your code for setting your custom things onLoad.
			},
			mySubmit: function (file, elf) {
				parent.tinymce.activeEditor.windowManager.getParams().oninsert(file, elf);
				parent.tinymce.activeEditor.windowManager.close();
			}
		},
		
		// Langue
		lang = (function() {
			var locq = window.location.search,
				fullLang, locm, lang;
			if (locq && (locm = locq.match(/lang=([a-zA-Z_-]+)/))) {
				// detection by url query (?lang=xx)
				fullLang = locm[1];
			} else {
				// detection by browser language
				fullLang = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
			}
			lang = fullLang.substr(0,2);
			if (lang === "ja") lang = "jp";
			else if (lang === "pt") lang = "pt_BR";
			else if (lang === "ug") lang = "ug_CN";
			else if (lang === "zh") lang = (fullLang.substr(0,5) === "zh-tw")? "zh_TW" : "zh_CN";
			return lang;
		})(),

		// Initialisation d'elFinder
		start = function(elFinder) {
			// load jQueryUI CSS
			elFinder.prototype.loadCss("//cdnjs.cloudflare.com/ajax/libs/jqueryui/"+uiver+"/themes/smoothness/jquery-ui.css");
			
			$(function() {
				var elf = $("#elfinder").elfinder({
					height: 524,
					resizable: false,
					url: "module/file/vendor/elfinder/php/connector.minimal.php",
					lang: lang,
					getFileCallback: function(file) { // editor callback
						// Require `commandsOptions.getfile.onlyURL = false` (default)
						fileBrowserDialogue.mySubmit(file, elf);
					}
				}).elfinder("instance");
			});
		},
		
		// Chargement du JS
		load = function() {
			require(
				[
					"elfinder",
					(lang !== "en")? "elfinder.lang" : null    // load detected language
				],
				start,
				function(error) {
					alert(error.message);
				}
			);
		};

	// Configuration de Require.js
	require.config({
		baseUrl : "module/file/vendor/elfinder/js/",
		paths : {
			"jquery"   : "//cdnjs.cloudflare.com/ajax/libs/jquery/" + jqver + "/jquery.min",
			"jquery-ui": "//cdnjs.cloudflare.com/ajax/libs/jqueryui/" + uiver + "/jquery-ui.min",
			"elfinder" : "elfinder.min",
			"elfinder.lang": [
				"i18n/elfinder." + lang,
				"i18n/elfinder.fallback"
			]
		},
		waitSeconds : 10 // optional
	});

	// Charge le JavaScript
	load();

})();
