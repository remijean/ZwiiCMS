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

class common {

	const DISPLAY_RAW = 0;
	const DISPLAY_JSON = 1;
	const DISPLAY_LAYOUT_BLANK = 2;
	const DISPLAY_LAYOUT_MAIN = 3;
	const DISPLAY_LAYOUT_LIGHT = 4;
	const GROUP_BANNED = -1;
	const GROUP_VISITOR = 0;
	const GROUP_MEMBER = 1;
	const GROUP_MODERATOR = 2;
	const GROUP_ADMIN = 3;
	const ZWII_VERSION = '8.1.1';

	public static $actions = [];
	public static $coreModuleIds = [
		'config',
		'install',
		'page',
		'sitemap',
		'theme',
		'user'
	];
	private $data = [];
	private $defaultData = [
		'config' => [
			'analyticsId' => '',
			'autoBackup' => true,
			'cookieConsent' => true,
			'favicon' => 'favicon.ico',
			'homePageId' => 'accueil',
			'language' => 'fr_FR',
			'metaDescription' => 'Zwii est un CMS sans base de données qui permet à ses utilisateurs de créer et gérer facilement un site web sans aucune connaissance en programmation.',
			'social' => [
				'facebookId' => 'ZwiiCMS',
				'googleplusId' => '',
				'instagramId' => '',
				'pinterestId' => '',
				'twitterId' => 'ZwiiCMS',
				'youtubeId' => ''
			],
			'timezone' => 'Europe/Paris',
			'title' => 'Zwii, votre site en quelques clics !'
		],
		'core' => [
			'dataVersion' => 0,
			'lastBackup' => 0,
			'lastClearTmp' => 0
		],
		'page' => [
			'accueil' => [
				'content' => "<p><h3>Bienvenue sur votre nouveau site Zwii !</h3></p>\r\n<p><strong>Un mail contenant un récapitulatif de votre installation vient de vous être envoyé.</strong></strong></p>\r\n<p>Connectez-vous dès maintenant à votre espace membre afin de créer un site à votre image ! Vous allez pouvoir personnaliser le thème, créer des pages, ajouter des utilisateurs et bien plus encore !</p>\r\n<p>Si vous avez besoin d'aide ou si vous voulez des informations sur Zwii, n'hésitez pas à jeter un œil à notre <a title='Forum' href='http://forum.zwiicms.com/'>forum</a> et à nous suivre sur <a title='Facebook' href='https://www.facebook.com/ZwiiCMS/'>Facebook</a> et <a title='Twiiter' href='https://twitter.com/ZwiiCMS'>Twiiter</a>.</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => '',
				'position' => 1,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => false,
				'title' => 'Accueil'
			],
			'enfant' => [
				'content' => "<p>Vous pouvez assigner des parents à vos pages afin de mieux organiser votre menu !</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat magna sit amet sapien gravida commodo. In hendrerit ut nulla et bibendum. Morbi fringilla dolor arcu, sit amet porta nibh sodales lacinia. Donec molestie dui lacus, ac consectetur neque posuere at. Vestibulum aliquam, urna a euismod mattis, diam tortor consectetur elit, quis feugiat magna dolor eget nisl. Etiam id purus nulla. Vestibulum tincidunt massa vitae iaculis volutpat.</p>\r\n<p>In eget auctor dui, a tincidunt est. Nam felis magna, venenatis vel ultrices ut, luctus et orci. Etiam vitae ligula sollicitudin, ultricies felis et, bibendum justo. Duis et imperdiet neque. Integer ultrices nulla sit amet lorem molestie, vel pulvinar tellus pulvinar. Cras laoreet risus in est feugiat fringilla. Nullam quis ornare odio, ut pretium enim.</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => 'accueil',
				'position' => 1,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => false,
				'title' => 'Enfant'
			],
			'cachee' => [
				'content' => "<p>Cette page n'est visible que par les membres de votre site !</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque placerat magna sit amet sapien gravida commodo. In hendrerit ut nulla et bibendum. Morbi fringilla dolor arcu, sit amet porta nibh sodales lacinia. Donec molestie dui lacus, ac consectetur neque posuere at. Vestibulum aliquam, urna a euismod mattis, diam tortor consectetur elit, quis feugiat magna dolor eget nisl. Etiam id purus nulla. Vestibulum tincidunt massa vitae iaculis volutpat.</p>\r\n<p>In eget auctor dui, a tincidunt est. Nam felis magna, venenatis vel ultrices ut, luctus et orci. Etiam vitae ligula sollicitudin, ultricies felis et, bibendum justo. Duis et imperdiet neque. Integer ultrices nulla sit amet lorem molestie, vel pulvinar tellus pulvinar. Cras laoreet risus in est feugiat fringilla. Nullam quis ornare odio, ut pretium enim.</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => '',
				'position' => 2,
				'group' => self::GROUP_MEMBER,
				'targetBlank' => false,
				'title' => 'Cachée'
			],
			'blog' => [
				'content' => "<p>Cette page contient une instance du module de blog. Cliquez sur un article afin de le lire et de poster des commentaires.</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'blog',
				'parentPageId' => '',
				'position' => 3,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => false,
				'title' => 'Blog'
			],
			'galeries' => [
				'content' => "<p>Cette page contient une instance du module de galeries photos. Cliquez sur la galerie ci-dessous afin de voir les photos qu'elle contient.</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'gallery',
				'parentPageId' => '',
				'position' => 4,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => false,
				'title' => 'Galeries'
			],
			'site-de-zwii' => [
				'content' => "",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'redirection',
				'parentPageId' => '',
				'position' => 5,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => true,
				'title' => 'Site de Zwii'
			],
			'contact' => [
				'content' => "<p>Cette page contient un exemple de formulaire conçu à partir du module de génération de formulaires. Il est configuré pour envoyer les données saisies par mail aux administrateurs du site.</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'form',
				'parentPageId' => '',
				'position' => 6,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => false,
				'title' => 'Contact'
			]
		],
		'module' => [
			'blog' => [
				'mon-premier-article' => [
					'closeComment' => false,
					'comment' => [
						'58e11d09e5aff' => [
							'author' => 'Rémi',
							'content' => 'Article bien rédigé et très pertinent, bravo !',
							'createdOn' => 1421786100,
							'userId' => ''
						]
					],
					'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a placerat metus. Morbi luctus laoreet dolor et euismod. Phasellus eget eros ac eros pretium tincidunt. Sed maximus magna lectus, non vestibulum sapien pretium maximus. Donec convallis leo tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras convallis lacus eu risus gravida varius. Etiam mattis massa vitae eros placerat bibendum.</p>\r\n<p>Vivamus tempus magna augue, in bibendum quam blandit at. Morbi felis tortor, suscipit ut ipsum ut, volutpat consectetur orci. Nulla tincidunt quis ligula non viverra. Sed pretium dictum blandit. Donec fringilla, nunc at dictum pretium, arcu massa viverra leo, et porta turpis ipsum eget risus. Quisque quis maximus purus, in elementum arcu. Donec nisi orci, aliquam non luctus non, congue volutpat massa. Curabitur sed risus congue, porta arcu vel, tincidunt nisi. Duis tincidunt quam ut velit maximus ornare. Nullam sagittis, ante quis pharetra hendrerit, lorem massa dapibus mi, a hendrerit dolor odio nec augue. Nunc sem nisl, tincidunt vitae nunc et, viverra tristique diam. In eget dignissim lectus. Nullam volutpat lacus id ex dapibus viverra. Pellentesque ultricies lorem ut nunc elementum volutpat. Cras id ultrices justo.</p>\r\n<p>Phasellus nec erat leo. Praesent at sem nunc. Vestibulum quis condimentum turpis. Cras semper diam vitae enim fringilla, ut fringilla mauris efficitur. In nec porttitor urna. Nam eros leo, vehicula eget lobortis sed, gravida id mauris. Nulla bibendum nunc tortor, non bibendum justo consectetur vel. Phasellus nec risus diam. In commodo tellus nec nulla fringilla, nec feugiat nunc consectetur. Etiam non eros sodales, sodales lacus vel, finibus leo. Quisque hendrerit tristique congue. Phasellus nec augue vitae libero elementum facilisis. Mauris pretium ornare nisi, non scelerisque velit consectetur sit amet.</p>",
					'picture' => 'gallery/landscape/meadow.jpg',
					'publishedOn' => 1420903200,
					'state' => true,
					'title' => 'Mon premier article',
					'userId' => '' // Géré au moment de l'installation
				],
				'mon-deuxieme-article' => [
					'closeComment' => false,
					'comment' => [],
					'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lobortis eros pharetra metus rutrum pretium et sagittis mauris. Donec commodo venenatis sem nec suscipit. In tempor sollicitudin scelerisque. Etiam quis nibh eleifend, congue nisl quis, ultricies ipsum. Integer at est a eros vulputate pellentesque eu vitae tellus. Nullam suscipit quam nisl. Vivamus dui odio, luctus ac fringilla ultrices, eleifend vel sapien. Integer sem ex, lobortis eu mattis eu, condimentum non libero. Aliquam non porttitor elit, eu hendrerit neque. Praesent tortor urna, tincidunt sed dictum id, rutrum tempus sapien.</p>\r\n<p>Donec accumsan ante ac odio laoreet porttitor. Pellentesque et leo a leo scelerisque mattis id vel elit. Quisque egestas congue enim nec semper. Morbi mollis nibh sapien. Nunc quis fringilla lorem. Donec vel venenatis nunc. Donec lectus velit, tempor sit amet dui sed, consequat commodo enim. Nam porttitor neque semper, dapibus nunc bibendum, lobortis urna. Morbi ullamcorper molestie lectus a elementum. Curabitur eu cursus orci, sed tristique justo. In massa lacus, imperdiet eu elit quis, consectetur maximus magna. Integer suscipit varius ante vitae egestas. Morbi scelerisque fermentum ipsum, euismod faucibus mi tincidunt id. Sed at consectetur velit. Ut fermentum nunc nibh, at commodo felis lacinia nec.</p>\r\n<p>Nullam a justo quis lectus facilisis semper eget quis sem. Morbi suscipit erat sem, non fermentum nunc luctus vel. Proin venenatis quam ut arcu luctus efficitur. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam sollicitudin tristique nunc nec convallis. Maecenas id tortor semper, tempus nisl laoreet, cursus lacus. Aliquam sagittis est in leo congue, a pharetra felis aliquet. Nulla gravida lobortis sapien, quis viverra enim ullamcorper sed. Donec ultrices sem eu volutpat dapibus. Nam euismod, tellus eu congue mollis, massa nisi finibus odio, vitae porta arcu urna ac lorem. Sed faucibus dignissim pretium. Pellentesque eget ante tellus. Pellentesque a elementum odio, sit amet vulputate diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hendrerit consequat dolor, malesuada pellentesque tellus molestie non. Aenean quis purus a lectus pellentesque laoreet.</p>",
					'picture' => 'gallery/landscape/desert.jpg',
					'publishedOn' => 1421748000,
					'state' => true,
					'title' => 'Mon deuxième article',
					'userId' => '' // Géré au moment de l'installation
				],
				'mon-troisieme-article' => [
					'closeComment' => true,
					'comment' => [],
					'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut tempus nibh. Cras eget iaculis justo, ac laoreet lacus. Nunc tellus nulla, auctor id hendrerit eu, pellentesque in sapien. In hac habitasse platea dictumst. Aliquam leo urna, hendrerit id nunc eget, finibus maximus dolor. Sed rutrum sapien consectetur, tincidunt nulla at, blandit quam. Duis ex enim, vehicula vel nisi vitae, lobortis volutpat nisl. Vivamus enim libero, euismod nec risus vel, interdum placerat elit. In cursus sapien condimentum dui imperdiet, sed lobortis ante consectetur. Maecenas hendrerit eget felis non consequat.</p>\r\n<p>Nullam nec risus non velit efficitur tempus eget tincidunt mauris. Etiam venenatis leo id justo sagittis, commodo dignissim sapien tristique. Vivamus finibus augue malesuada sapien gravida rutrum. Integer mattis lectus ac pulvinar scelerisque. Integer suscipit feugiat metus, ac molestie odio suscipit eget. Fusce at elit in tellus venenatis finibus id sit amet magna. Integer sodales luctus neque blandit posuere. Cras pellentesque dictum lorem eget vestibulum. Quisque vitae metus non nisi efficitur rhoncus ut vitae ipsum. Donec accumsan massa at est faucibus lacinia. Quisque imperdiet luctus neque eu vestibulum. Phasellus pellentesque felis ligula, id imperdiet elit ultrices eu.</p>",
					'picture' => 'gallery/landscape/iceberg.jpg',
					'publishedOn' => 1423154400,
					'state' => true,
					'title' => 'Mon troisième article',
					'userId' => '' // Géré au moment de l'installation
				]
			],
			'galeries' => [
				'beaux-paysages' => [
					'config' => [
						'name' => 'Beaux paysages',
						'directory' => 'site/file/source/gallery/landscape'
					],
					'legend' => [
						'desert.jpg' => 'Un désert',
						'iceberg.jpg' => 'Un iceberg',
						'meadow.jpg' => 'Une prairie'
					],
					'espace' => [
						'config' => [
							'name' => 'Espace',
							'directory' => 'site/file/source/gallery/space'
						],
						'legend' => [
							'earth.jpg' => 'La Terre et la Lune',
							'cosmos.jpg' => 'Le cosmos',
							'nebula.jpg' => 'Une nébuleuse'
						]
					]
				]
			],
			'site-de-zwii' => [
				'url' => 'http://zwiicms.com/',
				'count' => 0
			],
			'contact' => [
				'config' => [
					'button' => '',
					'capcha' => true,
					'group' => self::GROUP_ADMIN,
					'pageId' => '',
					'subject' => ''
				],
				'data' => [],
				'input' => [
					[
						'name' => 'Adresse mail',
						'position' => 1,
						'required' => true,
						'type' => 'mail',
						'values' => ''
					],
					[
						'name' => 'Sujet',
						'position' => 2,
						'required' => true,
						'type' => 'text',
						'values' => ''
					],
					[
						'name' => 'Message',
						'position' => 3,
						'required' => true,
						'type' => 'textarea',
						'values' => ''
					]
				]
			]
		],
		'user' => [],
		'theme' => [
			'body' => [
				'backgroundColor' => 'rgba(235, 238, 242, 1)',
				'image' => '',
				'imageAttachment' => 'scroll',
				'imageRepeat' => 'no-repeat',
				'imagePosition' => 'top center',
				'imageSize' => 'auto'
			],
			'button' => [
				'backgroundColor' => 'rgba(71, 123, 184, 1)'
			],
			'footer' => [
				'backgroundColor' => 'rgba(255, 255, 255, 1)',
				'copyrightAlign' => 'center',
				'height' => '10px',
				'loginLink' => true,
				'margin' => false,
				'position' => 'site',
				'socialsAlign' => 'center',
				'text' => '',
				'textAlign' => 'center'
			],
			'header' => [
				'backgroundColor' => 'rgba(255, 255, 255, 1)',
				'font' => 'Oswald',
				'fontWeight' => 'normal',
				'height' => '150px',
				'image' => '',
				'imagePosition' => 'center center',
				'imageRepeat' => 'no-repeat',
				'margin' => false,
				'position' => 'site',
				'textAlign' => 'center',
				'textColor' => 'rgba(33, 34, 35, 1)',
				'textHide' => false,
				'textTransform' => 'none'
			],
			'link' => [
				'textColor' => 'rgba(71, 123, 184, 1)'
			],
			'menu' => [
				'backgroundColor' => 'rgba(62, 107, 159, 1)',
				'fontWeight' => 'normal',
				'height' => '15px 10px',
				'loginLink' => true,
				'margin' => false,
				'position' => 'site-second',
				'textAlign' => 'left',
				'textTransform' => 'none'
			],
			'site' => [
				'width' => '960px'
			],
			'text' => [
				'font' => 'Open+Sans'
			],
			'title' => [
				'font' => 'Oswald',
				'fontWeight' => 'normal',
				'textColor' => 'rgba(71, 123, 184, 1)',
				'textTransform' => 'none'
			]
		]
	];
	private $hierarchy = [
		'all' => [],
		'visible' => []
	];
	private $input = [
		'_COOKIE' => [],
		'_POST' => []
	];
	public static $inputBefore = [];
	public static $inputNotices = [];
	public $output = [
		'access' => true,
		'content' => '',
		'display' => self::DISPLAY_LAYOUT_MAIN,
		'metaDescription' => '',
		'metaTitle' => '',
		'notification' => '',
		'redirect' => '',
		'script' => '',
		'showBarEditButton' => false,
		'showPageContent' => false,
		'state' => false,
		'style' => '',
		'title' => null, // Null car un titre peut être vide
		// Trié par ordre d'exécution
		'vendor' => [
			'jquery',
			'normalize',
			'lity',
			'filemanager',
			// 'flatpickr', Désactivé par défaut
			// 'tinycolorpicker', Désactivé par défaut
			// 'tinymce', Désactivé par défaut
			'zwiico'
		],
		'view' => ''
	];
	public static $groups = [
		self::GROUP_BANNED => 'Banni',
		self::GROUP_VISITOR => 'Visiteur',
		self::GROUP_MEMBER => 'Membre',
		self::GROUP_MODERATOR => 'Modérateur',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $groupEdits = [
		self::GROUP_BANNED => 'Banni',
		self::GROUP_MEMBER => 'Membre',
		self::GROUP_MODERATOR => 'Modérateur',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $groupNews = [
		self::GROUP_MEMBER => 'Membre',
		self::GROUP_MODERATOR => 'Modérateur',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $groupPublics = [
		self::GROUP_VISITOR => 'Visiteur',
		self::GROUP_MEMBER => 'Membre',
		self::GROUP_MODERATOR => 'Modérateur',
		self::GROUP_ADMIN => 'Administrateur'
	];
	public static $i18n = [];
	public static $timezone;
	private $url = '';
	private $user = [];

	/**
	 * Constructeur commun
	 */
	public function __construct() {
		// Extraction des données http
		if(isset($_POST)) {
			$this->input['_POST'] = $_POST;
		}
		if(isset($_COOKIE)) {
			$this->input['_COOKIE'] = $_COOKIE;
		}
		// Génère le fichier de donnée
		if(file_exists('site/data/data.json') === false) {
			$this->setData([$this->defaultData]);
			$this->saveData();
			chmod('site/data/data.json', 0644);
		}
		// Import des données
		if($this->data === []) {
			// Trois tentatives
			for($i = 0; $i < 3; $i++) {
				$this->setData([json_decode(file_get_contents('site/data/data.json'), true)]);
				if($this->data) {
					break;
				}
				elseif($i === 2) {
					exit('Unable to read data file.');
				}
				// Pause de 10 millisecondes
				usleep(10000);
			}
		}
		// Mise à jour
		$this->update();
		// Utilisateur connecté
		if($this->user === []) {
			$this->user = $this->getData(['user', $this->getInput('ZWII_USER_ID')]);
		}
		// Construit la liste des pages parents/enfants
		if($this->hierarchy['all'] === []) {
			$pages = helper::arrayCollumn($this->getData(['page']), 'position', 'SORT_ASC');
			// Parents
			foreach($pages as $pageId => $pagePosition) {
				if(
					// Page parent
					$this->getData(['page', $pageId, 'parentPageId']) === ""
					// Ignore les pages dont l'utilisateur n'a pas accès
					AND (
						$this->getData(['page', $pageId, 'group']) === self::GROUP_VISITOR
						OR (
							$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
							AND $this->getUser('group') >= $this->getData(['page', $pageId, 'group'])
						)
					)
				) {
					if($pagePosition !== 0) {
						$this->hierarchy['visible'][$pageId] = [];
					}
					$this->hierarchy['all'][$pageId] = [];
				}
			}
			// Enfants
			foreach($pages as $pageId => $pagePosition) {
				if(
					// Page parent
					$parentId = $this->getData(['page', $pageId, 'parentPageId'])
					// Ignore les pages dont l'utilisateur n'a pas accès
					AND (
						(
							$this->getData(['page', $pageId, 'group']) === self::GROUP_VISITOR
							AND $this->getData(['page', $parentId, 'group']) === self::GROUP_VISITOR
						)
						OR (
							$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
							AND $this->getUser('group') >= $this->getData(['page', $parentId, 'group'])
							AND $this->getUser('group') >= $this->getData(['page', $pageId, 'group'])
						)
					)
				) {
					if($pagePosition !== 0) {
						$this->hierarchy['visible'][$parentId][] = $pageId;
					}
					$this->hierarchy['all'][$parentId][] = $pageId;
				}
			}
		}
		// Construit l'url
		if($this->url === '') {
			if($url = $_SERVER['QUERY_STRING']) {
				$this->url = $url;
			}
			else {
				$this->url = $this->getData(['config', 'homePageId']);
			}
		}
	}

	/**
	 * Ajoute les valeurs en sortie
	 * @param array $output Valeurs en sortie
	 */
	public function addOutput($output) {
		$this->output = array_merge($this->output, $output);
	}

	/**
	 * Ajoute une notice de champ obligatoire
	 * @param string $key Clef du champ
	 */
	public function addRequiredInputNotices($key) {
		// La clef est un tableau
		if(preg_match('#\[(.*)\]#', $key, $secondKey)) {
			$firstKey = explode('[', $key)[0];
			$secondKey = $secondKey[1];
			if(empty($this->input['_POST'][$firstKey][$secondKey])) {
				common::$inputNotices[$firstKey . '_' . $secondKey] = 'Obligatoire';
			}
		}
		// La clef est une chaine
		elseif(empty($this->input['_POST'][$key])) {
			common::$inputNotices[$key] = 'Obligatoire';
		}
	}

	/**
	 * Check du token CSRF (true = bo
	 */
	public function checkCSRF() {
		return ((empty($_POST['csrf']) OR hash_equals($_SESSION['csrf'], $_POST['csrf']) === false) === false);
	}

	/**
	 * Supprime des données
	 * @param array $keys Clé(s) des données
	 */
	public function deleteData($keys) {
		switch(count($keys)) {
			case 1 :
				unset($this->data[$keys[0]]);
				break;
			case 2:
				unset($this->data[$keys[0]][$keys[1]]);
				break;
			case 3:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]]);
				break;
			case 4:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]]);
				break;
			case 5:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$keys[4]]);
				break;
			case 6:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$keys[4]][$keys[5]]);
				break;
			case 7:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$keys[4]][$keys[5]][$keys[6]]);
				break;
		}
	}

	/**
	 * Accède aux données
	 * @param array $keys Clé(s) des données
	 * @return mixed
	 */
	public function getData($keys = null) {
		// Retourne l'ensemble des données
		if($keys === null) {
			return $this->data;
		}
		// Décent dans les niveaux de la variable $data
		$data = $this->data;
		foreach($keys as $key) {
			// Si aucune donnée n'existe retourne null
			if(isset($data[$key]) === false) {
				return null;
			}
			// Sinon décent dans les niveaux
			else {
				$data = $data[$key];
			}
		}
		// Retourne les données
		return $data;
	}

	/**
	 * Accède à la liste des pages parents et de leurs enfants ou aux enfants d'une page parent
	 * @param int $parentId Id de la page parent
	 * @param bool $onlyVisible Affiche seulement les pages visibles
	 * @return array
	 */
	public function getHierarchy($parentId = null, $onlyVisible = true) {
		$hierarchy = $onlyVisible ? $this->hierarchy['visible'] : $this->hierarchy['all'];
		// Enfants d'un parent
		if($parentId) {
			if(array_key_exists($parentId, $hierarchy)) {
				return $hierarchy[$parentId];
			}
			else {
				return [];
			}
		}
		// Parents et leurs enfants
		else {
			return $hierarchy;
		}
	}

	/**
	 * Accède à une valeur des variables http (ordre de recherche en l'absence de type : _COOKIE, _POST)
	 * @param string $key Clé de la valeur
	 * @param int $filter Filtre à appliquer à la valeur
	 * @param bool $required Champ requis
	 * @return mixed
	 */
	public function getInput($key, $filter = helper::FILTER_STRING_SHORT, $required = false) {
		// La clef est un tableau
		if(preg_match('#\[(.*)\]#', $key, $secondKey)) {
			$firstKey = explode('[', $key)[0];
			$secondKey = $secondKey[1];
			foreach($this->input as $type => $values) {
				if(array_key_exists($firstKey, $values)) {
					// Champ obligatoire
					if($required) {
						$this->addRequiredInputNotices($key);
					}
					// Retourne la valeur filtrée
					if($filter) {
						return helper::filter($this->input[$type][$firstKey][$secondKey], $filter);
					}
					// Retourne la valeur
					else {
						return $this->input[$type][$firstKey][$secondKey];
					}
				}
			}
		}
		// La clef est une chaine
		else {
			foreach($this->input as $type => $values) {
				if(array_key_exists($key, $values)) {
					// Champ obligatoire
					if($required) {
						$this->addRequiredInputNotices($key);
					}
					// Retourne la valeur filtrée
					if($filter) {
						return helper::filter($this->input[$type][$key], $filter);
					}
					// Retourne la valeur
					else {
						return $this->input[$type][$key];
					}
				}
			}
		}

		// Sinon retourne null
		return helper::filter(null, $filter);
	}

	/**
	 * Accède à une partie l'url ou à l'url complète
	 * @param int $key Clé de l'url
	 * @return string|null
	 */
	public function getUrl($key = null) {
		// Url complète
		if($key === null) {
			return $this->url;
		}
		// Une partie de l'url
		else {
			$url = explode('/', $this->url);
			return array_key_exists($key, $url) ? $url[$key] : null;
		}
	}

	/**
	 * Accède à l'utilisateur connecté
	 * @param int $key Clé de la valeur
	 * @return string|null
	 */
	public function getUser($key) {
		if(is_array($this->user) === false) {
			return false;
		}
		elseif($key === 'id') {
			return $this->getInput('ZWII_USER_ID');
		}
		elseif(array_key_exists($key, $this->user)) {
			return $this->user[$key];
		}
		else {
			return false;
		}
	}

	/**
	 * Check qu'une valeur est transmise par la méthode _POST
	 * @return bool
	 */
	public function isPost() {
		return ($this->checkCSRF() AND $this->input['_POST'] !== []);
	}

	/**
	 * Enregistre les données
	 */
	public function saveData() {
		// Trois tentatives
		for($i = 0; $i < 3; $i++) {
			if(file_put_contents('site/data/data.json', json_encode($this->getData()), LOCK_EX) !== false) {
				break;
			}
			// Pause de 10 millisecondes
			usleep(10000);
		}
	}

	/**
	 * Envoi un mail
	 * @param string|array $to Destinataire
	 * @param string $subject Sujet
	 * @param string $content Contenu
	 * @return bool
	 */
	public function sendMail($to, $subject, $content) {
		// Layout
		ob_start();
		include 'core/layout/mail.php';
		$layout = ob_get_clean();
		// Mail
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';
		$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
		$mail->setFrom('no-reply@' . $host, $this->getData(['config', 'title']));
		$mail->addReplyTo('no-reply@' . $host, $this->getData(['config', 'title']));
		if(is_array($to)) {
			foreach($to as $userMail) {
				$mail->addAddress($userMail);
			}
		}
		else {
			$mail->addAddress($to);
		}
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $layout;
		$mail->AltBody = strip_tags($content);
		if($mail->send()) {
			return true;
		}
		else {
			return $mail->ErrorInfo;
		}
	}

	/**
	 * Insert des données
	 * @param array $keys Clé(s) des données
	 */
	public function setData($keys) {
		switch(count($keys)) {
			case 1:
				$this->data = $keys[0];
				break;
			case 2:
				$this->data[$keys[0]] = $keys[1];
				break;
			case 3:
				$this->data[$keys[0]][$keys[1]] = $keys[2];
				break;
			case 4:
				$this->data[$keys[0]][$keys[1]][$keys[2]] = $keys[3];
				break;
			case 5:
				$this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]] = $keys[4];
				break;
			case 6:
				$this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$keys[4]] = $keys[5];
				break;
			case 7:
				$this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]][$keys[4]][$keys[5]] = $keys[6];
				break;
		}
	}

	/**
	 * Mises à jour
	 */
	private function update() {
		// Version 8.1.0
		if($this->getData(['core', 'dataVersion']) < 810) {
			$this->setData(['config', 'timezone', 'Europe/Paris']);
			$this->setData(['core', 'dataVersion', 810]);
			$this->saveData();
		}
	}

}

