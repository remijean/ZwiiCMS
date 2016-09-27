<?php

class config extends common {

	public $actions = [
		'theme' => self::RANK_ADMIN
	];
	public static $repeats = [
		'none' => 'Ne pas répéter',
		'x' => 'Sur l\'axe horizontal',
		'y' => 'Sur l\'axe vertical',
		'all' => 'Sur les deux axes'
	];
	public static $positions = [
		'cover' => 'Remplir le fond',
		'topLeft' => 'En haut à gauche',
		'topCenter' => 'En haut au centre',
		'topRight' => 'En haut à droite',
		'centerLeft' => 'Au milieu à gauche',
		'centerCenter' => 'Au milieu au centre',
		'centerRight' => 'Au milieu à droite',
		'bottomLeft' => 'En bas à gauche',
		'bottomCenter' => 'En bas au centre',
		'bottomRight' => 'En bas à droite'
	];
	public static $attachments = [
		'scroll' => 'Normale',
		'fixed' => 'Fixe'
	];

	/**
	 * Personnalisation
	 */
	public function theme() {
		// Soumission du formulaire
		if($this->isPost()) {

		}
		// Affichage du template
		else {
			return [
				'view' => true,
				'state' => true
			];
		}
	}

}