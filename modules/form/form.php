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

class formAdm extends core
{
	/** @var string Nom du module */
	public static $name = 'Générateur de formulaire';

	/** @var array Liste des vues du module */
	public static $views = ['send', 'data'];

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

	/** MODULE : Configuration du formulaire */
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Configuration du module
			$this->setData([
				$this->getUrl(0),
				'config',
				[
					'mail' => $this->getPost('mail', helper::EMAIL),
					'button' => $this->getPost('button', helper::STRING)
				]
			]);
			// Génération des champs
			$inputs = [];
			foreach($this->getPost('position') as $key => $value) {
				$value = helper::filter($value, helper::INT);
				// Supprime le premier élément (= le champ caché pour la copie)
				if(!empty($value)) {
					$inputs[] = [
						'position' => $value,
						'name' => $this->getPost(['name', $key], helper::STRING),
						'type' => $this->getPost(['type', $key], helper::STRING),
						'values' => $this->getPost(['values', $key], helper::STRING),
						'width' => $this->getPost(['width', $key], helper::INT)
					];
				}
			}

			// Crée les champs
			$this->setData([$this->getUrl(0), 'inputs', $inputs]);
			// Enregistre les données
			$this->saveData();
			// Notification de succès
			$this->setNotification('Formulaire enregistré avec succès !');
			// Redirige vers l'URL courante
			helper::redirect($this->getUrl());
		}
		// Liste des champs
		if($this->getData([$this->getUrl(0), 'inputs'])) {
			// Liste les champs en les classant par position en ordre croissant
			$inputs = helper::arrayCollumn($this->getData([$this->getUrl(0), 'inputs']), 'position', 'SORT_ASC');
			// Crée l'affichage des champs en fonction
			for($i = 0; $i < count($inputs); $i++) {
				self::$content .=
					template::openRow().
					template::hidden('position[]', [
						'value' => $this->getData([$this->getUrl(0), 'inputs', $inputs[$i], 'position']),
						'class' => 'position'
					]).
					template::button('move[]', [
						'value' => '&#8597;',
						'class' => 'move',
						'col' => 1
					]).
					template::text('name[]', [
						'placeholder' => 'Nom',
						'value' => $this->getData([$this->getUrl(0), 'inputs', $inputs[$i], 'name']),
						'col' => 3
					]).
					template::select('type[]', self::$types, [
						'selected'  => $this->getData([$this->getUrl(0), 'inputs', $inputs[$i], 'type']),
						'class' => 'type',
						'col' => 2
					]).
					template::text('values[]', [
						'placeholder' => 'Liste des valeurs (valeur1,valeur2,...)',
						'value' => $this->getData([$this->getUrl(0), 'inputs', $inputs[$i], 'values']),
						'class' => 'values',
						'col' => 3
					]).
					template::select('width[]', self::$widths, [
						'selected' => (int) $this->getData([$this->getUrl(0), 'inputs', $inputs[$i], 'width']),
						'col' => 2
					]).
					template::button('delete[]', [
						'value' => '-',
						'class' => 'delete',
						'col' => 1
					]).
					template::closeRow();
			}
		}
		// Contenu de la page
		self::$content =
			template::div([
				'id' => 'copy',
				'class' => 'hide',
				'text' =>
					template::openRow().
					template::hidden('position[]', [
						'class' => 'position'
					]).
					template::button('move[]', [
						'value' => '&#8597;',
						'class' => 'move',
						'col' => 1
					]).
					template::text('name[]', [
						'placeholder' => 'Nom',
						'col' => 3
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
					template::button('delete[]', [
						'value' => '-',
						'class' => 'delete',
						'col' => 1
					]).
					template::closeRow()
			]).
			template::openForm().
			template::tabs([
				'Liste des champs' =>
					template::div([
						'id' => 'inputs',
						'text' => self::$content
					]).
					template::openRow().
					template::button('add', [
						'value' => '+',
						'col' => 1,
						'offset' => 11
					]).
					template::closeRow(),
				'Configuration' =>
					template::openRow().
					template::text('mail', [
						'label' => 'Recevoir à chaque validation un mail contenant les données saisies',
						'value' => $this->getData([$this->getUrl(0), 'config', 'mail'])
					]).
					template::text('button', [
						'label' => 'Personnaliser le texte du bouton',
						'value' => $this->getData([$this->getUrl(0), 'config', 'button'])
					]).
					template::closeRow()
			]).
			template::openRow().
			template::button('back', [
				'value' => 'Retour',
				'href' => helper::baseUrl() . 'edit/' . $this->getUrl(0),
				'col' => 2
			]).
			template::button('data', [
				'value' => 'Données saisies',
				'href' => helper::baseUrl() . $this->getUrl() . '/data',
				'col' => 2,
				'offset' => 6
			]).
			template::submit('submit', [
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}

	/** MODULE : Aperçu des données saisies */
	public function data()
	{
		// Liste données saisies
		if($this->getData([$this->getUrl(0), 'data'])) {
			// Crée une pagination (retourne la première news et dernière news de la page et la liste des pages
			$pagination = helper::pagination($this->getData([$this->getUrl(0), 'data']), $this->getUrl());
			// Inverse l'ordre du tableau pour afficher les données en ordre décroissant
			$inputs = array_reverse($this->getData([$this->getUrl(0), 'data']));
			// Check si l'id du premier résultat est paire
			$firstPair = ($pagination['first'] % 2 === 0);
			// Crée l'affichage des données en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				// Ouvre la row ouverte à chaque id paire/impaire (dépend du premier résultat)
				if(($firstPair AND $i % 2 === 0) OR (!$firstPair AND $i % 2 === 1)) {
					self::$content .= template::openRow();
				}
				// Formatage des données
				$content = '';
				foreach($inputs[$i] as $input => $value) {
					$content .= $input . ' : ' . $value . '<br>';
				}
				self::$content .= template::background($content, [
					'col' => 6
				]);
				// Ferme la row ouverte à chaque id paire/impaire (dépend du premier résultat) ou pour le dernier champ
				if(($firstPair AND $i % 2 === 1) OR (!$firstPair AND $i % 2 === 0) OR !isset($inputs[$i + 1])) {
					self::$content .= template::closeRow();
				}
			}
			// Ajoute la liste des pages en dessous des news
			self::$content .= $pagination['pages'];
		}
		// Contenu de la page
		self::$content =
			template::title('Données saisies').
			(self::$content ? self::$content : template::subTitle('Aucune donnée...')).
			template::openRow().
			template::button('back', [
				'value' => 'Retour',
				'href' => helper::baseUrl() . 'module/' . $this->getUrl(0),
				'col' => 2
			]).
			template::closeRow();
	}
}

class formMod extends core
{
	/** @var bool Bloque la mise en cache */
	public static $cache = false;

	/**
	 * Génère un champ en fonction de son type
	 * @param  $input array Input à générer
	 * @return string
	 */
	private function generateInput($input)
	{
		switch($input['type']) {
			case 'text':
				// Génère le champ texte
				return
					template::openRow().
					template::text('input[]', [
						'label' => $input['name'],
						'col' => $input['width']
					]).
					template::closeRow();
			case 'textarea':
				// Génère le grand champ texte
				return
					template::openRow().
					template::textarea('input[]', [
						'label' => $input['name'],
						'col' => $input['width']
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
					template::select('input[]', $values, [
						'label' => $input['name'],
						'col' => $input['width']
					]).
					template::closeRow();
		}
	}

	/** MODULE : Formulaire */
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Préparation des données
			$data = [];
			$mail = '';
			foreach($this->getPost('input') as $key => $value) {
				// Préparation des données pour la création dans la base
				$data[$this->getData([$this->getUrl(0), 'inputs', $key, 'name'])] = $value;
				// Préparation des données pour le mail
				$mail .= '<li>' . $this->getData([$this->getUrl(0), 'inputs', $key, 'name']) . ' : ' . $value . '</li>';
			}
			// Crée les données
			$this->setData([$this->getUrl(0), 'data', helper::increment(1, $this->getData([$this->getUrl(0), 'data'])), $data]);
			// Enregistre les données
			$this->saveData();
			// Envoi du mail
			if($this->getData([$this->getUrl(0), 'config', 'mail'])) {
				helper::mail(
					false,
					$this->getData([$this->getUrl(0), 'config', 'mail']),
					helper::translate('Mail de votre site ZwiiCMS'),
					'<h1>' . helper::translate('Mail en provenance de votre site ZwiiCMS') . '</h1>' . $mail . '</ul>'
				);
			}
			// Notification de soumission
			$this->setNotification('Formulaire soumis avec succès !');
			// Redirige vers la page courante
			helper::redirect($this->getUrl());
		}
		// Génère les inputs
		if($this->getData([$this->getUrl(0), 'inputs'])) {
			foreach($this->getData([$this->getUrl(0), 'inputs']) as $input) {
				self::$content .= $this->generateInput($input);
			}
			// Texte du bouton de validation
			$submitText = $this->getData([$this->getUrl(0), 'config', 'button']);
			// Ajout du bouton de validation
			self::$content .=
				template::openRow().
				template::submit('submit', [
					'value' => $submitText ? $submitText : 'Enregistrer',
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