class core extends common {

	/**
	 * Constructeur du coeur
	 */
	public function __construct() {
		parent::__construct();
		// Token CSRF
		if(empty($_SESSION['csrf'])) {
			$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
		}
		// Fuseau horaire
		self::$timezone = $this->getData(['config', 'timezone']); // Utile pour transmettre le timezone à la classe helper
		date_default_timezone_set(self::$timezone);
		// Supprime les fichiers temporaires
		$lastClearTmp = mktime(0, 0, 0);
		if($lastClearTmp > $this->getData(['core', 'lastClearTmp']) + 86400) {
			$iterator = new DirectoryIterator('core/tmp/');
			foreach($iterator as $fileInfos) {
				if($fileInfos->isFile() AND $fileInfos->getBasename() !== '.gitkeep') {
					@unlink($fileInfos->getPathname());
				}
			}
			// Date de la dernière suppression
			$this->setData(['core', 'lastClearTmp', $lastClearTmp]);
			// Enregistre les données
			$this->saveData();
		}
		// Backup automatique des données
		$lastBackup = mktime(0, 0, 0);
		if(
			$this->getData(['config', 'autoBackup'])
			AND $lastBackup > $this->getData(['core', 'lastBackup']) + 86400
			AND $this->getData(['user']) // Pas de backup pendant l'installation
		) {
			// Copie du fichier de données
			copy('site/data/data.json', 'site/backup/' . date('Y-m-d', $lastBackup) . '.json');
			// Date du dernier backup
			$this->setData(['core', 'lastBackup', $lastBackup]);
			// Enregistre les données
			$this->saveData();
			// Supprime les backups de plus de 30 jours
			$iterator = new DirectoryIterator('site/backup/');
			foreach($iterator as $fileInfos) {
				if(
					$fileInfos->isFile()
					AND $fileInfos->getBasename() !== '.htaccess'
					AND strtotime($fileInfos->getBasename('.json')) + (86400 * 30) < time()
				) {
					@unlink($fileInfos->getPathname());
				}
			}
		}
		// Crée le fichier de personnalisation
		if(file_exists('site/data/theme.css') === false) {
			file_put_contents('site/data/theme.css', '');
			chmod('site/data/theme.css', 0644);
		}
		// Check la version
		$cssVersion = preg_split('/\*+/', file_get_contents('site/data/theme.css'));
		if(empty($cssVersion[1]) OR $cssVersion[1] !== md5(json_encode($this->getData(['theme'])))) {
			// Version
			$css = '/*' . md5(json_encode($this->getData(['theme']))) . '*/';
			// Import des polices de caractères
			$css .= '@import url("https://fonts.googleapis.com/css?family=' . $this->getData(['theme', 'text', 'font']) . '|' . $this->getData(['theme', 'title', 'font']) . '|' . $this->getData(['theme', 'header', 'font']) . '");';
			// Fond du site
			$colors = helper::colorVariants($this->getData(['theme', 'body', 'backgroundColor']));
			$css .= 'body{background-color:' . $colors['normal'] . ';font-family:"' . str_replace('+', ' ', $this->getData(['theme', 'text', 'font'])) . '",sans-serif}';
			if($themeBodyImage = $this->getData(['theme', 'body', 'image'])) {
				$css .= 'body{background-image:url("../file/source/' . $themeBodyImage . '");background-position:' . $this->getData(['theme', 'body', 'imagePosition']) . ';background-attachment:' . $this->getData(['theme', 'body', 'imageAttachment']) . ';background-size:' . $this->getData(['theme', 'body', 'imageSize']) . ';background-repeat:' . $this->getData(['theme', 'body', 'imageRepeat']) . '}';
			}
			// Site
			$css .= '.container{max-width:' . $this->getData(['theme', 'site', 'width']) . '}';
			$css .= '#site{border-radius:' . $this->getData(['theme', 'site', 'radius']) . ';box-shadow:' . $this->getData(['theme', 'site', 'shadow']) . ' #212223}';
			$colors = helper::colorVariants($this->getData(['theme', 'button', 'backgroundColor']));
			$css .= '.speechBubble,.button,button[type=\'submit\'],.pagination a,input[type=\'checkbox\']:checked + label:before,input[type=\'radio\']:checked + label:before,.helpContent{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '!important}';
			$css .= '.tabTitle.current,.helpButton span{color:' . $colors['normal'] . '}';
			$css .= 'input[type=\'text\']:hover,input[type=\'password\']:hover,.inputFile:hover,select:hover,textarea:hover{border-color:' . $colors['normal'] . '}';
			$css .= '.speechBubble:before{border-color:' . $colors['normal'] . ' transparent transparent transparent}';
			$css .= '.button:hover,button[type=\'submit\']:hover,.pagination a:hover,input[type=\'checkbox\']:not(:active):checked:hover + label:before,input[type=\'checkbox\']:active + label:before,input[type=\'radio\']:checked:hover + label:before,input[type=\'radio\']:not(:checked):active + label:before{background-color:' . $colors['darken'] . '}';
			$css .= '.helpButton span:hover{color:' . $colors['darken'] . '}';
			$css .= '.button:active,button[type=\'submit\']:active,.pagination a:active{background-color:' . $colors['veryDarken'] . '}';
			$colors = helper::colorVariants($this->getData(['theme', 'link', 'textColor']));
			$css .= 'a{color:' . $colors['normal'] . '}';
			$css .= 'a:hover{color:' . $colors['darken'] . '}';
			$css .= 'a:active{color:' . $colors['veryDarken'] . '}';
			$colors = helper::colorVariants($this->getData(['theme', 'title', 'textColor']));
			$css .= 'h1,h2,h3,h4,h5,h6{color:' . $colors['normal'] . ';font-family:"' . str_replace('+', ' ', $this->getData(['theme', 'title', 'font'])) . '",sans-serif;font-weight:' . $this->getData(['theme', 'title', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'title', 'textTransform']) . '}';
			// Bannière
			$colors = helper::colorVariants($this->getData(['theme', 'header', 'backgroundColor']));
			if($this->getData(['theme', 'header', 'margin'])) {
				if($this->getData(['theme', 'menu', 'position']) === 'site-first') {
					$css .= 'header{margin:0 20px}';
				}
				else {
					$css .= 'header{margin:20px 20px 0 20px}';
				}
			}
			$css .= 'header{background-color:' . $colors['normal'] . ';height:' . $this->getData(['theme', 'header', 'height']) . ';line-height:' . $this->getData(['theme', 'header', 'height']) . ';text-align:' . $this->getData(['theme', 'header', 'textAlign']) . '}';
			if($themeHeaderImage = $this->getData(['theme', 'header', 'image'])) {
				$css .= 'header{background-image:url("../file/source/' . $themeHeaderImage . '");background-position:' . $this->getData(['theme', 'header', 'imagePosition']) . ';background-repeat:' . $this->getData(['theme', 'header', 'imageRepeat']) . '}';
			}
			$colors = helper::colorVariants($this->getData(['theme', 'header', 'textColor']));
			$css .= 'header span{color:' . $colors['normal'] . ';font-family:"' . str_replace('+', ' ', $this->getData(['theme', 'header', 'font'])) . '",sans-serif;font-weight:' . $this->getData(['theme', 'header', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'header', 'textTransform']) . '}';
			// Menu
			$colors = helper::colorVariants($this->getData(['theme', 'menu', 'backgroundColor']));
			$css .= 'nav, nav li > a{background-color:' . $colors['normal'] . '}';
			$css .= 'nav a,#toggle span{color:' . $colors['text'] . '!important}';
			$css .= 'nav a:hover{background-color:' . $colors['darken'] . '}';
			$css .= 'nav a.target,nav a.active{background-color:' . $colors['veryDarken'] . '}';
			$css .= '#menu{text-align:' . $this->getData(['theme', 'menu', 'textAlign']) . '}';
			if($this->getData(['theme', 'menu', 'margin'])) {
				if(
					$this->getData(['theme', 'menu', 'position']) === 'site-first'
					OR $this->getData(['theme', 'header', 'position']) === 'body'
				) {
					$css .= 'nav{margin:20px 20px 0 20px}';
				}
				else {
					$css .= 'nav{margin:0 20px 0}';
				}
			}
			$css .= '#toggle span,#menu a{padding:' . $this->getData(['theme', 'menu', 'height']) . ';font-weight:' . $this->getData(['theme', 'menu', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'menu', 'textTransform']) . '}';
			// Pied de page
			$colors = helper::colorVariants($this->getData(['theme', 'footer', 'backgroundColor']));
			if($this->getData(['theme', 'footer', 'margin'])) {
				$css .= 'footer{margin:0 20px 20px}';
			}
			$css .= 'footer{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '}';
			$css .= 'footer a{color:' . $colors['text'] . '!important}';
			$css .= 'footer .container > div{margin:' . $this->getData(['theme', 'footer', 'height']) . ' 0}';
			$css .= '#footerSocials{text-align:' . $this->getData(['theme', 'footer', 'socialsAlign']) . '}';
			$css .= '#footerText{text-align:' . $this->getData(['theme', 'footer', 'textAlign']) . '}';
			$css .= '#footerCopyright{text-align:' . $this->getData(['theme', 'footer', 'copyrightAlign']) . '}';
			// Enregistre la personnalisation
			file_put_contents('site/data/theme.css', $css);
		}
		// Importe le fichier de langue
		$i18n = 'i18n/' . $this->getData(['config', 'language']) . '.json';
		if(is_file($i18n)) {
			self::$i18n = json_decode(file_get_contents($i18n), true);
		}
	}

	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className) {
		$classPath = strtolower($className) . '/' . strtolower($className) . '.php';
		// Module du coeur
		if(is_readable('core/module/' . $classPath)) {
			require 'core/module/' . $classPath;
		}
		// Module
		elseif(is_readable('module/' . $classPath)) {
			require 'module/' . $classPath;
		}
		// Librairie
		elseif(is_readable('core/vendor/' . $classPath)) {
			require 'core/vendor/' . $classPath;
		}
	}

	/**
	 * Routage des modules
	 */
	public function router() {
		// Installation
		if(
			$this->getData(['user']) === []
			AND $this->getUrl(0) !== 'install'
		) {
			http_response_code(302);
			header('Location:' . helper::baseUrl() . 'install');
			exit();
		}
		// Force la déconnexion des membres bannis
		if (
			$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
			AND $this->getUser('group') === self::GROUP_BANNED
		) {
			$user = new user;
			$user->logout();
		}
		// Check l'accès à la page
		$access = null;
		if($this->getData(['page', $this->getUrl(0)]) !== null) {
			if(
				$this->getData(['page', $this->getUrl(0), 'group']) === self::GROUP_VISITOR
				OR (
					$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
					AND $this->getUser('group') >= $this->getData(['page', $this->getUrl(0), 'group'])
				)
			) {
				$access = true;
			}
			else {
				if($this->getUrl(0) === $this->getData(['config', 'homePageId'])) {
					$access = 'login';
				}
				else {
					$access = false;
				}
			}
		}
		// Importe la page
		if(
			$this->getData(['page', $this->getUrl(0)]) !== null
			AND $this->getData(['page', $this->getUrl(0), 'moduleId']) === ''
			AND $access
		) {
			$this->addOutput([
				'title' => $this->getData(['page', $this->getUrl(0), 'title']),
				'content' => $this->getData(['page', $this->getUrl(0), 'content']),
				'metaDescription' => $this->getData(['page', $this->getUrl(0), 'metaDescription']),
				'metaTitle' => $this->getData(['page', $this->getUrl(0), 'metaTitle'])
			]);
		}
		// Importe le module
		else {
			// Id du module, et valeurs en sortie de la page si il s'agit d'un module de page
			if($access AND $this->getData(['page', $this->getUrl(0), 'moduleId'])) {
				$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
				$this->addOutput([
					'title' => $this->getData(['page', $this->getUrl(0), 'title']),
					'metaDescription' => $this->getData(['page', $this->getUrl(0), 'metaDescription']),
					'metaTitle' => $this->getData(['page', $this->getUrl(0), 'metaTitle'])
				]);
				$pageContent = $this->getData(['page', $this->getUrl(0), 'content']);
			}
			else {
				$moduleId = $this->getUrl(0);
				$pageContent = '';
			}
			// Check l'existence du module
			if(class_exists($moduleId)) {
				/** @var common $module */
				$module = new $moduleId;
				// Check l'existence de l'action
				$action = '';
				$ignore = true;
				foreach(explode('-', $this->getUrl(1)) as $actionPart) {
					if($ignore) {
						$action .= $actionPart;
						$ignore = false;
					}
					else {
						$action .= ucfirst($actionPart);
					}
				}
				$action = array_key_exists($action, $module::$actions) ? $action : 'index';
				if(array_key_exists($action, $module::$actions)) {
					$module->$action();
					$output = $module->output;
					// Check le groupe de l'utilisateur
					if(
						(
							$module::$actions[$action] === self::GROUP_VISITOR
							OR (
								$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
								AND $this->getUser('group') >= $module::$actions[$action]
							)
						)
						AND $output['access'] === true
					) {
						// Enregistrement du contenu de la méthode POST lorsqu'une notice est présente
						if(common::$inputNotices) {
							foreach($_POST as $postId => $postValue) {
								if(is_array($postValue)) {
									foreach($postValue as $subPostId => $subPostValue) {
										self::$inputBefore[$postId . '_' . $subPostId] = $subPostValue;
									}
								}
								else {
									self::$inputBefore[$postId] = $postValue;
								}
							}
						}
						// Sinon traitement des données de sortie qui requiert qu'aucune notice ne soit présente
						else {
							// Enregistrement des données
							if($output['state'] !== false) {
								$this->setData([$module->getData()]);
								$this->saveData();
							}
							// Notification
							if($output['notification']) {
								if($output['state'] === true) {
									$notification = 'ZWII_NOTIFICATION_SUCCESS';
								}
								elseif($output['state'] === false) {
									$notification = 'ZWII_NOTIFICATION_ERROR';
								}
								else {
									$notification = 'ZWII_NOTIFICATION_OTHER';
								}
								$_SESSION[$notification] = $output['notification'];
							}
							// Redirection
							if($output['redirect']) {
								http_response_code(301);
								header('Location:' . $output['redirect']);
								exit();
							}
						}
						// Données en sortie applicables même lorsqu'une notice est présente
						// Affichage
						if($output['display']) {
							$this->addOutput([
								'display' => $output['display']
							]);
						}
						// Contenu brut
						if($output['content']) {
							$this->addOutput([
								'content' => $output['content']
							]);
						}
						// Contenu par vue
						elseif($output['view']) {
							// Chemin en fonction d'un module du coeur ou d'un module
							$modulePath = in_array($moduleId, self::$coreModuleIds) ? 'core/' : '';
							// CSS
							$stylePath = $modulePath . 'module/' . $moduleId . '/view/' . $output['view'] . '/' . $output['view'] . '.css';
							if(file_exists($stylePath)) {
								$this->addOutput([
									'style' => file_get_contents($stylePath)
								]);
							}
							// JS
							$scriptPath = $modulePath . 'module/' . $moduleId . '/view/' . $output['view'] . '/' . $output['view'] . '.js.php';
							if(file_exists($scriptPath)) {
								ob_start();
								include $scriptPath;
								$this->addOutput([
									'script' => ob_get_clean()
								]);
							}
							// Vue
							$viewPath = $modulePath . 'module/' . $moduleId . '/view/' . $output['view'] . '/' . $output['view'] . '.php';
							if(file_exists($viewPath)) {
								ob_start();
								include $viewPath;
								$this->addOutput([
									'content' => ($output['showPageContent'] ? $pageContent : '') . ob_get_clean()
								]);
							}
						}
						// Librairies
						if($output['vendor'] !== $this->output['vendor']) {
							$this->addOutput([
								'vendor' => array_merge($this->output['vendor'], $output['vendor'])
							]);
						}
						if($output['title'] !== null) {
							$this->addOutput([
								'title' => (($moduleId === 'page' AND $action === 'edit') ? $output['title'] : helper::i18n($output['title']))
							]);
						}
						// Affiche le bouton d'édition de la page dans la barre de membre
						if($output['showBarEditButton']) {
							$this->addOutput([
								'showBarEditButton' => $output['showBarEditButton']
							]);
						}
					}
					// Erreur 403
					else {
						$access = false;
					}
				}
			}
		}
		// Erreurs
		if($access === 'login') {
			http_response_code(302);
			header('Location:' . helper::baseUrl() . 'user/login/');
			exit();
		}
		if($access === false) {
			http_response_code(403);
			$this->addOutput([
				'title' => helper::i18n('Erreur 403'),
				'content' => template::speech('Vous n\'êtes pas autorisé à accéder à cette page...')
			]);
		}
		elseif($this->output['content'] === '') {
			http_response_code(404);
			$this->addOutput([
				'title' => helper::i18n('Erreur 404'),
				'content' => template::speech('Oups ! La page demandée est introuvable...')
			]);
		}
		// Mise en forme des métas
		if($this->output['metaTitle'] === '') {
			if($this->output['title']) {
				$this->addOutput([
					'metaTitle' => $this->output['title'] . ' - ' . $this->getData(['config', 'title'])
				]);
			}
			else {
				$this->addOutput([
					'metaTitle' => $this->getData(['config', 'title'])
				]);
			}
		}
		if($this->output['metaDescription'] === '') {
			$this->addOutput([
				'metaDescription' => $this->getData(['config', 'metaDescription'])
			]);
		}
		// Choix du type d'affichage
		switch($this->output['display']) {
			// Layout vide
			case self::DISPLAY_LAYOUT_BLANK:
				require 'core/layout/blank.php';
				break;
			// Affichage en JSON
			case self::DISPLAY_JSON:
				header('Content-Type: application/json');
				echo json_encode($this->output['content']);
				break;
			// Layout alléger
			case self::DISPLAY_LAYOUT_LIGHT:
				require 'core/layout/light.php';
				break;
			// Layout principal
			case self::DISPLAY_LAYOUT_MAIN:
				require 'core/layout/main.php';
				break;
			// Layout brut
			case self::DISPLAY_RAW:
				echo $this->output['content'];
				break;
		}
	}

}

