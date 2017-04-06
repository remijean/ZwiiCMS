<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2017, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class gallery extends common {

	public static $actions = [
		'config' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'dirs' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_MODERATOR,
		'index' => self::GROUP_VISITOR
	];

	public static $directories = [];

	public static $firstPictures = [];

	public static $galleries = [];

	public static $pictures = [];

	/**
	 * Configuration
	 */
	public function config() {
		// Liste des galeries
		$galleries = $this->getData(['module', $this->getUrl(0)]);
		if($galleries) {
			ksort($galleries);
			foreach($galleries as $galleryId => $gallery) {
				// Erreur dossier vide
				if(is_dir($gallery['config']['directory'])) {
					if(count(scandir($gallery['config']['directory'])) === 2) {
						$gallery['config']['directory'] = '<span class="galleryConfigError">' . $gallery['config']['directory'] . ' (' . helper::translate('dossier vide') . ')</span>';
					}
				}
				// Erreur dossier supprimé
				else {
					$gallery['config']['directory'] = '<span class="galleryConfigError">' . $gallery['config']['directory'] . ' (' . helper::translate('dossier introuvable') . ')</span>';
				}
				// Met en forme le tableau
				self::$galleries[] = [
					$gallery['config']['name'],
					$gallery['config']['directory'],
					template::button('galleryConfigEdit' . $galleryId, [
						'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $galleryId,
						'value' => template::ico('pencil')
					]),
					template::button('galleryConfigDelete' . $galleryId, [
						'class' => 'galleryConfigDelete buttonRed',
						'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $galleryId,
						'value' => template::ico('cancel')
					])
				];
			}
		}
		// Soumission du formulaire
		if($this->isPost()) {
			$galleryId = helper::increment($this->getInput('galleryConfigName', helper::FILTER_ID), (array) $this->getData(['module', $this->getUrl(0)]));
			$this->setData(['module', $this->getUrl(0), $galleryId, [
				'config' => [
					'name' => $this->getInput('galleryConfigName'),
					'directory' => $this->getInput('galleryConfigDirectory')
				],
				'legend' => []
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => 'Modifications enregistrées',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Configuration du module',
			'view' => 'config'
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Suppression
		else {
			$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Galerie supprimée',
				'state' => true
			]);
		}
	}

	/**
	 * Liste des dossiers
	 */
	public function dirs() {
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_JSON,
			'content' => galleriesHelper::scanDir('site/file/source')
		]);
	}

	/**
	 * Édition
	 */
	public function edit() {
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// La galerie existe
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Si l'id a changée
				$id = $this->getInput('galleryEditName', helper::FILTER_ID, true);
				if($id !== $this->getUrl(2)) {
					// Incrémente la nouvelle id de la gallery pour éviter les doublons
					$id = helper::increment($id, $this->getData(['module', $this->getUrl(0)]));
					// Supprime l'ancienne galerie
					$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
				}
				$legends = [];
				foreach((array) $this->getInput('legend', null) as $file => $legend) {
					$legends[$file] = helper::filter($legend, helper::FILTER_STRING_SHORT);
				}

				$this->setData(['module', $this->getUrl(0), $id, [
					'config' => [
						'name' => $this->getInput('galleryEditName', helper::FILTER_STRING_SHORT, true),
						'directory' => $this->getInput('galleryEditDirectory')
					],
					'legend' => $legends
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => 'Modifications enregistrées',
					'state' => true
				]);
			}
			// Met en forme le tableau
			$directory = $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory']);
			if(is_dir($directory)) {
				$iterator = new DirectoryIterator($directory);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						self::$pictures[] = [
							$fileInfos->getFilename(),
							template::text('legend[' . $fileInfos->getFilename() . ']', [
								'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'legend', $fileInfos->getFilename()])
							])
						];
					}
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name']),
				'view' => 'edit'
			]);
		}
	}

	/**
	 * Accueil (deux affichages en un pour éviter une url à rallonge)
	 */
	public function index() {
		// Images d'une galerie
		if($this->getUrl(1)) {
			// La galerie n'existe pas
			if($this->getData(['module', $this->getUrl(0), $this->getUrl(1)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// La galerie existe
			else {
				// Images de la galerie
				$directory = $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'config', 'directory']);
				if(is_dir($directory)) {
					$iterator = new DirectoryIterator($directory);
					foreach($iterator as $fileInfos) {
						if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
							self::$pictures[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'legend', $fileInfos->getFilename()]);
						}
					}
				}
				// Affichage du template
				if(self::$pictures) {
					// Valeurs en sortie
					$this->addOutput([
						'editButton' => true,
						'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'config', 'name']),
						'vendor' => [
							'simplelightbox'
						],
						'view' => 'gallery'
					]);
				}
				// Pas d'image dans la galerie
				else {
					// Valeurs en sortie
					$this->addOutput([
						'access' => false
					]);
				}
			}

		}
		// Liste des galeries
		else {
			foreach((array) $this->getData(['module', $this->getUrl(0)]) as $galleryId => $gallery) {
				if(is_dir($gallery['config']['directory'])) {
					$iterator = new DirectoryIterator($gallery['config']['directory']);
					foreach($iterator as $fileInfos) {
						if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
							self::$galleries[$galleryId] = $gallery;
							self::$firstPictures[$galleryId] = $gallery['config']['directory'] . '/' . $fileInfos->getFilename();
							continue(2);
						}
					}

				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'editButton' => true,
				'pageContent' => true,
				'view' => 'index'
			]);
		}
	}

}

class galleriesHelper extends helper {

	/**
	 * Scan le contenu d'un dossier et de ses sous-dossiers
	 * @param string $dir Dossier à scanner
	 * @return array
	 */
	public static function scanDir($dir) {
		$dirContent = [];
		$iterator = new DirectoryIterator($dir);
		foreach($iterator as $fileInfos) {
			if($fileInfos->isDot() === false AND $fileInfos->isDir()) {
				$dirContent[] = $dir . '/' . $fileInfos->getBasename();
				$dirContent = array_merge($dirContent, self::scanDir($dir . '/' . $fileInfos->getBasename()));
			}
		}
		return $dirContent;
	}

}