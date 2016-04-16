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

class newsAdm extends core
{
	/** @var string Nom du module */
	public static $name = 'Gestionnaire de news';

	/** @var array Liste des vues du module */
	public static $views = ['delete', 'edit'];

	/** MODULE : Ajout de news & liste des news */
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Incrémente la clef de la news pour éviter les doublons
			$key = helper::increment($this->getPost('title', helper::URL), $this->getData($this->getUrl(0)));
			// Crée la news
			$this->setData([
				$this->getUrl(0),
				$key,
				[
					'title' => $this->getPost('title', helper::STRING),
					'date' => time(),
					'content' => $this->getPost('content')
				]
			]);
			// Enregistre les données
			$this->saveData();
			// Notification de création
			$this->setNotification('Nouvelle news créée avec succès !');
			// Redirection vers la première page des news
			helper::redirect('module/' . $this->getUrl(0) . '#1'); // #1 pour forcer la redirection vers la liste des news
		}
		// Liste les news
		if($this->getData($this->getUrl(0))) {
			// Crée une pagination (retourne la première news et dernière news de la page et la liste des pages
			$pagination = helper::pagination($this->getData($this->getUrl(0)), $this->getUrl(null, false));
			// Liste les news en les classant par date en ordre décroissant
			$news = helper::arrayCollumn($this->getData($this->getUrl(0)), 'date', 'SORT_DESC');
			// Met en forme les news pour les afficher dans un tableau
			$newsTable = [];
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$newsTable[] = [
					$this->getData([$this->getUrl(0), $news[$i], 'title']),
					template::button('edit[]', [
						'value' => template::ico('pencil'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0) . '/edit/' . $news[$i]
					]),
					template::button('delete[]', [
						'value' => template::ico('cancel'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0) . '/delete/' . $news[$i],
						'onclick' => 'return confirm(\'Êtes-vous sûr de vouloir supprimer cette news ?\');'
					])
				];
			}
			// Ajoute la liste des pages en dessous des news
			self::$content .=
				template::openRow().
				template::table([10, 1, 1], $newsTable).
				template::closeRow().
				$pagination['page'];
		}
		// Contenu de la page
		self::$content =
			template::tabs([
				'Liste des news' =>
					(self::$content ? self::$content : template::subTitle('Aucune news...')).
					template::openRow().
					template::button('back', [
						'value' => 'Retour',
						'href' => helper::baseUrl() . 'edit/' . $this->getUrl(0),
						'col' => 2
					]).
					template::closeRow(),
				'Nouvelle news' =>
					template::openForm().
					template::openRow().
					template::text('title', [
						'label' => 'Titre de la news',
						'required' => 'required'
					]).
					template::newRow().
					template::textarea('content', [
						'editor' => true
					]).
					template::newRow().
					template::button('back', [
						'value' => 'Retour',
						'href' => helper::baseUrl() . 'edit/' . $this->getUrl(0),
						'col' => 2
					]).
					template::submit('submit', [
						'value' => 'Créer',
						'col' => 2,
						'offset' => 8
					]).
					template::closeRow().
					template::closeForm()
			]);
	}

	/**
	 * MODULE : Édition d'une news */
	public function edit()
	{
		// Erreur 404
		if(!$this->getData([$this->getUrl(0), $this->getUrl(2)])) {
			return false;
		}
		// Traitement du formulaire
		elseif($this->getPost('submit')) {
			// Modifie la clef de la news si le titre a été modifié
			$key = $this->getPost('title') ? $this->getPost('title', helper::URL) : $this->getUrl(2);
			// Sauvegarde la date de création de la news
			$date = $this->getData([$this->getUrl(0), $this->getUrl(2), 'date']);
			// Si la clef à changée
			if($key !== $this->getUrl(2)) {
				// Incrémente la nouvelle clef de la news pour éviter les doublons
				$key = helper::increment($key, $this->getData($this->getUrl(0)));
				// Supprime l'ancienne news
				$this->removeData([$this->getUrl(0), $this->getUrl(2)]);
			}
			// Modifie la news ou en crée une nouvelle si la clef a changée
			$this->setData([
				$this->getUrl(0),
				$key,
				[
					'title' => $this->getPost('title', helper::STRING),
					'date' => $date,
					'content' => $this->getPost('content')
				]
			]);
			// Enregistre les données
			$this->saveData();
			// Notification de modification
			$this->setNotification('News modifiée avec succès !');
			// Redirection vers la première page des news
			helper::redirect('module/' . $this->getUrl(0));
		}
		// Contenu de la page
		self::$content =
			template::openForm().
			template::openRow().
			template::text('title', [
				'label' => 'Titre de la news',
				'value' => $this->getData([$this->getUrl(0), $this->getUrl(2), 'title']),
				'required' => 'required'
			]).
			template::newRow().
			template::textarea('content', [
				'editor' => true,
				'value' => $this->getData([$this->getUrl(0), $this->getUrl(2), 'content'])
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
			template::closeRow();
			template::closeForm();
	}

	/** MODULE : Suppression d'une news */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData([$this->getUrl(0), $this->getUrl(2)])) {
			return false;
		}
		// Suppression de la news
		else {
			// Supprime la news
			$this->removeData([$this->getUrl(0), $this->getUrl(2)]);
			// Enregistre les données
			$this->saveData();
			// Notification de suppression
			$this->setNotification('News supprimée avec succès !');
			// Redirige vers le module de la page
			helper::redirect('module/' . $this->getUrl(0));
		}
	}
}

class newsMod extends core
{
	/** MODULE : Liste des news */
	public function index()
	{
		// Erreur 404
		if(!$this->getData($this->getUrl(0))) {
			return false;
		}
		// Contenu de la page
		else {
			// Crée une pagination (retourne la première news et dernière news de la page et la liste des pages
			$pagination = helper::pagination($this->getData($this->getUrl(0)), $this->getUrl(null, false));
			// Liste les news en classant les classant par date en ordre décroissant
			$news = helper::arrayCollumn($this->getData($this->getUrl(0)), 'date', 'SORT_DESC');
			// Crée l'affichage des news en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				self::$content .=
					template::title($this->getData([$this->getUrl(0), $news[$i], 'title'])).
					template::subTitle(date('d/m/Y - H:i', $this->getData([$this->getUrl(0), $news[$i], 'date']))).
					$this->getData([$this->getUrl(0), $news[$i], 'content']);
			}
			// Ajoute la liste des pages en dessous des news
			self::$content .= $pagination['page'];
		}
	}
}