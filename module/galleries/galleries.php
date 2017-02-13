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

class galleries extends common {

	public static $actions = [
		'config' => self::RANK_MODERATOR,
		'delete' => self::RANK_MODERATOR,
		'dirs' => self::RANK_MODERATOR,
		'edit' => self::RANK_MODERATOR,
		'gallery' => self::RANK_VISITOR,
		'index' => self::RANK_VISITOR
	];

	public static $directories = [];

	public static $firstPictures = [];

	public static $galleries = [];

	public static $pictures = [];

	/**
	 * Configuration
	 */
	public function config() {
		// Soumission du formulaire
		if($this->isPost()) {
			$galleryId = helper::increment($this->getInput('galleriesConfigName', helper::FILTER_ID), (array) $this->getData(['module', $this->getUrl(0)]));
			$this->setData(['module', $this->getUrl(0), $galleryId, [
				'config' => [
					'name' => $this->getInput('galleriesConfigName'),
					'directory' => $this->getInput('galleriesConfigDirectory')
				],
				'legend' => []
			]]);
			return [
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => 'Modifications enregistrées',
				'state' => true
			];
		}
		// Affichage du template
		else {
			// Liste des galeries
			$galleries = $this->getData(['module', $this->getUrl(0)]);
			if($galleries) {
				ksort($galleries);
				foreach($galleries as $galleryId => $gallery) {
					// Erreur dossier vide
					if(is_dir($gallery['config']['directory'])) {
						if(count(scandir($gallery['config']['directory'])) === 2) {
							$gallery['config']['directory'] = '<span class="galleriesConfigError">' . $gallery['config']['directory'] . ' (' . helper::translate('dossier vide') . ')</span>';
						}
					}
					// Erreur dossier supprimé
					else {
						$gallery['config']['directory'] = '<span class="galleriesConfigError">' . $gallery['config']['directory'] . ' (' . helper::translate('dossier introuvable') . ')</span>';
					}
					// Met en forme le tableau
					self::$galleries[] = [
						$gallery['config']['name'],
						$gallery['config']['directory'],
						template::button('galleriesConfigEdit' . $galleryId, [
							'value' => template::ico('pencil'),
							'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $galleryId
						]),
						template::button('galleriesConfigDelete' . $galleryId, [
							'value' => template::ico('cancel'),
							'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $galleryId,
							'class' => 'galleriesConfigDelete'
						])
					];
				}
			}
			return [
				'title' => 'Configuration du module',
				'view' => true
			];
		}
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			return [
				'access' => false
			];
		}
		// Suppression
		else {
			$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
			return [
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Galerie supprimée',
				'state' => true
			];
		}
	}

	/**
	 * Liste des dossiers
	 */
	public function dirs() {
		return [
			'display' => self::DISPLAY_JSON,
			'result' => galleriesHelper::scanDir('site/file/source')
		];
	}

	/**
	 * Édition
	 */
	public function edit() {
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			return [
				'access' => false
			];
		}
		// Soumission du formulaire
		elseif($this->isPost()) {
			$galleryId = $this->getInput('galleriesEditName', helper::FILTER_ID);
			// Si l'id a changée
			if($galleryId !== $this->getUrl(2)) {
				// Incrémente la nouvelle id de la gallery pour éviter les doublons
				$galleryId = helper::increment($galleryId, $this->getData(['module', $this->getUrl(0)]));
				// Supprime l'ancienne galerie
				$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
			}
			$this->setData(['module', $this->getUrl(0), $galleryId, [
				'config' => [
					'name' => $this->getInput('galleriesEditName'),
					'directory' => $this->getInput('galleriesEditDirectory')
				],
				'legend' => $this->getInput('legend', null)
			]]);
			return [
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Modifications enregistrées',
				'state' => true
			];
		}
		// Affichage du template
		else {
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
			return [
				'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name']),
				'view' => true
			];
		}
	}

	/**
	 * Images d'une galerie
	 */
	public function gallery() {
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			return [
				'access' => false
			];
		}
		// Images de la galerie
		else {
			$directory = $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory']);
			if(is_dir($directory)) {
				$iterator = new DirectoryIterator($directory);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						self::$pictures[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'legend', $fileInfos->getFilename()]);
					}
				}
			}
			// Affichage du template
			if(self::$pictures) {
				return [
					'editButton' => true,
					'vendor' => [
						'simplelightbox'
					],
					'view' => true
				];
			}
			// La galerie est vide
			else {
				return [
					'access' => false
				];
			}
		}
	}

	/**
	 * Accueil
	 */
	public function index() {
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
		// Affichage du template
		return [
			'editButton' => true,
			'view' => true
		];
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