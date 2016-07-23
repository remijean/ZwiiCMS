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

class guestbookAdm extends common
{
	/** @var string Nom du module */
	public static $name = 'Livre d\'or';

	/** @var array Liste des vues du module */
	public static $views = ['delete'];

	/** Liste des commentaires */
	public function index()
	{
		// Liste les commentaires
		if($this->getData($this->getUrl(0))) {
			// Crée une pagination (retourne le premier commentaire et dernier commentaire de la page et la liste des pages
			$pagination = helper::pagination($this->getData($this->getUrl(0)), $this->getUrl(null, false));
			// Liste les commentaires en les classant par date en ordre décroissant
			$commentaires = helper::arrayCollumn($this->getData($this->getUrl(0)), 'date', 'SORT_DESC');
			// Met en forme les commentaires pour les afficher dans un tableau
			$commentairesTable = [];
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$commentairesTable[] = [
					$this->getData([$this->getUrl(0), $commentaires[$i], 'name']),
					template::button('delete[]', [
						'value' => template::ico('cancel'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0) . '/delete/' . $commentaires[$i],
						'onclick' => 'return confirm(\'Êtes-vous sûr de vouloir supprimer ce commentaire ?\');'
					])
				];
			}
			// Ajoute la liste des pages en dessous des commentaires
			self::$content .=
				template::openRow().
				template::table([11, 1], $commentairesTable).
				template::closeRow().
				$pagination['page'];
		}
		// Contenu de la page
		self::$content =
			template::title('Liste des commentaires').
			(self::$content ? self::$content : template::subTitle('Aucun commentaire...')).
			template::openRow().
			template::button('back', [
				'value' => 'Retour',
				'href' => helper::baseUrl() . $this->getUrl(0),
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Suppression d'un commentaire */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData([$this->getUrl(0), $this->getUrl(2)])) {
			return false;
		}
		// Suppression du commentaire
		else {
			// Supprime le commentaire
			$this->removeData([$this->getUrl(0), $this->getUrl(2)]);
			// Enregistre les données
			$this->saveData();
			// Notification de suppression
			$this->setNotification('Commentaire supprimé avec succès !');
			// Redirige vers le module de la page
			helper::redirect('module/' . $this->getUrl(0));
		}
	}
}

class guestbookMod extends common
{
	/** @var bool Bloque la mise en cache */
	public static $cache = false;
	
	/** Ajout de commentaire & liste des commentaires */
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Check la capcha
			if($this->getPost('capcha', helper::INT) !== $this->getPost('capchaFirstNumber', helper::INT) + $this->getPost('capchaSecondNumber', helper::INT))  {
				template::$notices['capcha'] = 'La somme indiquée est incorrecte';
			}
			// Crée le commentaire
			$this->setData([
				$this->getUrl(0),
				uniqid(),
				[
					'comment' => $this->getPost('comment'),
					'date' => time(),
					'mail' => $this->getPost('mail', helper::EMAIL),
					'name' => $this->getPost('name', helper::STRING)
				]
			]);
			// Enregistre les données
			$this->saveData();
			// Notification de création
			$this->setNotification('Merci pour votre commentaire !');
			// Redirection vers la première page des news
			helper::redirect($this->getUrl(0));
		}
		// Contenu de la page
		if($this->getData($this->getUrl(0))) {
			// Crée une pagination (retourne le premier commentaire et dernier commentaire de la page et la liste des pages
			$pagination = helper::pagination($this->getData($this->getUrl(0)), $this->getUrl(null, false));
			// Liste les commentaires en classant les classant par date en ordre décroissant
			$commentaires = helper::arrayCollumn($this->getData($this->getUrl(0)), 'date', 'SORT_DESC');
			// Crée l'affichage des commentaires en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				if($mail = $this->getData([$this->getUrl(0), $commentaires[$i], 'mail'])) {
					$name = template::a(
						'mailto:' . $mail,
						template::title($this->getData([$this->getUrl(0), $commentaires[$i], 'name']))
					);
				}
				else {
					$name = template::title($this->getData([$this->getUrl(0), $commentaires[$i], 'name']));
				}
				self::$content .=
					$name.
					template::subTitle(date('d/m/Y - H:i', $this->getData([$this->getUrl(0), $commentaires[$i], 'date']))).
					$this->getData([$this->getUrl(0), $commentaires[$i], 'comment']);
			}
			// Ajoute la liste des pages en dessous des commentaires
			self::$content .= $pagination['page'];
		}
		// Ajoute la liste des pages en dessous des commentaires
		self::$content =
			(self::$content ? self::$content : template::subTitle('Aucun commentaire...')).
			template::openForm().
			template::openRow().
			template::text('name', [
				'label' => 'Nom',
				'required' => true,
				'col' => 6
			]).
			template::newRow().
			template::text('mail', [
				'label' => 'Adresse mail (facultatif)',
				'col' => 6
			]).
			template::newRow().
			template::textarea('comment', [
				'label' => 'Commentaire',
				'col' => 8
			]).
			template::newRow().
			template::capcha('capcha', [
				'col' => 3
			]).
			template::newRow().
			template::submit('submit', [
				'value' => 'Ajouter',
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}
}