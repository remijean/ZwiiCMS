<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <moi@remijean.fr>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class galleryAdm extends common
{
	/** @var string Nom du module */
	public static $name = 'Galerie d\'images';

	/** @var array Liste des vues du module */
	public static $views = ['delete', 'rename'];

	/** @var array Extensions autorisées dans le gestionnaire de fichiers */
	public static $galleryExtensions = [
		'gif',
		'jpeg',
		'jpg',
		'png'
	];

	/** Configuration de la galerie */
	public function index()
	{
		// Traitement des formulaires
		if($this->getPost('send')) {
			// Upload l'image
			$data = helper::upload(self::$galleryExtensions);
			// En cas de succès
			if(isset($data['success'])) {
				// Ajoute l'image à la galerie
				$this->setData([$this->getUrl(0), 'upload', helper::filter(basename($_FILES['file']['name']), helper::URL), $this->getPost('legend', helper::STRING)]);
				// Enregistre les données
				$this->saveData();
				// Notification d'upload
				$this->setNotification($data['success']);
			}
			// Sinon crée une notice en cas d'erreur
			else {
				template::$notices['file'] = $data['error'];
			}
		}
		// Met en forme les images pour les afficher dans un tableau
		if($images = $this->getData([$this->getUrl(0), 'upload'])) {
			asort($images);
			$filesTable = [];
			foreach($images as $image => $legend) {
				$filesTable[] = [
					template::div([
						'text' => $legend
					]),
					template::button('preview[' . $image . ']', [
						'value' => template::ico('eye'),
						'href' => helper::baseUrl(false) . 'data/upload/' . $image,
						'target' => '_blank'
					]),
					template::button('rename[]', [
						'value' => template::ico('pencil'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0) . '/rename/' . $image
					]),
					template::button('delete[' . $image . ']', [
						'value' => template::ico('cancel'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0) . '/delete/' . $image,
						'onclick' => 'return confirm(\'Êtes-vous sûr de vouloir supprimer cette image ? Elle sera également supprimée du gestionnaire de fichiers !\');'
					])
				];
			}
			self::$content =
				template::openRow().
				template::table([9, 1, 1, 1], $filesTable).
				template::closeRow();
		}
		// Contenu de la page
		self::$content =
			template::title('Envoyer une image').
			template::openForm('upload', [
				'enctype' => 'multipart/form-data'
			]).
			template::openRow().
			template::file('file', [
				'label' => 'Parcourir mes fichiers',
				'help' => helper::translate('Les formats de fichiers autorisés sont :') . ' ' . implode(', .', self::$galleryExtensions) . '.',
				'col' => '4'
			]).
			template::text('legend', [
				'label' => 'Légende de l\'image',
				'col' => '6',
				'required' => true
			]).
			template::submit('send', [
				'value' => 'Envoyer',
				'col' => '2'
			]).
			template::closeRow().
			template::closeForm().
			template::title('Images de la galerie').
			(self::$content ? self::$content : template::subTitle('Aucune image...')).
			template::openRow().
			template::button('back', [
				'value' => 'Retour',
				'href' => helper::baseUrl() . $this->getUrl(0),
				'col' => 2
			]).
			template::closeRow();
	}

	/** Recommage d'une image */
	public function rename()
	{
		// Erreur 404
		if(!array_key_exists($this->getUrl(2), $this->getData([$this->getUrl(0), 'upload']))) {
			return false;
		}
		// Traitement du formulaire
		elseif($this->getPost('submit')) {
			// Renomme l'image
			$this->setData([$this->getUrl(0), 'upload', $this->getUrl(2), $this->getPost('name', helper::STRING)]);
			// Enregistre les données
			$this->saveData();
			// Notification de renommage
			$this->setNotification('Image renommée avec succès !');
			// Redirige vers le module de la page
			helper::redirect('module/' . $this->getUrl(0));
		}
		// Template de la page
		self::$title = $this->getUrl(0);
		self::$content =
			template::openForm().
			template::openRow().
			template::text('name', [
				'label' => 'Légende de l\'image',
				'value' => $this->getData([$this->getUrl(0), 'upload', $this->getUrl(2)]),
				'required' => true,
				'col' => 12
			]).
			template::newRow().
			template::button('back', [
				'value' => 'Retour',
				'href' => helper::baseUrl() . 'module/' . $this->getUrl(0),
				'col' => 2
			]).
			template::submit('submit', [
				'col' => 2,
				'offset' => 8
			]).
			template::closeRow().
			template::closeForm();
	}
	
	/** Suppression d'une image */
	public function delete()
	{
		// Erreur 404
		if(!array_key_exists($this->getUrl(2), $this->getData([$this->getUrl(0), 'upload']))) {
			return false;
		}
		// Suppression de l'image
		else {
			// Bloque la suppresion en mode démo
			if(self::$demo) {
				$this->setNotification('Action impossible en mode démonstration !', true);
			}
			else {
				// Supprime l'image de la galerie
				$image = 'data/upload/' . $this->getUrl(2);
				$this->removeData([$this->getUrl(0), 'upload', $this->getUrl(2)]);
				// Enregistre les données
				$this->saveData();
				// Tente de supprimer l'image du gestionnaire de fichiers
				if(is_file($image) AND @unlink($image)) {
					// Notification de suppression
					$this->setNotification('Fichier supprimé avec succès !');
				}
				else {
					// Notification de suppression
					$this->setNotification('Fichier supprimé de la galerie mais échec de la suppression du gestionnaire de fichiers !', true);
				}
			}
			// Redirige vers le module de la page
			helper::redirect('module/' . $this->getUrl(0));
		}
	}
}

class galleryMod extends common
{
	/** Formulaire public */
	public function index()
	{
		$images = $this->getData([$this->getUrl(0), 'upload']);
		$imagesNb = count($images);
		$i = 1;
		foreach($images as $image => $legend) {
			// Ingore l'image si elle n'existe plus dans les fichiers uploadés
			if(!is_file('data/upload/' . $image)) {
				continue;
			}
			// Ouvre une ligne
			if($i % 6 === 1) {
				self::$content .= template::openRow();
			}
			// Ajoute les images
			self::$content .= template::div([
				'text' =>
					template::a(
						helper::baseUrl(false) . 'data/upload/' . $image,
						template::div([
							'text' => $legend
						]),
						[
							'class' => 'gallery',
							'style' => 'background-image:url(\'' . helper::baseUrl(false) . 'data/upload/' . $image . '\')',
							'title' => $legend
						]
					),
				'col' => 2
			]);
			// Ferme la ligne
			if($i % 6 === 0 OR $i === $imagesNb) {
				self::$content .= template::closeRow();
			}
			// Incrémente l'index
			$i++;
		}
		self::$content .= template::script(
			'$(".gallery").simpleLightbox({
				captionSelector: "self"
			});
		');
	}
}