class helper {

	/** Statut de l'URL rewriting (pour éviter de lire le contenu du fichier .htaccess à chaque self::baseUrl()) */
	private static $rewriteStatus = null;

	/** Filtres personnalisés */
	const FILTER_BOOLEAN = 1;
	const FILTER_DATETIME = 2;
	const FILTER_FLOAT = 3;
	const FILTER_ID = 4;
	const FILTER_INT = 5;
	const FILTER_MAIL = 6;
	const FILTER_PASSWORD = 7;
	const FILTER_STRING_LONG = 8;
	const FILTER_STRING_SHORT = 9;
	const FILTER_TIMESTAMP = 10;
	const FILTER_URL = 11;

	/**
	 * Retourne les valeurs d'une colonne du tableau de données
	 * @param array $array Tableau cible
	 * @param string $column Colonne à extraire
	 * @param string $sort Type de tri à appliquer au tableau (SORT_ASC, SORT_DESC, ou null)
	 * @return array
	 */
	public static function arrayCollumn($array, $column, $sort = null) {
		$newArray = [];
		if(empty($array) === false) {
			$newArray = array_map(function($element) use($column) {
				return $element[$column];
			}, $array);
			switch($sort) {
				case 'SORT_ASC':
					asort($newArray);
					break;
				case 'SORT_DESC':
					arsort($newArray);
					break;
			}
		}
		return $newArray;
	}

