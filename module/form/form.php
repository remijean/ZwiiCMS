<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class formAdm extends common
{
	/** @var string Nom du module */
	public static $name = 'Générateur de formulaire';

	/** @var array Liste des types */
	public static $types = [
		'text' => 'Champ texte',
		'textarea' => 'Grand champ texte',
		'select' => 'Sélection'
	];

	/** @var array Liste des largeurs */
	public static $widths = [
		1 => 'Largeur 1',
		2 => 'Largeur 2',
		3 => 'Largeur 3',
		4 => 'Largeur 4',
		5 => 'Largeur 5',
		6 => 'Largeur 6',
		7 => 'Largeur 7',
		8 => 'Largeur 8',
		9 => 'Largeur 9',
		10 => 'Largeur 10',
		11 => 'Largeur 11',
		12 => 'Largeur 12',
	];

	/** Configuration du formulaire */
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Configuration du module
			$this->setData([
				$this->getUrl(0),
				'config',
				[
					'button' => $this->getPost('button', helper::STRING),
					'capcha' => $this->getPost('capcha', helper::BOOLEAN),
					'mail' => $this->getPost('mail', helper::EMAIL)
				]
			]);
			// Génération des champs
			$inputs = [];
			foreach($this->getPost('position') as $index => $position) {
				$position = helper::filter($position, helper::INT);
				// Supprime le premier élément (= le champ caché pour la copie) car il n'a pas de position
				if(!empty($position)) {
					$inputs[] = [
						'name' => $this->getPost('name[' . $index . ']', helper::STRING),
						'position' => $position,
						'required' => $this->getPost('required[' . $index . ']', helper::BOOLEAN),
						'type' => $this->getPost('type[' . $index . ']', helper::STRING),
						'values' => $this->getPost('values[' . $index . ']', helper::STRING),
						'width' => $this->getPost('width[' . $index . ']', helper::INT)
					];
				}
			}
			// Crée les champs
			$this->setData([$this->getUrl(0), 'input', $inputs]);
			// Enregistre les données
			$this->saveData();
			// Notification de succès
			$this->setNotification('Formulaire enregistré avec succès !');
			// Redirige vers l'URL courante
			//helper::redirect($this->getUrl(null, false));
		}
		// Liste données entregistrées
		if($this->getData([$this->getUrl(0), 'data'])) {
			// Crée une pagination (retourne la première news et dernière news de la page et la liste des pages
			$pagination = helper::pagination($this->getData([$this->getUrl(0), 'data']), $this->getUrl(null, false), '#3');
			// Inverse l'ordre du tableau pour afficher les données en ordre décroissant
			$inputs = array_reverse($this->getData([$this->getUrl(0), 'data']));
			// Crée l'affichage des données en fonction de la pagination
			$row = [];
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$content = '';
				foreach($inputs[$i] as $input => $value) {
					$content .= $input . ' : ' . $value . '<br>';
				}
				$row[] = [$content];
			}
			// Tableau et liste des pages
			$data =
				template::openRow().
				template::table([12], $row).
				template::closeRow().
				$pagination['page'];
		}
		// Contenu de la page
		self::$vendor['jquery-ui'] = true;
		self::$content =
			template::div([
				'id' => 'copy',
				'class' => 'displayNone',
				'text' =>
					template::div([
						'class' => 'input backgroundWhite',
						'text' =>
							template::openRow().
							template::hidden('position[]', [
								'class' => 'position'
							]).
							template::button('move[]', [
								'value' => template::ico('up-down'),
								'class' => 'move',
								'col' => 1
							]).
							template::text('name[]', [
								'placeholder' => 'Nom',
								'col' => 2
							]).
							template::select('type[]', self::$types, [
								'class' => 'type',
								'col' => 2
							]).
							template::text('values[]', [
								'placeholder' => 'Liste des valeurs (valeur1,valeur2,...)',
								'class' => 'values',
								'col' => 3
							]).
							template::select('width[]', self::$widths, [
								'selected' => 12,
								'col' => 2
							]).
							template::button('moreToggle[]', [
								'value' => template::ico('gear'),
								'class' => 'moreToggle',
								'col' => 1
							]).
							template::button('delete[]', [
								'value' => template::ico('minus'),
								'class' => 'delete',
								'col' => 1
							]).
							template::closeRow().
							template::div([
								'class' => 'more displayNone',
								'text' =>
									template::openRow().
									template::checkbox('required[]', true, 'Champ obligatoire').
									template::closeRow()
							])
					])
			]).
			template::openForm().
			template::tabs([
				'Liste des champs' =>
					template::subTitle('Aucun champ...', [
						'id' => 'noInput'
					]).
					template::div([
						'id' => 'inputs',
						'text' => self::$content
					]).
					template::openRow().
					template::button('add', [
						'value' => template::ico('plus'),
						'col' => 1,
						'offset' => 11
					]).
					template::closeRow().
					template::script('
						// Liste les champs en les classant par position en ordre croissant
						var inputsPerPosition = ' . json_encode(helper::arrayCollumn($this->getData([$this->getUrl(0), 'input']), 'position', 'SORT_ASC')) . ';
						var inputs = ' . json_encode($this->getData([$this->getUrl(0), 'input'])) . ';

						// Unique ID des inputs
						var inputUid = 0;
						
						// Ajout des champs déjà existant
						for(var i = 0; i < inputs.length; i++) {
							add(inputUid, inputs[inputsPerPosition[i]]);
							inputUid++;
						}
					
						// Afficher/cacher les options supplémentaires
						$(document).on("click", ".moreToggle", function() {
							$(this).parents(".input").find(".more").slideToggle();
						});
						
						// Crée un nouveau champ à partir des champs cachés
						$("#add").on("click", function() {
							add(inputUid);
							inputUid++;
						});
						
						// Actions sur les champs
						$("#inputs")
							// Tri entre les champs
							.sortable({
								axis: "y",
								containment: "#inputs",
								retard: 150,
								handle: ".move",
								placeholder: "placeholder",
								forcePlaceholderSize: true,
								tolerance: "pointer",
								start: function(e, ui) {
									// Calcul la hauteur du placeholder
									ui.placeholder.height(ui.helper.outerHeight());
								},
								update: function() {
									// Actualise les positions
									position();
								}
							})
							// Suppression du champ
							.on("click", ".delete", function() {
								// Affiche le texte d\'absence de champ (avant la suppression pour effet visuel)
								if($(".input").length === 2) { // 2 à cause du champ caché et du champ actuel qui n\est toujours pas supprimé
									 $("#noInput").slideDown();
								}
								// Cache le champ
								$(this).parents(".input").slideUp(400, function() {
									// Supprime le champ
									$(this).remove();
									// Actualise les positions
									position();
								});
							})
							// Affiche/cache le champ "Valeurs" en fonction des champs cachés
							.on("change", ".type", function() {
								var typeCol = $(this).parent();
								var valuesCol = $(this).parents(".input").find(".values").parent();
								typeCol.removeClass();
								if($(this).val() === "select") {
									typeCol.addClass("col2");
									valuesCol.show();
								}
								else {
									typeCol.addClass("col5");
									valuesCol.hide();
								}
							});
						
						// Simule un changement de type au chargement de la page
						$(".type").trigger("change");
						
						// Ajout un champ
						function add(inputUid, input) {
							// Nouveau champ
							var newInput = $($("#copy").html());
							// Attribue les bonnes valeurs
							if(input) {
								// Nom du champ
								newInput.find("[name=\'name[]\']").val(input.name);
								// Type de champ
								newInput.find("[name=\'type[]\'] option[value=\'" + input.type + "\']").prop("selected", true);
								// Valeurs du champ
								newInput.find("[name=\'values[]\']").val(input.values);
								// Largeur du champ
								newInput.find("[name=\'width[]\'] option[value=\'" + input.width + "\']").prop("selected", true);
								// Champ obligatoire
								newInput.find("[name=\'required[]\']").prop("checked", input.required);
							}
							// Ajout de l\'ID unique aux champs
							newInput.find("a, input, select").each(function() {
								var _this = $(this);
								_this.attr({
									id: _this.attr("id").replace("[]", "[" + inputUid + "]"),
									name: _this.attr("name").replace("[]", "[" + inputUid + "]")
								});
							});
							newInput.find("label").each(function() {
								var _this = $(this);
								_this.attr("for", _this.attr("for").replace("[]", "[" + inputUid + "]"));
							});
							// Ajout du nouveau champ au DOM et cache le texte d\'absence de champ sans effet (pour les champs à déjà présents)
							var noInputDOM = $("#noInput:visible");
							if(input) {
								$("#inputs").append(newInput);
								// Cache le texte d\'absence de champ
								noInputDOM.hide();
							}
							// Ajout du nouveau champ au DOM et cache le texte d\'absence de champcavec un effet (pour les nouveaux champs)
							else {
								// Ajout du nouveau champ au DOM
								$("#inputs")
									.append(newInput.hide())
									.find(".input").last().slideDown();
								// Cache le texte d\'absence de champ
								noInputDOM.slideUp();
							}
							// Check le type
							$(".type").trigger("change");
							// Actualise les positions
							position();
						}
						
						// Calcul des positions
						function position() {
							$("#inputs").find(".position").each(function(i) {
								$(this).val(i + 1);
							});
						}
					'),
				'Configuration' =>
					template::openRow().
					template::text('mail', [
						'label' => 'Adresse mail pour recevoir les données saisies à chaque soumission du formulaire',
						'value' => $this->getData([$this->getUrl(0), 'config', 'mail'])
					]).
					template::newRow().
					template::text('button', [
						'label' => 'Texte du bouton de soumission',
						'value' => $this->getData([$this->getUrl(0), 'config', 'button'])
					]).
					template::newRow().
					template::checkbox('capcha', true, 'Ajouter un capcha à remplir pour soumettre le formulaire', [
						'checked' => $this->getData([$this->getUrl(0), 'config', 'capcha'])
					]).
					template::closeRow(),
				'Données entregistrées' =>
					(isset($data) ? $data : template::subTitle('Aucune donnée...'))
			]).
			template::openRow().
			template::button('back', [
				'value' => 'Retour',
				'href' => helper::baseUrl() . $this->getUrl(0),
				'col' => 2
			]).
			template::submit('submit', [
				'col' => 2,
				'offset' => 8
			]).
			template::closeRow().
			template::closeForm();
	}
}

