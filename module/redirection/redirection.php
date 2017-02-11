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

class redirection extends common {

	public static $actions = [
		'config' => self::RANK_MODERATOR,
		'index' => self::RANK_VISITOR
	];

	/**
	 * Configuration du module
	 */
	public function config() {
		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData(['module', $this->getUrl(0), 'url', $this->getInput('redirectionConfigUrl', helper::FILTER_URL)]);
			return [
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => 'Modifications enregistrées',
				'state' => true
			];
		}
		// Affichage du template
		return [
			'title' => 'Configuration du module',
			'view' => true
		];
	}

	/**
	 * Accueil du module
	 */
	public function index() {
		// Message si l'utilisateur peut éditer la page
		if(
			$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
			AND $this->getUser('rank') >= $this->getData(['page', self::RANK_MODERATOR, 'rank'])
			AND $this->getUrl(1) !== 'force'
		) {
			// Affichage du template
			return [
				'display' => self::DISPLAY_LAYOUT_BLANK,
				'view' => true
			];
		}
		// Sinon redirection
		else {
			// Incrémente le compteur de clics
			$this->setData(['module', $this->getUrl(0), 'count', helper::filter($this->getData(['module', $this->getUrl(0), 'count']) + 1, helper::FILTER_INT)]);
			// Affichage du template
			return [
				'redirect' => $this->getData(['module', $this->getUrl(0), 'url']),
				'state' => true
			];
		}
	}

}