	/**
	 * Retourne l'URL de base du site
	 * @param bool $queryString Affiche ou non le point d'interrogation
	 * @param bool $host Affiche ou non l'host
	 * @return string
	 */
	public static function baseUrl($queryString = true, $host = true) {
		$pathInfo = pathinfo($_SERVER['PHP_SELF']);
		$hostName = $_SERVER['HTTP_HOST'];
		$protocol = ((empty($_SERVER['HTTPS']) === false AND $_SERVER['HTTPS'] !== 'off') OR $_SERVER['SERVER_PORT'] === 443) ? 'https://' : 'http://';
		return ($host ? $protocol . $hostName : '') . rtrim($pathInfo['dirname'], ' /') . '/' . (($queryString AND helper::checkRewrite() === false) ? '?' : '');
	}

	/**
	 * Check le statut de l'URL rewriting
	 * @return bool
	 */
	public static function checkRewrite() {
		if(self::$rewriteStatus === null) {
			// Ouvre et scinde le fichier .htaccess
			$htaccess = explode('# URL rewriting', file_get_contents('.htaccess'));
			// Retourne un boolean en fonction du contenu de la partie réservée à l'URL rewriting
			self::$rewriteStatus = empty($htaccess[1]) === false;
		}
		return self::$rewriteStatus;
	}