class formMod extends core
{
	/** @var bool Bloque la mise en cache */
	public static $cache = false;

	/**
	 * Génère un champ en fonction de son type
	 * @param  $index int   Index de l'input à générer
	 * @param  $input array Input à générer
	 * @return string
	 */
	private function generateInput($index, $input)
	{
		switch($input['type']) {
			case 'text':
				// Génère le champ texte
				return
					template::openRow().
					template::text('input[' . $index . ']', [
						'label' => $input['name'],
						'col' => $input['width'],
						'required' => $input['required'] ? 'required' : ''
					]).
					template::closeRow();
			case 'textarea':
				// Génère le grand champ texte
				return
					template::openRow().
					template::textarea('input[' . $index . ']', [
						'label' => $input['name'],
						'col' => $input['width'],
						'required' => $input['required'] ? 'required' : ''
					]).
					template::closeRow();
			case 'select':
				// Génère un tableau sous forme value => value
				$values = array_flip(explode(',', $input['values']));
				foreach($values as $value => $key) {
					$values[$value] = $value;
				}
				// Génère le champ de sélection
				return
					template::openRow().
					template::select('input[' . $index . ']', [
						'label' => $input['name'],
						'col' => $input['width'],
						'required' => $input['required'] ? 'required' : ''
					]).
					template::closeRow();
		}
	}

