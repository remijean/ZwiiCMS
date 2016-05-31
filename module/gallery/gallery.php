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
			helper::upload(self::$galleryExtensions);
		}
		if($this->getPost('submit')) {
			// Liste les images cochées
			$images = [];
			foreach($this->getPost('add') as $image => $bool) {
				$images[] = $image;
			}
			// Crée les données
			$this->setData([$this->getUrl(0), 'image', $images]);
			// Enregistre les données
			$this->saveData();
		}
		// Met en forme les fichiers pour les afficher dans un tableau
		$filesTable = [];
		foreach(helper::listUploads(false, self::$galleryExtensions) as $path => $file) {
			$filesTable[] = [
				template::checkbox('add[' . $file . ']', true, $file, [
					'checked' => ($this->getData([$this->getUrl(0), 'image']) AND in_array($file, $this->getData([$this->getUrl(0), 'image']))),
					'target' => '_blank'
				]),
				template::button('preview[' . $file . ']', [
					'value' => template::ico('eye'),
					'href' => $path,
					'target' => '_blank'
				])
			];
		}
		if($filesTable) {
			self::$content =
				template::openRow() .
				template::table([11, 1], $filesTable) .
				template::closeRow();
		}
		// Contenu de la page
		self::$title = helper::translate('Gestionnaire de fichiers');
		self::$content =
			template::title('Envoyer une image').
			template::openForm('upload', [
				'enctype' => 'multipart/form-data'
			]).
			template::openRow().
			template::file('file', [
				'label' => 'Parcourir mes fichiers',
				'help' => helper::translate('Les formats de fichiers autorisés sont :') . ' ' . implode(', .', core::$managerExtensions) . '.',
				'col' => '10'
			]).
			template::submit('send', [
				'value' => 'Envoyer',
				'col' => '2'
			]).
			template::closeRow().
			template::closeForm().
			template::title('Liste des images disponibles').
			template::openForm('files').
			(self::$content ? self::$content : template::subTitle('Aucune image...')).
			template::openRow().
			template::submit('submit', [
				'value' => 'Enregistrer',
				'col' => '2',
				'offset' => '10'
			]).
			template::closeRow();
	}
}

class galleryMod extends common
{
	/** Formulaire public */
	public function index()
	{
		$images = $this->getData([$this->getUrl(0), 'image']);
		foreach($images as $index => $image) {
			// Ouvre une ligne
			if($index % 4 === 0) {
				self::$content .= template::openRow();
			}
			// Ajoute les images
			self::$content .= template::div([
				'text' =>
					template::a(
						helper::baseUrl(false) . 'data/upload/' . $image,
						template::img(helper::baseUrl(false) . 'data/upload/' . $image),
						[
							'class' => 'gallery'
						]
					),
				'col' => 3
			]);
			// Ferme la ligne
			if($index % 4 === 3 OR !isset($images[$index + 1])) {
				self::$content .= template::closeRow();
			}
		}
		self::$content .= template::script('$(".gallery").simpleLightbox();');
	}
}