	/**
	 * Check si une nouvelle version de Zwii est disponible
	 * @return bool
	 */
	public static function checkNewVersion() {
		if($version = @file_get_contents('http://zwiicms.com/version')) {
			return trim($version) !== common::ZWII_VERSION;
		}
		else {
			return false;
		}
	}

	/**
	 * Génère des variations d'une couleur
	 * @param string $rgba Code rgba de la couleur
	 * @return array
	 */
	public static function colorVariants($rgba) {
		preg_match('#\(+(.*)\)+#', $rgba, $matches);
		$rgba = explode(', ', $matches[1]);
		return [
			'normal' => 'rgba(' . $rgba[0] . ',' . $rgba[1] . ',' . $rgba[2] . ',' . $rgba[3] . ')',
			'darken' => 'rgba(' . max(0, $rgba[0] - 15) . ',' . max(0, $rgba[1] - 15) . ',' . max(0, $rgba[2] - 15) . ',' . $rgba[3] . ')',
			'veryDarken' => 'rgba(' . max(0, $rgba[0] - 20) . ',' . max(0, $rgba[1] - 20) . ',' . max(0, $rgba[2] - 20) . ',' . $rgba[3] . ')',
			'text' => self::relativeLuminanceW3C($rgba) > .22 ? "inherit" : "white"
		];
	}

	/**
	 * Supprime un cookie
	 * @param string $cookieKey Clé du cookie à supprimer
	 */
	public static function deleteCookie($cookieKey) {
		unset($_COOKIE[$cookieKey]);
		setcookie($cookieKey, '', time() - 3600, helper::baseUrl(false, false));
	}