	/** Formulaire public */
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Check la capcha
			if(
				$this->getData([$this->getUrl(0), 'config', 'capcha'])
				AND $this->getPost('capcha', helper::INT) !== $this->getPost('capchaFirstNumber', helper::INT) + $this->getPost('capchaSecondNumber', helper::INT))
			{
				template::$notices['capcha'] = 'La somme indiquée est incorrecte';
			}
			// Préparation des données
			$data = [];
			$mail = '';
			foreach($this->getPost('input') as $index => $value) {
				// Erreur champ obligatoire
				if(empty($value)) {
					template::getRequired('input[' . $index . ']');
				}
				// Préparation des données pour la création dans la base
				$data[$this->getData([$this->getUrl(0), 'input', $index, 'name'])] = $value;
				// Préparation des données pour le mail
				$mail .= '<li>' . $this->getData([$this->getUrl(0), 'input', $index, 'name']) . ' : ' . $value . '</li>';
			}
			// Crée les données
			$this->setData([$this->getUrl(0), 'data', helper::increment(1, $this->getData([$this->getUrl(0), 'data'])), $data]);
			// Enregistre les données
			$this->saveData();
			// Envoi du mail
			if(!template::$notices) {
				if($this->getData([$this->getUrl(0), 'config', 'mail'])) {
					$sent = helper::mail(
						false,
						$this->getData([$this->getUrl(0), 'config', 'mail']),
						helper::translate('Nouvelle entrée dans votre formulaire'),
						'<h2>' . helper::translate('Mail en provenance de votre site ZwiiCMS') . '</h2><h3>' . helper::baseUrl() . $this->getUrl(null, false) . '</h3><ul>' . $mail . '</ul>'
					);
				}
				// Notification de soumission
				if(isset($sent)) {
					$this->setNotification('Formulaire soumis avec succès !');
				}
				else {
					$this->setNotification('Impossible d\'envoyer le mail mais formulaire soumis avec succès !', true);
				}
			}
			// Redirige vers la page courante
			helper::redirect($this->getUrl());
		}
		// Génère les inputs
		if($this->getData([$this->getUrl(0), 'input'])) {
			foreach($this->getData([$this->getUrl(0), 'input']) as $index => $input) {
				self::$content .= $this->generateInput($index, $input);
			}
			$capcha = '';
			if($this->getData([$this->getUrl(0), 'config', 'capcha'])) {
				$capcha = template::capcha('capcha', [
					'col' => 3
				]).
				template::newRow();
			}
			// Ajout du bouton de validation
			self::$content .=
				template::openRow().
				$capcha.
				template::submit('submit', [
					'value' => $this->getData([$this->getUrl(0), 'config', 'button']) ? $this->getData([$this->getUrl(0), 'config', 'button']) : 'Enregistrer',
					'col' => 2
				]).
				template::closeRow();
		}
		// Contenu de la page
		self::$content =
			template::openForm().
			self::$content.
			template::closeForm();
	}
}