	/**
	 * Filtre une chaîne en fonction d'un tableau de données
	 * @param string $text Chaîne à filtrer
	 * @param int $filter Type de filtre à appliquer
	 * @return string
	 */
	public static function filter($text, $filter) {
		$text = trim($text);
		switch($filter) {
			case self::FILTER_BOOLEAN:
				$text = (bool) $text;
				break;
			case self::FILTER_DATETIME:
				$timezone = new DateTimeZone(core::$timezone);
				$date = new DateTime($text);
				$date->setTimezone($timezone);
				$text = (int) $date->format('U');
				break;
			case self::FILTER_FLOAT:
				$text = filter_var($text, FILTER_SANITIZE_NUMBER_FLOAT);
				$text = (float) $text;
				break;
			case self::FILTER_ID:
				$text = mb_strtolower($text, 'UTF-8');
				$text = str_replace(
					explode(',', 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ,\',", '),
					explode(',', 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-,-,-'),
					$text
				);
				$text = preg_replace('/([^a-z0-9-])/', '', $text);
				// Un ID ne peut pas être un entier, pour éviter les conflits avec le système de pagination
				if(intval($text) !== 0) {
					$text = 'i' . $text;
				}
				break;
			case self::FILTER_INT:
				$text = (int) filter_var($text, FILTER_SANITIZE_NUMBER_INT);
				break;
			case self::FILTER_MAIL:
				$text = filter_var($text, FILTER_SANITIZE_EMAIL);
				break;
			case self::FILTER_PASSWORD:
				$text = password_hash($text, PASSWORD_BCRYPT);
				break;
			case self::FILTER_STRING_LONG:
				$text = mb_substr(filter_var($text, FILTER_SANITIZE_STRING), 0, 500000);
				break;
			case self::FILTER_STRING_SHORT:
				$text = mb_substr(filter_var($text, FILTER_SANITIZE_STRING), 0, 500);
				break;
			case self::FILTER_TIMESTAMP:
				$text = date('Y-m-d H:i:s', $text);
				break;
			case self::FILTER_URL:
				$text = filter_var($text, FILTER_SANITIZE_URL);
				break;
		}
		return get_magic_quotes_gpc() ? stripslashes($text) : $text;
	}

	/**
	 * Incrémente une clé en fonction des clés ou des valeurs d'un tableau
	 * @param mixed $key Clé à incrémenter
	 * @param array $array Tableau à vérifier
	 * @return string
	 */
	public static function increment($key, $array = []) {
		// Pas besoin d'incrémenter si la clef n'existe pas
		if($array === []) {
			return $key;
		}
		// Incrémente la clef
		else {
			// Si la clef est numérique elle est incrémentée
			if(is_numeric($key)) {
				$newKey = $key;
				while(array_key_exists($newKey, $array) OR in_array($newKey, $array)) {
					$newKey++;
				}
			}
			// Sinon l'incrémentation est ajoutée après la clef
			else {
				$i = 2;
				$newKey = $key;
				while(array_key_exists($newKey, $array) OR in_array($newKey, $array)) {
					$newKey = $key . '-' . $i;
					$i++;
				}
			}
			return $newKey;
		}
	}

	/**
	 * Traduit les textes
	 * @param string $text Texte à traduire
	 * @return string
	 */
	public static function i18n($text) {
		if(array_key_exists($text, core::$i18n)) {
			$text = core::$i18n[$text];
		}
		return $text;
	}

	/**
	 * Minimise du css
	 * @param string $css Css à minimiser
	 * @return string
	 */
	public static function minifyCss($css) {
		// Supprime les commentaires
		$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
		// Supprime les tabulations, espaces, nouvelles lignes, etc...
		$css = str_replace(["\r\n", "\r", "\n" ,"\t", '  ', '    ', '     '], '', $css);
		$css = preg_replace(['(( )+{)', '({( )+)'], '{', $css);
		$css = preg_replace(['(( )+})', '(}( )+)', '(;( )*})'], '}', $css);
		$css = preg_replace(['(;( )+)', '(( )+;)'], ';', $css);
		// Retourne le css minifié
		return $css;
	}

	/**
	 * Minimise du js
	 * @param string $js Js à minimiser
	 * @return string
	 */
	public static function minifyJs($js) {
		// Supprime les commentaires
		$js = preg_replace('/\\/\\*[^*]*\\*+([^\\/][^*]*\\*+)*\\/|\s*(?<![\:\=])\/\/.*/', '', $js);
		// Supprime les tabulations, espaces, nouvelles lignes, etc...
		$js = str_replace(["\r\n", "\r", "\t", "\n", '  ', '    ', '     '], '', $js);
		$js = preg_replace(['(( )+\))', '(\)( )+)'], ')', $js);
		// Retourne le js minifié
		return $js;
	}

	/**
	 * Crée un système de pagination (retourne un tableau contenant les informations sur la pagination (first, last, pages))
	 * @param array $array Tableau de donnée à utiliser
	 * @param string $url URL à utiliser, la dernière partie doit correspondre au numéro de page, par défaut utiliser $this->getUrl()
	 * @param null|int $sufix Suffixe de l'url
	 * @return array
	 */
	public static function pagination($array, $url, $sufix = null) {
		// Scinde l'url
		$url = explode('/', $url);
		// Url de pagination
		$urlPagination = is_numeric($url[count($url) - 1]) ? array_pop($url) : 1;
		// Url de la page courante
		$urlCurrent = implode('/', $url);
		// Nombre d'éléments à afficher
		$nbElements = count($array);
		// Nombre de page
		$nbPage = ceil($nbElements / 10);
		// Page courante
		$currentPage = is_numeric($urlPagination) ? self::filter($urlPagination, self::FILTER_INT) : 1;
		// Premier élément de la page
		$firstElement = ($currentPage - 1) * 10;
		// Dernier élément de la page
		$lastElement = $firstElement + 10;
		$lastElement = ($lastElement > $nbElements) ? $nbElements : $lastElement;
		// Mise en forme de la liste des pages
		$pages = '';
		if($nbPage > 1) {
			for($i = 1; $i <= $nbPage; $i++) {
				$disabled = ($i === $currentPage) ? ' class="disabled"' : false;
				$pages .= '<a href="' . helper::baseUrl() . $urlCurrent . '/' . $i . $sufix . '"' . $disabled . '>' . $i . '</a>';
			}
			$pages = '<div class="pagination">' . $pages . '</div>';
		}
		// Retourne un tableau contenant les informations sur la pagination
		return [
			'first' => $firstElement,
			'last' => $lastElement,
			'pages' => $pages
		];
	}

	/**
	 * Calcul de la luminance relative d'une couleur
	 */
	public static function relativeLuminanceW3C($rgba) {
		// Conversion en sRGB
		$RsRGB = $rgba[0] / 255;
		$GsRGB = $rgba[1] / 255;
		$BsRGB = $rgba[2] / 255;
		// Ajout de la transparence
		$RsRGBA = $rgba[3] * $RsRGB + (1 - $rgba[3]);
		$GsRGBA = $rgba[3] * $GsRGB + (1 - $rgba[3]);
		$BsRGBA = $rgba[3] * $BsRGB + (1 - $rgba[3]);
		// Calcul de la luminance
		$R = ($RsRGBA <= .03928) ? $RsRGBA / 12.92 : pow(($RsRGBA + .055) / 1.055, 2.4);
		$G = ($GsRGBA <= .03928) ? $GsRGBA / 12.92 : pow(($GsRGBA + .055) / 1.055, 2.4);
		$B = ($BsRGBA <= .03928) ? $BsRGBA / 12.92 : pow(($BsRGBA + .055) / 1.055, 2.4);
		return .2126 * $R + .7152 * $G + .0722 * $B;
	}

	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param array $array Liste des attributs ($key => $value)
	 * @param array $exclude Clés à ignorer ($key)
	 * @return string
	 */
	public static function sprintAttributes(array $array = [], array $exclude = []) {
		$exclude = array_merge(
			[
				'before',
				'classWrapper',
				'help',
				'label'
			],
			$exclude
		);
		$attributes = [];
		foreach($array as $key => $value) {
			if(($value OR $value === 0) AND in_array($key, $exclude) === false) {
				// Champs à traduire
				if(in_array($key, ['placeholder'])) {
					$attributes[] = sprintf('%s="%s"', $key, helper::i18n($value));
				}
				// Disabled
				// Readonly
				elseif(in_array($key, ['disabled', 'readonly'])) {
					$attributes[] = sprintf('%s', $key);
				}
				// Autres
				else {
					$attributes[] = sprintf('%s="%s"', $key, $value);
				}
			}
		}
		return implode(' ', $attributes);
	}

	/**
	 * Retourne un segment de chaîne sans couper de mot
	 * @param string $text Texte à scinder
	 * @param int $start (voir substr de PHP pour fonctionnement)
	 * @param int $length (voir substr de PHP pour fonctionnement)
	 * @return string
	 */
	public static function subword($text, $start, $length) {
		$text = trim($text);
		if(strlen($text) > $length) {
			$text = mb_substr($text, $start, $length);
			$text = mb_substr($text, 0, min(mb_strlen($text), mb_strrpos($text, ' ')));
		}
		return $text;
	}

}

class layout extends common {

	private $core;

	/**
	 * Constructeur du layout
	 */
	public function __construct(core $core) {
		parent::__construct();
		$this->core = $core;
	}

	/**
	 * Affiche le script Google Analytics
	 */
	public function showAnalytics() {
		if($code = $this->getData(['config', 'analyticsId'])) {
			echo '<script>
				(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
				ga("create", "' . $code . '", "auto");
				ga("send", "pageview");
			</script>';
		}
	}

	/**
	 * Affiche le contenu
	 */
	public function showContent() {
		if(
			$this->core->output['title']
			AND (
				$this->getData(['page', $this->getUrl(0)]) === null
				OR $this->getData(['page', $this->getUrl(0), 'hideTitle']) === false
			)
		) {
			echo '<h1 id="sectionTitle">' . $this->core->output['title'] . '</h1>';
		}
		echo $this->core->output['content'];
	}

	/**
	 * Affiche le coyright
	 */
	public function showCopyright() {
		$items = '<div id="footerCopyright">';
		$items .= helper::i18n('Motorisé par') . ' <a href="http://zwiicms.com/" target="_blank">Zwii</a>';
		$items .= ' | <a href="' . helper::baseUrl() . 'sitemap">' . helper::i18n('Plan du site') . '</a>';
		if(
			(
				$this->getData(['theme', 'footer', 'loginLink'])
				AND $this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD')
			)
			OR $this->getUrl(0) === 'theme'
		) {
			$items .= '<span id="footerLoginLink" ' . ($this->getUrl(0) === 'theme' ? 'class="displayNone"' : '') . '> | <a href="' . helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl()) . '">' . helper::i18n('Connexion') . '</a></span>';
		}
		$items .= '</div>';
		echo $items;
	}

	/**
	 * Affiche le favicon
	 */
	public function showFavicon() {
		if($favicon = $this->getData(['config', 'favicon'])) {
			echo '<link rel="shortcut icon" href="' . helper::baseUrl(false) . 'site/file/source/' . $favicon . '">';
		}
	}

	/**
	 * Affiche le texte du footer
	 */
	public function showFooterText() {
		if($footerText = $this->getData(['theme', 'footer', 'text']) OR $this->getUrl(0) === 'theme') {
			echo '<div id="footerText">' . nl2br($footerText) . '</div>';
		}
	}

	/**
	 * Affiche le menu
	 */
	public function showMenu() {
		// Met en forme les items du menu
		$items = '';
		$currentPageId = $this->getData(['page', $this->getUrl(0)]) ? $this->getUrl(0) : $this->getUrl(2);
		foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
			// Propriétés de l'item
			$active = ($parentPageId === $currentPageId OR in_array($currentPageId, $childrenPageIds)) ? ' class="active"' : '';
			$targetBlank = $this->getData(['page', $parentPageId, 'targetBlank']) ? ' target="_blank"' : '';
			// Mise en page de l'item
			$items .= '<li>';
			$items .= '<a href="' . helper::baseUrl() . $parentPageId . '"' . $active . $targetBlank . '>' . $this->getData(['page', $parentPageId, 'title']) . '</a>';
			$items .= '<ul>';
			foreach($childrenPageIds as $childKey) {
				// Propriétés de l'item
				$active = ($childKey === $currentPageId) ? ' class="active"' : '';
				$targetBlank = $this->getData(['page', $childKey, 'targetBlank']) ? ' target="_blank"' : '';
				// Mise en page du sous-item
				$items .= '<li><a href="' . helper::baseUrl() . $childKey . '"' . $active . $targetBlank . '>' . $this->getData(['page', $childKey, 'title']) . '</a></li>';
			}
			$items .= '</ul>';
			$items .= '</li>';
		}
		// Lien de connexion
		if(
			(
				$this->getData(['theme', 'menu', 'loginLink'])
				AND $this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD')
			)
			OR $this->getUrl(0) === 'theme'
		) {
			$items .= '<li id="menuLoginLink" ' . ($this->getUrl(0) === 'theme' ? 'class="displayNone"' : '') . '><a href="' . helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl()) . '">' . helper::i18n('Connexion') . '</a>';
		}
		// Retourne les items du menu
		echo '<ul>' . $items . '</ul>';
	}

	/**
	 * Affiche le meta titre
	 */
	public function showMetaTitle() {
		echo '<title>' . $this->core->output['metaTitle'] . '</title>';
	}

	/**
	 * Affiche la meta description
	 */
	public function showMetaDescription() {
		echo '<meta name="description" content="' . $this->core->output['metaDescription'] . '">';
	}

	/**
	 * Affiche la notification
	 */
	public function showNotification() {
		if(common::$inputNotices) {
			echo '<div id="notification" class="notificationError">' . helper::i18n('Impossible de soumettre le formulaire, car il contient des erreurs') . '</div>';
		}
		elseif(empty($_SESSION['ZWII_NOTIFICATION_SUCCESS']) === false) {
			echo '<div id="notification" class="notificationSuccess">' . helper::i18n($_SESSION['ZWII_NOTIFICATION_SUCCESS']) . '</div>';
			unset($_SESSION['ZWII_NOTIFICATION_SUCCESS']);
		}
		elseif(empty($_SESSION['ZWII_NOTIFICATION_ERROR']) === false) {
			echo '<div id="notification" class="notificationError">' . helper::i18n($_SESSION['ZWII_NOTIFICATION_ERROR']) . '</div>';
			unset($_SESSION['ZWII_NOTIFICATION_ERROR']);
		}
		elseif(empty($_SESSION['ZWII_NOTIFICATION_OTHER']) === false) {
			echo '<div id="notification" class="notificationOther">' . helper::i18n($_SESSION['ZWII_NOTIFICATION_OTHER']) . '</div>';
			unset($_SESSION['ZWII_NOTIFICATION_OTHER']);
		}
	}

	/**
	 * Affiche la barre de membre
	 */
	public function showBar() {
		if($this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')) {
			// Items de gauche
			$leftItems = '';
			if($this->getUser('group') >= self::GROUP_MODERATOR) {
				$leftItems .= '<li><select id="barSelectPage">';
				$leftItems .= '<option value="">' . helper::i18n('Choisissez une page') . '</option>';
				$currentPageId = $this->getData(['page', $this->getUrl(0)]) ? $this->getUrl(0) : $this->getUrl(2);
				foreach($this->getHierarchy(null, false) as $parentPageId => $childrenPageIds) {
					$leftItems .= '<option value="' . helper::baseUrl() . $parentPageId . '"' . ($parentPageId === $currentPageId ? ' selected' : false) . '>' . $this->getData(['page', $parentPageId, 'title']) . '</option>';
					foreach($childrenPageIds as $childKey) {
						$leftItems .= '<option value="' . helper::baseUrl() . $childKey . '"' . ($childKey === $currentPageId ? ' selected' : false) . '>&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getData(['page', $childKey, 'title']) . '</option>';
					}
				}
				$leftItems .= '</select></li>';
			}
			// Items de droite
			$rightItems = '';
			if($this->getUser('group') >= self::GROUP_MODERATOR) {
				if(
					// Sur un module de page qui autorise le bouton de modification de la page
					$this->core->output['showBarEditButton']
					// Sur une page sans module
					OR $this->getData(['page', $this->getUrl(0), 'moduleId']) === ''
					// Sur une page d'accueil
					OR $this->getUrl(0) === ''
				) {
					$rightItems .= '<li><a href="' . helper::baseUrl() . 'page/edit/' . $this->getUrl(0) . '" title="' . helper::i18n('Modifier la page') . '">' . template::ico('pencil') . '</a></li>';
				}
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'page/add" title="' . helper::i18n('Créer une page') . '">' . template::ico('plus') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php?type=0&akey=' . md5_file('site/data/data.json') .'&lang=' . $this->getData(['config', 'language']) . '" title="' . helper::i18n('Gérer les fichiers') . '" data-lity>' . template::ico('folder') . '</a></li>';
			}
			if($this->getUser('group') >= self::GROUP_ADMIN) {
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'user" title="' . helper::i18n('Configurer les utilisateurs') . '">' . template::ico('users') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'theme" title="' . helper::i18n('Personnaliser le thème') . '">' . template::ico('brush') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'config" title="' . helper::i18n('Configurer le site') . '">' . template::ico('gear') . '</a></li>';
			}
			$rightItems .= '<li><a href="' . helper::baseUrl() . 'user/edit/' . $this->getUser('id') . '" title="' . helper::i18n('Configurer mon compte') . '">' . template::ico('user', 'right') . $this->getUser('firstname') . ' ' . $this->getUser('lastname') . '</a></li>';
			$rightItems .= '<li><a id="barLogout" href="' . helper::baseUrl() . 'user/logout" title="' . helper::i18n('Se déconnecter') . '">' . template::ico('logout') . '</a></li>';
			// Barre de membre
			echo '<div id="bar"><div class="container"><ul id="barLeft">' . $leftItems . '</ul><ul id="barRight">' . $rightItems . '</ul></div></div>';
		}
	}

	/**
	 * Affiche le script
	 */
	public function showScript() {
		ob_start();
		require 'core/core.js.php';
		$coreScript = ob_get_clean();
		echo '<script>' . helper::minifyJs($coreScript . $this->core->output['script']) . '</script>';
	}

	/**
	 * Affiche le style
	 */
	public function showStyle() {
		if($this->core->output['style']) {
			echo '<style>' . helper::minifyCss($this->core->output['style']) . '</style>';
		}
	}

	/**
	 * Affiche les réseaux sociaux
	 */
	public function showSocials() {
		$socials = '';
		foreach($this->getData(['config', 'social']) as $socialName => $socialId) {
			switch($socialName) {
				case 'facebookId':
					$socialUrl = 'https://www.facebook.com/';
					break;
				case 'googleplusId':
					$socialUrl = 'https://plus.google.com/';
					break;
				case 'instagramId':
					$socialUrl = 'https://www.instagram.com/';
					break;
				case 'pinterestId':
					$socialUrl = 'https://pinterest.com/';
					break;
				case 'twitterId':
					$socialUrl = 'https://twitter.com/';
					break;
				case 'youtubeId':
					$socialUrl = 'https://www.youtube.com/channel/';
					break;
				default:
					$socialUrl = '';
			}
			if($socialId !== '') {
				$socials .= '<a href="' . $socialUrl . $socialId . '" target="_blank">' . template::ico(substr($socialName, 0, -2)) . '</a>';
			}
		}
		if($socials !== '') {
			echo '<div id="footerSocials">' . $socials . '</div>';
		}
	}

	/**
	 * Affiche l'import des librairies
	 */
	public function showVendor() {
		// Variables partagées
		$vars = 'var baseUrl = ' . json_encode(helper::baseUrl(false)) . ';';
		$vars .= 'var baseUrlQs = ' . json_encode(helper::baseUrl()) . ';';
		$vars .= 'var language = ' . json_encode($this->getData(['config', 'language'])) . ';';
		if(
			$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')
			AND $this->getUser('group') >= self::GROUP_MODERATOR
		) {
			$vars .= 'var privateKey = ' . json_encode(md5_file('site/data/data.json')) . ';';
		}
		echo '<script>' . helper::minifyJs($vars) . '</script>';
		// Librairies
		$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
		foreach($this->core->output['vendor'] as $vendorName) {
			// Coeur
			if(file_exists('core/vendor/' . $vendorName . '/inc.json')) {
				$vendorPath = 'core/vendor/' . $vendorName . '/';
			}
			// Module
			elseif(
				$moduleId
				AND in_array($moduleId, self::$coreModuleIds) === false
				AND file_exists('module/' . $moduleId . '/vendor/' . $vendorName . '/inc.json')
			) {
				$vendorPath = 'module/' . $moduleId . '/vendor/' . $vendorName . '/';
			}
			// Sinon continue
			else {
				continue;
			}
			// Détermine le type d'import en fonction de l'extension de la librairie
			$vendorFiles = json_decode(file_get_contents($vendorPath . 'inc.json'));
			foreach($vendorFiles as $vendorFile) {
				switch(pathinfo($vendorFile, PATHINFO_EXTENSION)) {
					case 'css':
						echo '<link rel="stylesheet" href="' . helper::baseUrl(false) . $vendorPath . $vendorFile . '">';
						break;
					case 'js':
						echo '<script src="' . helper::baseUrl(false) . $vendorPath . $vendorFile . '"></script>';
						break;
				}
			}
		}
	}

}

class template {

	/**
	 * Crée un bouton
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function button($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'disabled' => false,
			'href' => 'javascript:void(0);',
			'ico' => '',
			'id' => $nameId,
			'name' => $nameId,
			'target' => '',
			'uniqueSubmission' => false,
			'value' => 'Bouton'
		], $attributes);
		// Retourne le html
		return sprintf(
			'<a %s class="button %s %s %s">%s</a>',
			helper::sprintAttributes($attributes, ['class', 'disabled', 'ico', 'value']),
			$attributes['disabled'] ? 'disabled' : '',
			$attributes['class'],
			$attributes['uniqueSubmission'] ? 'uniqueSubmission' : '',
			($attributes['ico'] ? template::ico($attributes['ico'], 'right') : '') . helper::i18n($attributes['value'])
		);
	}

	/**
	 * Crée un champ capcha
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function capcha($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'help' => '',
			'id' => $nameId,
			'name' => $nameId,
			'value' => ''
		], $attributes);
		// Génère deux nombres pour le capcha
		$firstNumber = mt_rand(1, 15);
		$secondNumber = mt_rand(1, 15);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		$html .= self::label($attributes['id'], helper::i18n('Combien font') . ' ' . $firstNumber . ' + ' . $secondNumber . ' ?', [
			'help' => $attributes['help']
		]);
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Capcha
		$html .= sprintf(
			'<input type="text" %s>',
			helper::sprintAttributes($attributes)
		);
		// Champs cachés contenant les nombres
		$html .= self::hidden($attributes['id'] . 'FirstNumber', [
			'value' => $firstNumber,
			'before' => false
		]);
		$html .= self::hidden($attributes['id'] . 'SecondNumber', [
			'value' => $secondNumber,
			'before' => false
		]);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une case à cocher à sélection multiple
	 * @param string $nameId Nom et id du champ
	 * @param string $value Valeur de la case à cocher
	 * @param string $label Label de la case à cocher
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function checkbox($nameId, $value, $label, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'checked' => '',
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'name' => $nameId
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['checked'] = (bool) common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Case à cocher
		$html .= sprintf(
			'<input type="checkbox" value="%s" %s>',
			$value,
			helper::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($attributes['id'], '<span>' . helper::i18n($label) . '</span>', [
			'help' => $attributes['help']
		]);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ date
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function date($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'autocomplete' => 'on',
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'name' => $nameId,
			'placeholder' => '',
			'readonly' => true,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		else {
			$attributes['value'] = ($attributes['value'] ? helper::filter($attributes['value'], helper::FILTER_TIMESTAMP) : '');
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Date visible
		$html .= sprintf(
			'<input type="text" class="datepicker %s" value="%s" %s>',
			$attributes['class'],
			$attributes['value'],
			helper::sprintAttributes($attributes, ['class', 'value'])
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ d'upload de fichier
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function file($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'extensions' => '',
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'lang' => 'fr_FR',
			'maxlength' => '500',
			'name' => $nameId,
			'type' => 2,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Champ caché contenant l'url de la page
		$html .= self::hidden($attributes['id'], [
			'class' => 'inputFileHidden',
			'disabled' => $attributes['disabled'],
			'maxlength' => $attributes['maxlength'],
			'value' => $attributes['value']
		]);
		// Champ d'upload
		$html .= '<div>';
		$html .= sprintf(
			'<a
				href="' .
					helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php' .
					'?relative_url=1' .
					'&field_id=' . $attributes['id'] .
					'&type=' . $attributes['type'] .
					'&lang=' . $attributes['lang'] .
					'&akey=' . md5_file('site/data/data.json') .
					($attributes['extensions'] ? '&extensions=' . $attributes['extensions'] : '')
				. '"
				class="inputFile %s %s"
				%s
				data-lity
			>
				' . self::ico('download', 'right') . '
				<span class="inputFileLabel"></span>
			</a>',
			$attributes['class'],
			$attributes['disabled'] ? 'disabled' : '',
			helper::sprintAttributes($attributes, ['class', 'extensions', 'type', 'maxlength'])
		);
		$html .= self::button($attributes['id'] . 'Delete', [
			'class' => 'inputFileDelete',
			'value' => self::ico('cancel')
		]);
		$html .= '</div>';
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Ferme une formulaire
	 * @return string
	 */
	public static function formClose() {
		return '</form>';
	}

	/**
	 * Ouvre un formulaire protégé par CSRF
	 * @param string $id Id du formulaire
	 * @return string
	 */
	public static function formOpen($id) {
		// Ouverture formulaire
		$html = '<form id="' . $id . '" method="post">';
		// Stock le token CSRF
		$html .= self::hidden('csrf', array(
			'value' => $_SESSION['csrf']
		));
		// Retourne le html
		return $html;
	}



	/**
	 * Crée une aide qui s'affiche au survole
	 * @param string $text Texte de l'aide
	 * @return string
	 */
	public static function help($text) {
		return '<span class="helpButton">' . self::ico('help') . '<div class="helpContent">' . helper::i18n($text) . '</div></span>';
	}

	/**
	 * Crée un champ caché
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function hidden($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'id' => $nameId,
			'maxlength' => '500',
			'name' => $nameId,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Texte
		$html = sprintf('<input type="hidden" %s>', helper::sprintAttributes($attributes, ['before']));
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un icône
	 * @param string $ico Classe de l'icône
	 * @param string $margin Ajoute un margin autour de l'icône (choix : left, right, all)
	 * @param bool $animate Ajoute une animation à l'icône
	 * @param string $fontSize Taille de la police
	 * @return string
	 */
	public static function ico($ico, $margin = '', $animate = false, $fontSize = '1em') {
		return '<span class="zwiico-' . $ico . ($margin ? ' zwiico-margin-' . $margin : '') . ($animate ? ' animate-spin' : '') . '" style="font-size:' . $fontSize . '"></span>';
	}

	/**
	 * Crée un label
	 * @param string $for For du label
	 * @param array $attributes Attributs ($key => $value)
	 * @param string $text Texte du label
	 * @return string
	 */
	public static function label($for, $text, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'for' => $for,
			'help' => ''
		], $attributes);
		// Traduit le text
		$text = helper::i18n($text);
		// Ajout d'une aide
		if($attributes['help'] !== '') {
			$text = $text . self::help($attributes['help']);
		}
		// Retourne le html
		return sprintf(
			'<label %s>%s</label>',
			helper::sprintAttributes($attributes),
			$text
		);
	}

	/**
	 * Crée un champ mail
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function mail($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'autocomplete' => 'on',
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'maxlength' => '500',
			'name' => $nameId,
			'placeholder' => '',
			'readonly' => false,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Texte
		$html .= sprintf(
			'<input type="email" %s>',
			helper::sprintAttributes($attributes)
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une notice
	 * @param string $id Id du champ
	 * @param string $notice Notice
	 * @return string
	 */
	public static function notice($id, $notice) {
		return ' <span id="' . $id . 'Notice" class="notice ' . ($notice ? '' : 'displayNone') . '">' . helper::i18n($notice) . '</span>';
	}

	/**
	 * Crée un champ mot de passe
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function password($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'autocomplete' => 'on',
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'maxlength' => '500',
			'name' => $nameId,
			'placeholder' => '',
			'readonly' => false
		], $attributes);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Mot de passe
		$html .= sprintf(
			'<input type="password" %s>',
			helper::sprintAttributes($attributes)
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ sélection
	 * @param string $nameId Nom et id du champ
	 * @param array $options Liste des options du champ de sélection ($value => $text)
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function select($nameId, array $options, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'name' => $nameId,
			'selected' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['selected'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Début sélection
		$html .= sprintf('<select %s>',
			helper::sprintAttributes($attributes)
		);
		// Options
		foreach($options as $value => $text) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				$value,
				$attributes['selected'] == $value ? ' selected' : '', // Double == pour ignorer le type de variable car $_POST change les types en string
				helper::i18n($text)
			);
		}
		// Fin sélection
		$html .= '</select>';
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une bulle de dialogue
	 * @param string $text Texte de la bulle
	 * @return string
	 */
	public static function speech($text) {
		return '<div class="speech"><div class="speechBubble">' . helper::i18n($text) . '</div>' . template::ico('mimi speechMimi', '', false, '7em') . '</div>';
	}

	/**
	 * Crée un bouton validation
	 * @param string $nameId Nom & id du bouton validation
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function submit($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'disabled' => false,
			'ico' => '',
			'id' => $nameId,
			'name' => $nameId,
			'uniqueSubmission' => true,
			'value' => 'Enregistrer'
		], $attributes);
		// Retourne le html
		return sprintf(
			'<button type="submit" class="%s %s" %s>%s</button>',
			$attributes['class'],
			$attributes['uniqueSubmission'] ? 'uniqueSubmission' : '',
			helper::sprintAttributes($attributes, ['class', 'ico', 'value']),
			($attributes['ico'] ? template::ico($attributes['ico'], 'right') : '') . helper::i18n($attributes['value'])
		);
	}

	/**
	 * Crée un tableau
	 * @param array $cols Cols des colonnes (format: [col colonne1, col colonne2, etc])
	 * @param array $body Contenu (format: [[contenu1, contenu2, etc], [contenu1, contenu2, etc]])
	 * @param array $head Entêtes (format : [[titre colonne1, titre colonne2, etc])
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function table(array $cols = [], array $body = [], array $head = [], array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'id' => ''
		], $attributes);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="tableWrapper ' . $attributes['classWrapper']. '">';
		// Début tableau
		$html .= '<table id="' . $attributes['id'] . '" class="table ' . $attributes['class']. '">';
		// Entêtes
		if($head) {
			// Début des entêtes
			$html .= '<thead>';
			$html .= '<tr>';
			$i = 0;
			foreach($head as $th) {
				$html .= '<th class="col' . $cols[$i++] . '">' . helper::i18n($th) . '</th>';
			}
			// Fin des entêtes
			$html .= '</tr>';
			$html .= '</thead>';
		}
		// Début contenu
		$html .= '<tbody>';
		foreach($body as $tr) {
			$html .= '<tr>';
			$i = 0;
			foreach($tr as $td) {
				$html .= '<td class="col' . $cols[$i++] . '">' . $td . '</td>';
			}
			$html .= '</tr>';
		}
		// Fin contenu
		$html .= '</tbody>';
		// Fin tableau
		$html .= '</table>';
		// Fin container
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte court
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function text($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'autocomplete' => 'on',
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'maxlength' => '500',
			'name' => $nameId,
			'placeholder' => '',
			'readonly' => false,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Texte
		$html .= sprintf(
			'<input type="text" %s>',
			helper::sprintAttributes($attributes)
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte long
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function textarea($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'maxlength' => '500000',
			'name' => $nameId,
			'readonly' => false,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		$notice = '';
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$notice = common::$inputNotices[$attributes['id']];
			$attributes['class'] .= ' notice';
		}
		$html .= self::notice($attributes['id'], $notice);
		// Texte long
		$html .= sprintf(
			'<textarea %s>%s</textarea>',
			helper::sprintAttributes($attributes, ['value']),
			$attributes['value']
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

}