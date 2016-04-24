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

class common
{
	############################################################
	# PROPRIETES

	/** @var bool Autorise ou non la mise en cache (dans les modules) */
	public static $cache = true;

	/** @var string Contenu de la page */
	public static $content = '';

	/** Version du css */
	public static $cssVersion = '';

	/** @var string Description de la page */
	public static $description = '';

	/** @var array Polices de caractères Google Font */
	public static $fonts = [
		'Abril+Fatface' => 'Abril Fatface',
		'Arvo' => 'Arvo',
		'Berkshire+Swash' => 'Berkshire Swash',
		'Dancing+Script' => 'Dancing Script',
		'Inconsolata' => 'Inconsolata',
		'Indie+Flower' => 'Indie Flower',
		'Josefin+Slab' => 'Josefin Slab',
		'Lato' => 'Lato',
		'Lobster' => 'Lobster',
		'Marvel' => 'Marvel',
		'Old+Standard+TT' => 'Old Standard TT',
		'Open+Sans' => 'Open Sans',
		'Oswald' => 'Oswald',
		'Raleway' => 'Raleway',
		'Rancho' => 'Rancho',
		'Ubuntu' => 'Ubuntu'
	];

	/** @var array Langue du site */
	public static $language = [];

	/** @var string Type de layout à afficher (LAYOUT : layout et mise cache - JSON : tableau JSON - BLANK : page vide) */
	public static $layout = 'LAYOUT';

	/** @var array Extensions autorisées dans le gestionnaire de fichiers */
	public static $managerExtensions = [
		'7z',
		'css',
		'gif',
		'html',
		'ico',
		'jpeg',
		'jpg',
		'pdf',
		'png',
		'rar',
		'txt',
		'xml',
		'zip'
	];

	/** @var string Meta title du site */
	public static $metaTitle = '';

	/** @var array Modules du système */
	public static $system = [
		'clean',
		'config',
		'create',
		'delete',
		// 'edit', faux module système
		'export',
		// 'login', faux module système
		'logout',
		'manager',
		'mode',
		'module',
		'phpinfo',
		'save',
		'upload'
	];

	/** @var string Titre de la page */
	public static $title = '';

	/** @var array Librairies à charger */
	public static $vendor = [
		'jquery' => true,
		'jquery-ui' => false,
		'jscolor' => false,
		'normalize' => true,
		'tinymce' => false,
		'zwiico' => true
	];

	/** Version de ZwiiCMS */
	public static $version = '7.6.2';

	/** @var array Vues des modules */
	public static $views = [];

	/** @var array Données */
	private $data;

	/** @var array Contenu par défaut de la base de données */
	private $default = [
		'config' => [
			'analytics' => '',
			'description' => 'ZwiiCMS est un logiciel sans base de données qui permet à ses utilisateurs de créer et gérer facilement un site web sans aucune connaissance en programmation.',
			'favicon' => 'data/upload/favicon.ico',
			'footer' => '',
			'index' => 'accueil',
			'language' => '',
			'password' => '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',
			'social' => [
				'facebook' => 'ZwiiCMS',
				'googleplus' => '',
				'instagram' => '',
				'pinterest' => '',
				'twitter' => 'ZwiiCMS',
				'youtube' => ''
			],
			'theme' => [
				'class' => [
					'backgroundImage' => '',
					'backgroundImageRepeat' => 'themeBackgroundImageRepeatNo',
					'backgroundImagePosition' => 'themeBackgroundImagePositionTopLeft',
					'backgroundImageAttachment' => 'themeBackgroundImageAttachmentScroll',
					'headerHeight' => 'themeHeaderHeightMedium',
					'headerMargin' => false,
					'headerPosition' => 'themeHeaderPositionSite',
					'headerTextAlign' => 'themeHeaderTextAlignCenter',
					'menuHeight' => 'themeMenuHeightMedium',
					'menuMargin' => false,
					'menuPosition' => 'themeMenuPositionSite',
					'menuTextAlign' => 'themeMenuTextAlignLeft',
					'siteRadius' => false,
					'siteShadow' => false,
					'siteWidth' => 'themeSiteWidthLarge'
				],
				'color' => [
					'background' => 'E8E8E8',
					'element' => '477BB8',
					'header' => 'FFFFFF',
					'menu' => '477BB8'
				],
				'font' => [
					'text' => 'Lato',
					'title' => 'Oswald'
				],
				'image' => [
					'background' => '',
					'header' => ''
				]
			],
			'title' => 'ZwiiCMS, votre site en quelques clics !'
		],
		'page' => [
			'accueil' => [
				'blank' => false,
				'content' => "<h3>Félicitations ZwiiCMS est 100% opérationnel !</h3>\r\n<p>Pour entrer dans l'administration, rendez-vous <a href='?config'>ici</a> ou cliquez sur le lien \"Administration\" en bas de page. Le mot de passe d'administration par défaut est <strong>password</strong>.</p>\r\n<p>Si vous rencontrez un problème ou si vous avez besoin d'aide, n'hésitez pas à jeter un œil au <a title='site' href='http://zwiicms.com/'>site</a> ou au <a title='forum' href='http://forum.zwiicms.com/'>forum</a> de ZwiiCMS.</p>\r\n<h4>Suivez-nous sur <a href='https://twitter.com/ZwiiCMS/'>Twitter</a> et <a href='https://www.facebook.com/ZwiiCMS/'>Facebook</a> pour ne manquer aucune nouveauté !</h4>",
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => false,
				'parent' => '',
				'position' => 1,
				'title' => 'Accueil'
			],
			'exemple-de-page' => [
				'blank' => false,
				'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce porttitor nibh justo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis condimentum dui metus, ac scelerisque risus varius quis. Nulla elementum urna nec turpis congue, at iaculis nunc blandit. Mauris volutpat metus mauris, vitae dignissim nunc malesuada sed. Duis vel enim elit. Morbi et enim molestie, tincidunt dui eu, sagittis lacus. Pellentesque nec ornare ipsum, nec ultricies nunc. Pellentesque maximus eros blandit, sagittis tortor in, venenatis ligula. Maecenas efficitur tempor risus vehicula sodales. Pellentesque efficitur malesuada lobortis. Ut iaculis neque vehicula rutrum varius. Pellentesque sit amet efficitur velit.</p>\r\n<p>Sed vel tellus et nisl lacinia accumsan non laoreet dui. Sed commodo et mi sed ultricies. Etiam vel ante sit amet nibh posuere interdum ac vel est. Aliquam tristique porttitor lobortis. Donec sed lacinia leo. Nam convallis semper odio, quis mollis lacus euismod eget. Pellentesque quam odio, rhoncus ac dolor eget, vehicula consectetur leo. Duis fermentum facilisis tortor, nec suscipit magna finibus nec. Nam vulputate orci sed arcu varius, auctor viverra magna rutrum. Suspendisse aliquet auctor erat vel sagittis. Cras a vestibulum mi. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n<p>In ut maximus odio. Etiam quis sem vitae nibh egestas facilisis at non libero. Mauris ac augue sagittis, imperdiet libero id, tempus ligula. Etiam eget arcu nec odio tristique cursus vel et nisi. Praesent quis odio mattis massa faucibus mattis id ut justo. Curabitur ut venenatis massa, semper fringilla quam. Donec placerat ut ligula vel dignissim. Maecenas ullamcorper dapibus libero. Nunc vehicula sem sem, gravida aliquam lorem malesuada sed. Quisque non neque lacinia, gravida risus vitae, sodales magna.</p>",
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => false,
				'parent' => '',
				'position' => 2,
				'title' => 'Exemple de page'
			],
			'exemple-de-news' => [
				'blank' => false,
				'content' => '<p>Cette page contient une instance du module de news, il est possible d\'ouvrir une infinité d\'instances en créant d\'autres pages incluant le même module !</p>',
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => 'news',
				'parent' => '',
				'position' => 3,
				'title' => 'Exemple de news'
			],
			'exemple-de-redirection' => [
				'blank' => true,
				'content' => '',
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => 'redirection',
				'parent' => '',
				'position' => 5,
				'title' => 'Exemple de redirection'
			],
			'exemple-de-formulaire' => [
				'blank' => false,
				'content' => '',
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => 'form',
				'parent' => '',
				'position' => 4,
				'title' => 'Exemple de formulaire'
			],
			'premiere-page-enfant' => [
				'blank' => false,
				'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam molestie suscipit consequat. Sed eget augue dignissim, fermentum mauris eu, consectetur mi. Quisque rutrum sodales dapibus. Aliquam tellus ligula, vulputate eu nibh quis, pretium tincidunt ex. Duis tempor nisl at mauris molestie volutpat. Ut sodales leo finibus lectus pharetra porttitor. Sed ullamcorper ligula fermentum varius venenatis. Praesent quis consectetur diam. Vivamus orci ex, ultricies eleifend velit a, tristique cursus tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec pulvinar velit vitae ornare sagittis. Donec eget velit hendrerit lorem sagittis congue et et nunc. Pellentesque sit amet interdum enim. Morbi porta sit amet lacus id porttitor.</p>\r\n<p>Morbi ullamcorper, leo quis dapibus finibus, velit sem pharetra risus, sit amet aliquet ex nulla ac velit. Aenean ac faucibus nunc, non aliquam est. Ut at quam condimentum, commodo orci et, efficitur nisl. Morbi leo quam, luctus sed turpis eget, eleifend dapibus mi. Morbi lobortis magna mollis leo ultricies molestie. Mauris quis sagittis nisl, a tempus quam. Vivamus egestas lacinia nulla ac condimentum. Integer quis risus nisi. Nullam sagittis ipsum ut orci eleifend feugiat.</p>\r\n<p>Integer elementum lacus urna, vitae lacinia massa pretium sed. Donec et libero ligula. Integer ac blandit neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec pellentesque nibh hendrerit sapien dapibus maximus. Vivamus sed sollicitudin ante, quis blandit lorem. Fusce placerat molestie risus ut pretium. Etiam mollis dictum elit vel iaculis. Maecenas tincidunt dictum fringilla. Nunc libero ipsum, lobortis vel ligula ut, congue commodo diam. Duis ac turpis blandit, sodales metus cursus, hendrerit mauris.</p>\r\n<p>Integer eget augue at metus ultrices lacinia ut imperdiet eros. Suspendisse laoreet lectus at risus porta euismod. Aenean sit amet turpis sed libero egestas pellentesque. Morbi hendrerit massa vel convallis sagittis. Maecenas elit nisl, posuere sit amet metus nec, fringilla fringilla massa. Cras in augue sed leo tempor iaculis non ut massa. Vivamus in dictum erat. Nam sit amet nisi lorem.</p>\r\n<p>Etiam eu aliquam lacus. Mauris pharetra rhoncus massa nec sollicitudin. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis nec lobortis nisi. Ut quis tortor sit amet odio luctus ultrices. Nulla et imperdiet quam, vel fermentum diam. Mauris convallis ullamcorper nibh id convallis. Pellentesque lobortis sem vitae lorem interdum, ac malesuada nisi tempus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec sit amet enim tempus, sollicitudin eros sit amet, ultricies dui. Ut luctus elit non nulla rutrum consectetur. Praesent interdum erat risus, a suscipit mi rutrum at. Etiam id ex diam. Suspendisse ut lectus sit amet odio efficitur consectetur at non elit.</p>",
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => false,
				'parent' => 'exemple-de-page',
				'position' => 1,
				'title' => 'Première page enfant'
			],
			'deuxieme-page-enfant' => [
				'blank' => false,
				'content' => "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nibh purus, posuere et pellentesque ut, finibus sed tortor. Vestibulum rutrum diam ut metus ultricies, a dignissim ante fringilla. Vestibulum odio tortor, imperdiet nec blandit et, pellentesque ac nisi. Vestibulum id bibendum odio. In convallis commodo enim non iaculis. Donec tristique mi non nibh semper, et tincidunt mauris gravida. Nullam mollis nisl ex, feugiat tincidunt velit consequat et. Praesent ornare sodales magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vulputate, felis at tristique rhoncus, nulla quam placerat dolor, at mollis diam lectus ac urna. Vivamus et tristique mi, nec congue lorem. Suspendisse efficitur sapien at faucibus rutrum. Fusce orci metus, feugiat sed cursus eu, rutrum eu libero. Mauris sit amet ipsum lorem. In iaculis eros nec tristique ultrices. Nunc laoreet mi orci, euismod eleifend ipsum ultrices vitae.</p>\r\n<p>Sed vel ante sit amet orci auctor scelerisque eu sit amet quam. Quisque lobortis leo ut consectetur fermentum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut venenatis vulputate elit at feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin volutpat, lacus ac gravida rutrum, nunc justo pulvinar libero, ut tincidunt turpis ligula non tellus. Suspendisse congue consectetur ligula quis tincidunt. Etiam aliquam finibus eleifend. Maecenas lacinia sit amet velit viverra lobortis. Curabitur eget tempor sapien, in placerat lectus. Donec tempor mattis nibh, vel dictum risus dignissim eget. Sed sagittis consectetur diam ac lobortis. In ex nibh, placerat non lacus sit amet, finibus tincidunt dui. Cras semper pellentesque interdum. Nunc semper congue ex. Curabitur tempus lectus vitae vehicula consectetur.</p>\r\n<p>Vivamus eu ornare augue. Aliquam non faucibus sapien. Maecenas rhoncus augue vel ligula congue venenatis. Duis interdum suscipit consectetur. Nulla nec massa erat. Vivamus at ex eu odio finibus efficitur. Quisque sed interdum dolor. Integer imperdiet turpis vel diam gravida, posuere porttitor justo accumsan. Morbi ultricies velit sed elit finibus, a fringilla sapien fermentum. Nunc odio mi, suscipit id commodo sit amet, porta ac dolor.</p>",
				'description' => '',
				'hideTitle' => false,
				'metaTitle' => '',
				'module' => false,
				'parent' => 'exemple-de-page',
				'position' => 2,
				'title' => 'Deuxième page enfant'
			]
		],
		'exemple-de-news' => [
			'ma-premiere-news' => [
				'title' => 'Ma première news',
				'date' => 1420580231,
				'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec mi nec purus efficitur vulputate quis ut nisi. Fusce vel luctus tortor. Curabitur aliquet arcu lacus, sed lobortis dui mattis sit amet. Ut vehicula, magna id commodo lobortis, lectus enim dignissim augue, et lacinia libero mi vitae sapien. Curabitur faucibus nunc sapien, nec lobortis tellus vestibulum ut. Curabitur vitae metus tempor, feugiat nisl id, lacinia metus. Praesent in erat tempus, laoreet nisl vitae, vulputate elit. Cras ornare eleifend libero. Duis vitae lacus et lacus sagittis viverra. </p>'
			],
			'encore-une-news' => [
				'title' => 'Encore une news',
				'date' => 1420580347,
				'content' => '<p>Duis iaculis gravida felis, at pharetra mi rutrum non. Duis a laoreet est. Sed vitae pretium quam, sed scelerisque lacus. Nulla velit justo, vestibulum nec efficitur eget, consectetur vel augue. Sed tempor faucibus dolor, in tempor nisi. Mauris sit amet eleifend orci. Suspendisse potenti. Etiam porttitor semper ante, quis lacinia leo ultricies sed. Duis et sapien nec turpis mollis molestie vel sit amet mauris. Suspendisse tempus id tortor eget feugiat. Donec tincidunt ac ipsum id tristique. Ut sodales ligula justo, non pharetra massa sollicitudin at. Curabitur odio risus, porta ut semper quis, bibendum nec ipsum.</p>'
			]
		],
		'exemple-de-redirection' => [
			'url' => 'http://zwiicms.com/'
		],
		'exemple-de-formulaire' => [
			'config' => [
				'button' => 'Envoyer',
				'capcha' => true,
				'mail' => 'moi@remijean.fr'
			],
			'input' => [
				[
					'name' => 'Adresse mail',
					'position' => '1',
					'required' => true,
					'type' => 'text',
					'values' => '',
					'width' => '6'
				],
				[
					'name' => 'Sujet',
					'position' => '2',
					'required' => true,
					'type' => 'text',
					'values' => '',
					'width' => '6'
				],
				[
					'name' => 'Message',
					'position' => '3',
					'required' => true,
					'type' => 'textarea',
					'values' => '',
					'width' => '8'
				]
			],
		]
	];

	/** @var array Pages parentes et de leurs enfants */
	private $hierarchy;

	/** @var array Url du site coupée à chaque "/" */
	private $url;

	/** Import les données */
	public function __construct()
	{
		if(empty($this->data)) {
			if(file_exists('data/data.json')) {
				$this->setData([json_decode(file_get_contents('data/data.json'), true)]);
			}
			else {
				$this->setData([$this->default]);
				$this->setData(['config', 'dataVersion', self::$version]);
				$this->saveData(true);
			}
		}
	}

	############################################################
	# GETTERS/SETTERS

	/**
	 * Accède au cookie contenant le mot de passe
	 * @return string
	 */
	public function getCookie()
	{
		return isset($_COOKIE['PASSWORD']) ? $_COOKIE['PASSWORD'] : '';
	}

	/**
	 * Accède aux données du tableau de données
	 * @param  mixed $keys Clé(s) des données
	 * @return mixed
	 */
	public function getData($keys = null)
	{
		// Retourne l'ensemble des données
		if($keys === null) {
			return $this->data;
		}
		// Transforme la clé en tableau
		elseif(!is_array($keys)) {
			$keys = [$keys];
		}
		// Décent dans les niveaux de la variable $data
		$data = $this->data;
		foreach($keys as $key) {
			// Si aucune donnée n'existe retourne false
			if(empty($data[$key])) {
				return false;
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
	 * Accède à la liste des pages parentes et de leurs enfants ou aux enfants d'un parent
	 * @param  int   $parent Clef du parent
	 * @return array
	 */
	public function getHierarchy($parent = null) {
		if(empty($this->hierarchy)) {
			$children = [];
			// Liste les pages par position en ordre croissant
			$pages = helper::arrayCollumn($this->getData('page'), 'position', 'SORT_ASC', true);
			// Passe en revue les pages
			foreach($pages as $pageKey => $pagePosition) {
				// Si la page n'a pas de parent = page parente
				if(!$this->getData(['page', $pageKey, 'parent'])) {
					$this->hierarchy[$pageKey] = [];
				}
				// Si la page a un parent = page enfant
				else {
					$children[$this->getData(['page', $pageKey, 'parent'])][] = $pageKey;
				}
			}
			// Ajoute les enfants au parents
			foreach($this->hierarchy as $parentKey => $childrenKeys) {
				if(isset($children[$parentKey])) {
					$this->hierarchy[$parentKey] = $children[$parentKey];
				}
			}
		}
		// Retourne les enfants d'un parent
		if($parent) {
			if(isset($this->hierarchy[$parent])) {
				$hierarchy = $this->hierarchy[$parent];
			}
			else {
				$hierarchy = [];
			}
		}
		// Retourne les parents et leurs enfants
		else {
			$hierarchy = $this->hierarchy;
		}
		return $hierarchy;
	}

	/**
	 * Accède au mode d'affichage
	 * @return string
	 */
	public function getMode()
	{
		return !empty($_SESSION['MODE']);
	}

	/**
	 * Accède à la notification et supprime les sessions rattachées
	 * @return array
	 */
	public function getNotification()
	{
		$notification = [
			'notice' => template::$notices,
			'success' => (isset($_SESSION['SUCCESS']) ? $_SESSION['SUCCESS'] : ''),
			'error' => (isset($_SESSION['ERROR']) ? $_SESSION['ERROR'] : '')
		];
		unset($_SESSION['SUCCESS']);
		unset($_SESSION['ERROR']);
		return $notification;
	}

	/**
	 * Accède à une valeur de l'URL ou à l'URL complète (la clef 0 est toujours égale à la page sauf si splice est à false)
	 * @param  int    $key    Clé de l'URL
	 * @param  bool   $splice Supprime la première clef si elle correspond à un module système
	 * @return string
	 */
	public function getUrl($key = null, $splice = true)
	{
		// Construit l'URL
		if(empty($this->url)) {
			$this->url = empty($_SERVER['QUERY_STRING']) ? $this->getData(['config', 'index']) : $_SERVER['QUERY_STRING'];
			$this->url = helper::filter($this->url, helper::URL);
			$this->url = explode('/', $this->url);
		}
		// Variable temporaire pour ne pas impacter la propriété $this->url avec le array_splice()
		$url = $this->url;
		// Supprime les modules système de $this->url[0] si ils sont présents
		if($splice AND (in_array($url[0], self::$system))) {
			array_splice($url, 0, 1);
		}
		// Retourne l'URL complète
		if($key === null) {
			return implode('/', $url);
		}
		// Retourne une partie de l'URL
		else {
			// Retourne l'URL filtrée
			return empty($url[$key]) ? '' : helper::filter($url[$key], helper::URL);
		}

	}

	/** Supprime le cookie contenant le mot de passe */
	public function removeCookie()
	{
		setcookie('PASSWORD');
	}

	/**
	 * Supprime des données dans le tableau de données
	 * @param mixed $keys Clé(s) des données
	 */
	public function removeData($keys)
	{
		// Supprime les données si aucune notice n'existe
		if(!template::$notices) {
			// Transforme la clé en tableau
			if(!is_array($keys)) {
				$keys = [$keys];
			}
			// Supprime la clef en fonction du niveau
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
			}
		}
	}

	/**
	 * Enregistre le tableau de données et supprime les fichiers de cache
	 * @param bool $removeAllCache Supprime l'ensemble des fichiers cache, sinon supprime juste les fichiers cache en rapport avec le module courant
	 */
	public function saveData($removeAllCache = false)
	{
		// Enregistre les données si aucune notice n'existe
		if(!template::$notices) {
			// Liste les fichiers de cache
			$it = new DirectoryIterator('core/cache/');
			foreach($it as $file) {
				// Check que la cible est un fichier
				if($file->isFile() AND $file->getBasename() !== '.gitkeep') {
					// Supprime automatiquement le fichier si l'argument $removeAllCache est à true
					if($removeAllCache === true) {
						unlink($file->getPathname());
					}
					// Supprime le cache de la page si elle vient d'être modifiée
					elseif($this->getUrl(0) === explode('_', $file->getBasename('.html'))[0]) {
						unlink($file->getPathname());
					}
				}
			}
			file_put_contents('data/data.json', json_encode($this->getData()));
		}
	}

	/**
	 * Insert le mot de passe dans le cookie
	 * @param string $password Mot de passe
	 * @param int    $time     Temps de vie du cookie
	 */
	public function setCookie($password, $time)
	{
		setcookie('PASSWORD', helper::filter($password, helper::PASSWORD), $time);
	}

	/**
	 * Insert des données dans le tableau de données
	 * @param array $keys Clé(s) des données
	 */
	public function setData($keys)
	{
		// Modifie les données si aucune notice n'existe
		if(!template::$notices) {
			// Insert les données en fonction du niveau
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
			}
		}
	}

	/**
	 * Modifie le mode d'affichage
	 * @param bool $mode True pour activer le mode édition ou false pour le désactiver
	 */
	public function setMode($mode)
	{
		$_SESSION['MODE'] = $mode;
	}

	/**
	 * Insert une notification
	 * @param string $notification Notification
	 * @param bool   $error        Message d'erreur ou non
	 */
	public function setNotification($notification, $error = false)
	{
		if(!template::$notices) {
			$_SESSION[$error ? 'ERROR' : 'SUCCESS'] = $notification;
		}
	}

	/**
	 * Accède à une valeur de la variable HTTP POST et lui applique un filtre
	 * @param  mixed  $key    Clé de la valeur
	 * @param  string $filter Filtre à appliquer
	 * @return mixed
	 */
	public function getPost($key, $filter = null)
	{
		$post = '';
		// Si la clef est un tableau
		if(preg_match('#\[(.*)\]#', $key, $subKey)) {
			$key = explode('[', $key)[0];
			if(isset($_POST[$key][$subKey[1]])) {
				$post = $_POST[$key][$subKey[1]];
				// Erreur champ obligatoire
				if(empty($post)) {
					template::getRequired($key . $subKey[0]);
				}
			}
		}
		// Si la clef est une chaine
		elseif(isset($_POST[$key])) {
			$post = $_POST[$key];
			// Erreur champ obligatoire
			if(empty($post)) {
				template::getRequired($key);
			}
		}
		// Applique le filtre et retourne la valeur
		return ($filter !== null) ? helper::filter($post, $filter) : $post;
	}
}

class core extends common
{
	############################################################
	# SYSTEME

	/**
	 * Tâches à l'éxecution du coeur
	 * - Suppression des fichiers temporaires trop vieux
	 * - Définition de la version du CSS
	 * - Génération du cache CSS si besoin
	 * - Import des fichiers de langue
	 */
	public function __construct()
	{
		// Hérite de la méthode __construct() parente
		parent::__construct();
		// Scripts de mise à jour
		// De 7.5.1 vers 7.6.0 - 7.6.2
		if(!$this->getData(['config', 'dataVersion'])) {
			// Déplace les classes vers config > theme > class
			foreach($this->getData('theme') as $key => $class) {
				if(!in_array($key, ['siteMargin', 'backgroundColor', 'elementColor', 'headerColor', 'menuColor'])) {
					$this->setData(['config', 'theme', 'class', $key, $class]);
				}
			}
			// Ajoute les réseaux sociaux
			$this->setData(['config', 'social', [
				'facebook' => 'ZwiiCMS',
				'googleplus' => '',
				'instagram' => '',
				'pinterest' => '',
				'twitter' => 'ZwiiCMS',
				'youtube' => ''
			]]);
			// Ajoute le favicon
			$this->setData(['config', 'favicon', 'data/upload/favicon.ico']);
			// Ajoute les couleurs par défaut
			$this->setData(['config', 'theme', 'color', [
				'background' => 'E8E8E8',
				'element' => '477BB8',
				'header' => 'FFFFFF',
				'menu' => '477BB8'
			]]);
			// Ajoute les polices de caractères par défaut
			$this->setData(['config', 'theme', 'font', [
				'text' => 'Lato',
				'title' => 'Oswald'
			]]);
			// Supprime theme
			$this->removeData('theme');
			// Renomme pages en page puis supprime pages
			$this->setData(['page', $this->getData('pages')]);
			$this->removeData('pages');
			// Renomme inputs en input puis supprime inputs
			foreach($this->getData() as $key => $subKeys) {
				if(!in_array($key, ['config', 'page']) AND $inputs = $this->getData([$key, 'inputs'])) {
					$this->setData([$key, 'input', $inputs]);
					$this->removeData([$key, 'inputs']);
				}
			}
			// Met à jour la version des données
			$this->setData(['config', 'dataVersion', self::$version]);
			// Enregistre les modifs
			$this->saveData(true);
		}
		// Supprime les fichiers temporaires trop vieux
		$it = new DirectoryIterator('core/tmp/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getBasename() !== '.gitkeep' AND $file->getMTime() + 86400 < time()) {
				unlink($file->getPathname());
			}
		}
		// Définie la version du CSS
		self::$cssVersion = md5(json_encode(array_merge($this->getData(['config', 'theme', 'color']), $this->getData(['config', 'theme', 'font']))));
		// Génère le cache CSS si besoin
		if(!file_exists('core/cache/' . self::$cssVersion . '.css')) {
			// Police de caractères
			$css = '
				@import url("https://fonts.googleapis.com/css?family=' . $this->getData(['config', 'theme', 'font', 'text']) . '|' . $this->getData(['config', 'theme', 'font', 'title']) . '");
				body {
					font-family: "' . self::$fonts[$this->getData(['config', 'theme', 'font', 'text'])] . '", sans-serif;
				}
				h1,
				h2,
				h3,
				h4,
				h5,
				h6,
				.tabTitles {
					font-family: "' . self::$fonts[$this->getData(['config', 'theme', 'font', 'title'])] . '", sans-serif;
				}
			';
			// Couleur du header
			if($rgb = helper::hexToRgb($this->getData(['config', 'theme', 'color', 'header']))) {
				$color = $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'];
				$textVariant = (.213 * $rgb['r'] + .715 * $rgb['g'] + .072 * $rgb['b'] > 127.5) ? 'inherit' : '#FFF';
				$css .= '
					/* Couleur normale */
					header {
						background-color: rgb(' . $color . ');
					}
					header h1 {
						color: ' . $textVariant . ';
					}
				';
			}
			// Si le menu a un couleur, définition des couleurs du menu
			if($rgb = helper::hexToRgb($this->getData(['config', 'theme', 'color', 'menu']))) {
				$color = $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'];
				$colorDark = ($rgb['r'] - 20) . ',' . ($rgb['g'] - 20) . ',' . ($rgb['b'] - 20) . ',1';
				$colorVeryDark = ($rgb['r'] - 25) . ',' . ($rgb['g'] - 25) . ',' . ($rgb['b'] - 25) . ',1';
				$textVariant = (.213 * $rgb['r'] + .715 * $rgb['g'] + .072 * $rgb['b'] > 127.5) ? 'inherit' : '#FFF';
				$css .= '
					/* Couleur normale */
					.toggle,
					nav,
					nav ul {
						background-color: rgb(' . $color . ');
					}
					.toggle span,
					nav a {
						color: ' . $textVariant . ';
					}
				';
			}
			// Sinon, définition de la couleur de survole des liens et de la couleur de fond blanche pour les sous-menus
			else {
				$colorDark = '0,0,0,.09';
				$colorVeryDark = '0,0,0,.12';
				$css .= '
					@media (min-width: 768px) {
						/* Couleur blanche des sous menus */
						nav li ul {
							background-color: rgb(255,255,255);
						}
						nav li ul a:hover {
							background-color: rgb(245,245,245);
						}
						nav li ul a:active,
						nav li ul a.current {
							background-color: rgb(235,235,235);
						}
					}
				';
			}
			// Couleurs communes avec et sans transparence du menu
			$css .= '
				/* Couleur foncée */
				.toggle:hover,
				nav a:hover {
					background-color: rgba(' . $colorDark . ');
				}
				/* Couleur très foncée */
				.toggle:active,
				nav a:active,
				nav a.current {
					background-color: rgba(' . $colorVeryDark . ');
				}
			';
			// Couleurs des éléments
			if($rgb = helper::hexToRgb($this->getData(['config', 'theme', 'color', 'element']))) {
				$color = $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'];
				$colorDark = ($rgb['r'] - 20) . ',' . ($rgb['g'] - 20) . ',' . ($rgb['b'] - 20);
				$colorVeryDark = ($rgb['r'] - 25) . ',' . ($rgb['g'] - 25) . ',' . ($rgb['b'] - 25);
				$textVariant = (.213 * $rgb['r'] + .715 * $rgb['g'] + .072 * $rgb['b'] > 127.5) ? 'inherit' : '#FFF';
				$css .= '
					/* Couleur normale */
					input[type=\'submit\'],
					.button,
					.pagination a,
					input[type=\'checkbox\']:checked + label:before,
					input[type=\'radio\']:checked + label:before,
					.helpContent {
						background-color: rgb(' . $color . ');
						color: ' . $textVariant . ';
					}
					h2,
					h4,
					h6,
					a,
					.tabTitle.current,
					.helpButton span {
						color: rgb(' . $color . ');
					}
					input[type=\'text\']:hover,
					input[type=\'password\']:hover,
					.inputFile:hover,
					select:hover,
					textarea:hover {
						border: 1px solid rgb(' . $color . ');
					}
					/* Couleur foncée */
					input[type=\'submit\']:hover,
					.button:hover,
					.pagination a:hover,
					input[type=\'checkbox\']:not(:active):checked:hover + label:before,
					input[type=\'checkbox\']:active + label:before,
					input[type=\'radio\']:checked:hover + label:before,
					input[type=\'radio\']:not(:checked):active + label:before {
						background-color: rgb(' . $colorDark . ');
					}
					.helpButton span:hover {
						color: rgb(' . $colorDark . ');
					}
					/* Couleur très foncée */
					input[type=\'submit\']:active,
					.button:active,
					.pagination a:active {
						background-color: rgb(' . $colorVeryDark . ');
					}
				';
			}
			// Couleur de fond
			if($rgb = helper::hexToRgb($this->getData(['config', 'theme', 'color', 'background']))) {
				$color = $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'];
				$css .= '
					/* Couleur normale */
					body {
						background-color: rgb(' . $color . ');
					}
				';
			}
			file_put_contents('core/cache/' . self::$cssVersion . '.css', helper::minifyCss($css));
		}
		// Importe les fichiers de langue
		// Fichier langue système
		$language = 'core/lang/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = json_decode(file_get_contents($language), true);
		}
		// Fichier langue pour le module de la page
		$language = 'module/' . $this->getData(['page', $this->getUrl(0), 'module']) . '/lang/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = array_merge(self::$language, json_decode(file_get_contents($language), true));
		}
	}

	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className)
	{
		$className = substr($className, 0, -3);
		$classPath = 'module/' . $className . '/' . $className . '.php';
		if(is_readable($classPath)) {
			require $classPath;
		}
	}

	/** Routage des pages et modules système */
	public function router()
	{
		// Module système
		if(in_array($this->getUrl(0, false), self::$system)) {
			// Si l'utilisateur est connecté le module système est retournée
			if($this->getData(['config', 'password']) === $this->getCookie()) {
				$method = $this->getUrl(0, false);
				$this->$method();
			}
			// Sinon il doit s'identifier
			else {
				$this->login();
			}
		}
		// Module système d'édition si :
		// - L'utilisateur est connecté
		// - Le mode édition est activé
		// - Une page est demandée
		elseif(
			$this->getData(['config', 'password']) === $this->getCookie()
			AND $this->getMode()
			AND $page = $this->getData(['page', $this->getUrl(0, false)])
		) {
			$this->edit();
		}
		// Page et module de page
		elseif($this->getData(['page', $this->getUrl(0, false)])) {
			// Utilisateur non connecté et layout LAYOUT utilisé
			if(!$this->getCookie() AND self::$layout === 'LAYOUT') {
				// Remplace les / de l'URL par des _
				$url = str_replace('/', '_', $this->getUrl());
				// Importe le fichier si il existe
				if(file_exists('core/cache/' . $url . '.html')) {
					require 'core/cache/' . $url . '.html';
					exit;
				}
				// Sinon ouvre la mémoire tampon pour la future mise en cache
				else {
					ob_start();
				}
			}
			// Importe le module de la page
			if($this->getData(['page', $this->getUrl(0), 'module'])) {
				$module = $this->getData(['page', $this->getUrl(0), 'module']) . 'Mod';
				$module = new $module;
				$method = in_array($this->getUrl(1), $module::$views) ? $this->getUrl(1) : 'index';
				$module->$method();
				// Mise en cache en fonction du module
				self::$cache = $module::$cache;
			}
			// Titre, description et contenu de la page
			self::$title = $this->getData(['page', $this->getUrl(0, false), 'title']);
			self::$metaTitle = $this->getData(['page', $this->getUrl(0, false), 'metaTitle']);
			self::$description = $this->getData(['page', $this->getUrl(0, false), 'description']);
			self::$content = $this->getData(['page', $this->getUrl(0, false), 'content']) . self::$content;
		}
		// Erreur 404
		if(!self::$content) {
			http_response_code(404);
			self::$title = helper::translate('Erreur 404');
			self::$content = '<p>' . helper::translate('Page introuvable !') . '</p>';
		}
		// Choix du type de données à afficher
		switch(self::$layout) {
			// Affiche le layout
			case 'LAYOUT':
				// Méta titre par défaut
				if(!self::$metaTitle) {
					self::$metaTitle = self::$title . ' - ' . $this->getData(['config', 'title']);
				}
				// Description par défaut
				if(!self::$description) {
					self::$description = $this->getData(['config', 'description']);
				}
				// Importe le layout
				require 'core/layout.html';
				break;
			// Affiche un tableau JSON
			case 'JSON':
				echo json_encode(self::$content);
				break;
			// Affiche une page vide
			case 'BLANK':
				echo self::$content;
				break;
		}
		// Génère le fichier de cache et retourne la valeur tampon pour les pages publics (appelé après l'affichage du site dans index.php) si :
		// - l'utilisateur est sur une page
		// - le module ne bloque pas la mise en cache
		// - l'utilisateur n'est pas connecté
		// - le fichier de cache n'existe pas
		// - le layout utilisé est LAYOUT
		$url = str_replace('/', '_', $this->getUrl());
		if(
			$this->getData(['page', $this->getUrl(0)])
			AND self::$cache
			AND !$this->getCookie()
			AND !file_exists('core/cache/' . $url . '.html')
			AND self::$layout === 'LAYOUT'
		) {
			// Récupère le contenu de la page mis en cache dans la méthode $this->router()
			$cache = ob_get_clean();
			// Crée le fichier et colle le contenu du cache
			file_put_contents('core/cache/' . $url . '.html', $cache);
			// Affiche la page
			return $cache;
		}
	}

	############################################################
	# LAYOUT

	/**
	 * Affiche le script Google Analytics
	 * @return string
	 */
	public function showAnalytics()
	{
		if($code = $this->getData(['config', 'analytics'])) {
			return template::script('
				(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
				ga("create", "' . $code . '", "auto");
				ga("send", "pageview");
			');
		}
	}

	/**
	 * Affiche le contenu des pages et modules système
	 * @return string
	 */
	public function showContent()
	{
		// Affiche ou non le titre
		$title = '';
		if($this->getMode() OR !$this->getData(['page', $this->getUrl(0, false)]) OR !$this->getData(['page', $this->getUrl(0, false), 'hideTitle'])) {
			$title = '<h2>' . self::$title . '</h2>';
		}
		// Retourne le contenu de la page
		return
			$title.
			self::$content.
			// ClearBoth au cas ou l'utilisateur ajoute une image en float dans la page
			template::div([
				'class' => 'clearBoth'
			]);
	}

	/**
	 * Affiche le favicon
	 * @return string
	 */
	public function showFavicon()
	{
		if($favicon = $this->getData(['config', 'favicon'])) {
			return '<link rel="shortcut icon" href="' . helper::baseUrl(false) . $favicon . '">';
		}
	}

	/**
	 * Affiche le texte en bas du site
	 * @return string
	 */
	public function showFooterText()
	{
		if($footer = $this->getData(['config', 'footer'])) {
			return '<div id="text">' . $footer . '</div>';
		}
	}

	/**
	 * Affiche l'image de la bannière
	 * @return string
	 */
	public function showHeaderImage()
	{
		if($headerImage = $this->getData(['config', 'theme', 'image', 'header'])) {
			return '<img src="' . helper::baseUrl(false) . $headerImage . '" title="' . $this->getData(['config', 'title']) . '" alt="' . $this->getData(['config', 'title']) . '">';
		}
	}

	/**
	 * Affiche le menu
	 * @return string
	 */
	public function showMenu()
	{
		// Met en forme les items du menu
		$items = '';
		foreach($this->getHierarchy() as $parentKey => $childrenKeys) {
			// Propriétés de l'item
			$current = '';
			if($parentKey === $this->getUrl(0) OR in_array($this->getUrl(0), $childrenKeys)) {
				$current = ' class="current"';
			}
			$blank = ($this->getData(['page', $parentKey, 'blank']) AND !$this->getMode()) ? ' target="_blank"' : '';
			// Mise en page de l'item
			$items .= '<li>';
			$items .= '<a href="' . helper::baseUrl() . $parentKey . '"' . $current . $blank . '>' . $this->getData(['page', $parentKey, 'title']) . '</a>';
			$items .= '<ul>';
			foreach($childrenKeys as $childKey) {
				// Propriétés de l'item
				$current = ($childKey === $this->getUrl(0)) ? ' class="current"' : '';
				$blank = ($this->getData(['page', $childKey, 'blank']) AND !$this->getMode()) ? ' target="_blank"' : '';
				// Mise en page du sous-item
				$items .= '<li><a href="' . helper::baseUrl() . $childKey . '"' . $current . $blank . '>' . $this->getData(['page', $childKey, 'title']) . '</a></li>';
			}
			$items .= '</ul>';
			$items .= '</li>';
		}
		// Retourne les items du menu
		return '<ul>' . $items . '</ul>';
	}

	/**
	 * Affiche la notification
	 * @return string
	 */
	public function showNotification()
	{
		$notification = $this->getNotification();
		// Si une notice existe, affiche un message pour prévenir l'utilisateur
		if(!empty($notification['notice'])) {
			$notification = template::div([
				'id' => 'notification',
				'class' => 'error',
				'text' => 'Impossible de soumettre le formulaire, car il contient des erreurs !'
			]);
		}
		// Si besoin, affiche une notification d'erreur
		elseif(!empty($notification['error'])) {
			$notification = template::div([
				'id' => 'notification',
				'class' => 'error',
				'text' => $notification['error']
			]);
		}
		// Si besoin, affiche une notification de succès
		elseif(!empty($notification['success'])) {
			$notification = template::div([
				'id' => 'notification',
				'class' => 'success',
				'text' => $notification['success']
			]);
		}
		// Si une notification existe elle est retournée
		if(is_string($notification)) {
			return $notification.
			template::script('
				// Cache la notification après 4 secondes
				setTimeout(function() {
					$("#notification").slideUp();
				}, 4000);
			');
		}
	}

	/**
	 * Affiche le panneau d'administration
	 * @return string
	 */
	public function showPanel()
	{
		// Crée le panneau seulement si l'utilisateur est connecté
		if($this->getCookie() === $this->getData(['config', 'password'])) {
			// Items de gauche
			$left = '<li><select onchange="$(location).attr(\'href\', $(this).val());">';
			// Affiche l'option "Choisissez une page" seulement pour le module de configuration et le gestionnaire de fichier
			if(in_array($this->getUrl(0, false), ['config', 'manager'])) {
				$left .= '<option value="">' . helper::translate('Choisissez une page') . '</option>';
			}
			// Crée des options pour les pages en les triant par titre
			$pages = helper::arrayCollumn($this->getData('page'), 'title', 'SORT_ASC', true);
			foreach($pages as $pageKey => $pageTitle) {
				$current = ($pageKey === $this->getUrl(0)) ? ' selected' : false;
				$left .= '<option value="' . helper::baseUrl() . $pageKey . '"' . $current . '>' . $pageTitle . '</option>';
			}
			$left .= '</select></li>';
			// Items de droite
			$right = '<li><a href="' . helper::baseUrl() . 'create" title="' . helper::translate('Créer une page') . '">' . template::ico('plus') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'mode/' . $this->getUrl(null, false) . '"' . ($this->getMode() ? ' class="edit"' : '') . ' title="' . helper::translate('Activer/désactiver le mode édition') . '">' . template::ico('pencil') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'manager" title="' . helper::translate('Gérer les fichiers') . '">' . template::ico('folder') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'config" title="' . helper::translate('Configurer le site') . '">' . template::ico('gear') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'logout" onclick="return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir vous déconnecter ?') . '\');" title="' . helper::translate('Se déconnecter') . '">' . template::ico('logout') . '</a></li>';
			// Retourne le panneau
			return '<div id="panel"><div class="container"><ul class="left">' . $left . '</ul><ul class="right">' . $right . '</ul></div></div>';
		}
	}

	/**
	 * Affiche les réseaux sociaux
	 * @return string
	 */
	public function showSocials()
	{
		$socials = '';
		foreach($this->getData(['config', 'social']) as $socialName => $socialId) {
			// URL en fonction de réseau social
			switch($socialName) {
				case 'facebook':
					$socialUrl = 'https://www.facebook.com/';
					break;
				case 'googleplus':
					$socialUrl = 'https://plus.google.com/';
					break;
				case 'instagram':
					$socialUrl = 'https://www.instagram.com/';
					break;
				case 'pinterest':
					$socialUrl = 'https://pinterest.com/';
					break;
				case 'twitter':
					$socialUrl = 'https://twitter.com/';
					break;
				case 'youtube':
					$socialUrl = 'https://www.youtube.com/channel/';
					break;
				default:
					$socialUrl = '';
			}
			if(!empty($socialId)) {
				$socials .= '<a href="' . $socialUrl . $socialId . '" target="_blank">' . template::ico($socialName) . '</a>';
			}
		}
		// Retourne les réseaux sociaux
		if(!empty($socials)) {
			return '<div id="socials">' . $socials . '</div>';
		}
	}

	/**
	 * Affiche le script communs
	 * @return string
	 */
	public function showCommonScript()
	{
		// Fonction communes
		$functions = '
			// Convertit un code hexadecimal en rgb
			function hexToRgb(hex) {
				var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
				return result ? {
					r: parseInt(result[1], 16),
					g: parseInt(result[2], 16),
					b: parseInt(result[3], 16)
				} : null;
			}
		';
		// Script commun
		$script = '
			// Modifications non enregistrées du formulaire
			var form = $("form");
			form.data("serialize", form.serialize());
			$(window).on("beforeunload", function() {
				if(form.length && form.serialize() !== form.data("serialize")) {
					return "' . helper::translate('Attention, si vous continuez, vous allez perdre les modifications non enregistrées !') . '";
				}
			});
			form.submit(function() {
				$(window).off("beforeunload");
			});
			// Affiche/cache le menu en mode responsive
			var nav = $("nav");
			$(".toggle").on("click", function() {
				nav.slideToggle();
			});
			$(window).on("resize", function() {
				if($(window).width() > 768) {
					nav.css("display", "");
				}
			});
			// Affiche/cache le bouton pour remonter en haut
			var backToTop = $("#backToTop");
			$(window).on("scroll", function() {
				if($(this).scrollTop() > 200) {
					backToTop.fadeIn();
				}
				else {
					backToTop.fadeOut();
				}
			});
			// Remonter en haut au clic sur le bouton
			backToTop.on("click", function() {
				$("body, html").animate({scrollTop: 0}, "400");
			});
		';
		if(self::$vendor['tinymce']) {
			$script .= '
				// Ajoute le formulaire d\'upload de TinyMCE si il n\'existe pas
				if(!$("#editorFileForm").length) {
					$("body").append(
						$("<form>").attr({
							id: "editorForm",
							enctype: "multipart/form-data",
							method: "post"
						}).append(
							$("<input>").addClass("displayNone").attr({
								id: "editorFile",
								type: "file"
							}),
							$("<input>").attr({
								id: "editorField",
								type: "hidden"
							})
						)
					);
				}
				// Upload de tinyMCE
				$("#editorFile").on("change", function() {
					var editorField = $("#editorField").val();
					var editorFieldShort = editorField.substring(0, editorField.length - 3);
					// Affiche le statut de l\'upload
					function uploadStatus(color) {
						$("#" + editorField).val("").css({borderColor: color, color: color});
						$("#" + editorFieldShort + "l").css("color", color);
						$("#" + editorFieldShort + "action").css({
							backgroundColor: color,
							borderColor: color
						});
					}
					// Upload d\'image
					var file = this.files[0];
					if(file !== undefined) {
						var formData = new FormData();
						formData.append("file", file);
						$.ajax({
							type: "POST",
							url: "' . helper::baseUrl() . 'upload",
							data: formData,
							dataType: "json",
							cache: false,
							contentType: false,
							processData: false,
							success: function(data) {
								if(data.error) {
									uploadStatus("#F3674A");
									$("#" + editorField).val(data.error);
								}
								else {
									uploadStatus("#67C672");
									$("#" + editorField).val(data.link);
								}
							},
							error: function() {
								uploadStatus("#F3674A");
							}
						});
					}
				});
			';
		}
		return template::script($functions . '$(function() {' . $script . '});');
	}

	/**
	 * Afiche la liste des classes du thème
	 * @return string
	 */
	public function showThemeClass()
	{
		// Liste des classes
		$class = [];
		foreach($this->getData(['config', 'theme', 'class']) as $key => $value) {
			// Pour les booleans
			if($value === true) {
				$class[] = 'theme' . ucfirst($key);
			}
			// Pour les autres
			elseif($value) {
				$class[] = $value;
			}
		}
		// Cas spécifique pour l'image de la bannière
		if($this->getData(['config', 'theme', 'image', 'header'])) {
			$class[] = 'themeHeaderImage';
		}
		return implode($class, ' ');
	}

	/**
	 * Affiche l'import des librairies
	 * @return string
	 */
	public function showVendor()
	{
		$vendor = '';
		foreach(self::$vendor as $vendorName => $vendorStatus) {
			if($vendorStatus) {
				switch($vendorName) {
					case 'jquery':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jquery/jquery.min.js"></script>';
						break;
					case 'jquery-ui':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jquery-ui/jquery-ui.min.js"></script>';
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jquery-ui/jquery-ui.touch-punch.min.js"></script>';
						$vendor .= '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/jquery-ui/jquery-ui.min.css">';
						break;
					case 'jscolor':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jscolor/jscolor.min.js"></script>';
						break;
					case 'tinymce':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/tinymce/tinymce.min.js"></script>';
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/tinymce/jquery.tinymce.min.js"></script>';
						break;
					case 'normalize':
						$vendor .= '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/normalize/normalize.min.css">';
						break;
					case 'zwiico':
						$vendor .= '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/zwiico/css/zwiico.min.css">';
						break;
				}
			}
		}
		return $vendor;
	}

	############################################################
	# MODULES SYSTEME

	/** Configuration */
	public function config()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Double vérification pour le mot de passe si il a changé
			if($this->getPost('newPassword')) {
				$newPassword = $this->getPost('newPassword', helper::PASSWORD);
				// Ne change pas le mot de passe et crée une notice si la confirmation ne correspond pas au mot de passe
				if($newPassword !== $this->getPost('confirmPassword', helper::PASSWORD)) {
					$newPassword = $this->getData(['config', 'password']);
					template::$notices['confirmPassword'] = 'La confirmation ne correspond pas au mot de passe';
				}
			}
			// Sinon conserve le mot de passe d'origine
			else {
				$newPassword = $this->getData(['config', 'password']);
			}
			// Modifie la configuration
			$this->setData([
				'config',
				[
					'analytics' => $this->getPost('analytics', helper::STRING),
					'dataVersion' => $this->getData(['config', 'dataVersion']),
					'description' => $this->getPost('description', helper::STRING),
					'favicon' => $this->getPost('favicon', helper::URL),
					'footer' => $this->getPost('footer', helper::STRING),
					'index' => $this->getPost('index', helper::STRING),
					'language' => $this->getPost('language', helper::STRING),
					'password' => $newPassword,
					'social' => [
						'facebook' => $this->getPost('facebook', helper::STRING),
						'googleplus' => $this->getPost('googleplus', helper::STRING),
						'instagram' => $this->getPost('instagram', helper::STRING),
						'pinterest' => $this->getPost('pinterest', helper::STRING),
						'twitter' => $this->getPost('twitter', helper::STRING),
						'youtube' => $this->getPost('youtube', helper::STRING)
					],
					'theme' => [
						'class' => [
							'backgroundImageRepeat' => $this->getPost('backgroundImageRepeat', helper::STRING),
							'backgroundImagePosition' => $this->getPost('backgroundImagePosition', helper::STRING),
							'backgroundImageAttachment' => $this->getPost('backgroundImageAttachment', helper::STRING),
							'headerHeight' => $this->getPost('headerHeight', helper::STRING),
							'headerMargin' => $this->getPost('headerMargin', helper::BOOLEAN),
							'headerPosition' => $this->getPost('headerPosition', helper::STRING),
							'headerTextAlign' => $this->getPost('headerTextAlign', helper::STRING),
							'menuHeight' => $this->getPost('menuHeight', helper::STRING),
							'menuMargin' => $this->getPost('menuMargin', helper::BOOLEAN),
							'menuPosition' => $this->getPost('menuPosition', helper::STRING),
							'menuTextAlign' => $this->getPost('menuTextAlign', helper::STRING),
							'siteRadius' => $this->getPost('siteRadius', helper::BOOLEAN),
							'siteShadow' => $this->getPost('siteShadow', helper::BOOLEAN),
							'siteWidth' => $this->getPost('siteWidth', helper::STRING)
						],
						'color' => [
							'background' => $this->getPost('backgroundColor', helper::STRING),
							'element' => $this->getPost('elementColor', helper::STRING),
							'header' => $this->getPost('headerColor', helper::STRING),
							'menu' => $this->getPost('menuColor', helper::STRING)
						],
						'font' => [
							'text' => $this->getPost('textFont', helper::STRING),
							'title' => $this->getPost('titleFont', helper::STRING)
						],
						'image' => [
							'background' => $this->getPost('backgroundImage', helper::URL),
							'header' => $this->getPost('headerImage', helper::URL)
						]
					],
					'title' => $this->getPost('title', helper::STRING)
				]
			]);
			// Active/désactive l'URL rewriting
			if(!template::$notices) {
				// URL rewriting
				$htaccess = file_get_contents('.htaccess');
				$rewriteRule = explode('# URL rewriting', $htaccess);
				// Active l'URL rewriting
				if($this->getPost('rewrite', helper::BOOLEAN)) {
					if(empty($rewriteRule[1])) {
						file_put_contents('.htaccess',
							$htaccess . PHP_EOL .
							'RewriteEngine on' . PHP_EOL .
							'RewriteBase ' . helper::baseUrl(false, false) . PHP_EOL .
							'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL .
							'RewriteRule ^(.*)$ index.php?$1 [L]'
						);
					}
				}
				// Désactive l'URL rewriting
				else {
					if(!empty($rewriteRule[1])) {
						file_put_contents('.htaccess', $rewriteRule[0] . '# URL rewriting');
					}
				}
			}
			// Enregistre les données et supprime le cache
			$this->saveData(true);
			// Notification de modification
			$this->setNotification('Configuration enregistrée avec succès !');
			// Redirige vers l'URL courante
			helper::redirect($this->getUrl(null, false));
		}
		// Contenu de la page
		self::$title = helper::translate('Configuration');
		self::$content =
			template::openForm().
			template::tabs([
				'Configuration générale' =>
					template::openRow().
					template::text('title', [
						'label' => 'Titre du site',
						'required' => 'required',
						'value' => $this->getData(['config', 'title'])
					]).
					template::newRow().
					template::textarea('description', [
						'label' => 'Description du site',
						'required' => 'required',
						'value' => $this->getData(['config', 'description'])
					]).
					template::newRow().
					template::password('newPassword', [
						'label' => 'Nouveau mot de passe',
						'autocomplete' => 'off',
						'col' => 6
					]).
					template::password('confirmPassword', [
						'label' => 'Confirmation du mot de passe',
						'autocomplete' => 'off',
						'col' => 6
					]).
					template::newRow().
					template::select('index', helper::arrayCollumn($this->getData('page'), 'title', 'SORT_ASC', true), [
						'label' => 'Page d\'accueil',
						'required' => 'required',
						'selected' => $this->getData(['config', 'index'])
					]).
					template::newRow().
					template::select('language', helper::listLanguages('Ne pas traduire'), [
						'label' => 'Traduire le site',
						'selected' => $this->getData(['config', 'language'])
					]).
					template::closeRow(),
				'Configuration avancée' =>
					template::subTitle('Site').
					template::openRow().
					template::select('favicon', helper::listUploads('Aucune image', ['ico'], null, 16, 16), [
						'label' => 'Favicon',
						'help' => 'Seule une image de format .ico en 16x16 du gestionnaire de fichiers est acceptée. Attention si le favicon ne change pas, supprimez le cache de votre navigateur !',
						'selected' => $this->getData(['config', 'favicon'])
					]).
					template::newRow().
					template::textarea('footer', [
						'label' => 'Texte du bas de page',
						'value' => $this->getData(['config', 'footer'])
					]).
					template::closeRow().
					template::subTitle('Statistiques').
					template::openRow().
					template::text('analytics', [
						'label' => 'Google Analytics',
						'value' => $this->getData(['config', 'analytics']),
						'help' => 'Saisissez l\'ID de suivi de votre propriété Google Analytics.',
						'placeholder' => 'UA-XXXXXXXX-X',
					]).
					template::closeRow().
					template::subTitle('Réseaux sociaux').
					template::openRow().
					template::text('facebook', [
						'label' => 'Facebook',
						'value' => $this->getData(['config', 'social', 'facebook']),
						'help' => 'Saisissez votre ID Facebook, il correspond à la partie suivante de l\'URL de Facebook : https://www.facebook.com/CETTE PARTIE',
						'col' => 2
					]).
					template::text('googleplus', [
						'label' => 'Google+',
						'value' => $this->getData(['config', 'social', 'googleplus']),
						'help' => 'Saisissez votre ID Google+, il correspond à la partie suivante de l\'URL de Google+ : https://plus.google.com/CETTE PARTIE',
						'col' => 2
					]).
					template::text('instagram', [
						'label' => 'Instagram',
						'value' => $this->getData(['config', 'social', 'instagram']),
						'help' => 'Saisissez votre ID Instagram, il correspond à la partie suivante de l\'URL de Instagram : https://www.instagram.com/CETTE PARTIE',
						'col' => 2
					]).
					template::text('pinterest', [
						'label' => 'Pinterest',
						'value' => $this->getData(['config', 'social', 'pinterest']),
						'help' => 'Saisissez votre ID Pinterest, il correspond à la partie suivante de l\'URL de Pinterest : https://pinterest.com/CETTE PARTIE',
						'col' => 2
					]).
					template::text('twitter', [
						'label' => 'Twitter',
						'value' => $this->getData(['config', 'social', 'twitter']),
						'help' => 'Saisissez votre ID Twitter, il correspond à la partie suivante de l\'URL de Twitter : https://twitter.com/CETTE PARTIE',
						'col' => 2
					]).
					template::text('youtube', [
						'label' => 'Youtube',
						'value' => $this->getData(['config', 'social', 'youtube']),
						'help' => 'Saisissez votre ID Youtube, il correspond à la partie suivante de l\'URL de Youtube : https://www.youtube.com/channel/CETTE PARTIE',
						'col' => 2
					]).
					template::closeRow().
					template::subTitle('Système').
					template::openRow().
					template::checkbox('rewrite', true, 'Activer la réécriture d\'URL', [
						'checked' => helper::rewriteCheck(),
						'help' => 'Supprime le point d\'interrogation de l\'URL (si vous n\'arrivez pas à cocher la case, vérifiez que le module d\'URL rewriting de votre serveur est bien activé).',
						'disabled' => helper::modRewriteCheck() ? '' : 'disabled' // Check que l'URL rewriting fonctionne sur le serveur
					]).
					template::newRow().
					template::text('version', [
						'label' => 'Version de ZwiiCMS',
						'value' => self::$version,
						'disabled' => 'disabled'
					]).
					template::closeRow(),
				'Personnalisation du thème' =>
					template::subTitle('Couleurs').
					template::openRow().
					template::colorPicker('backgroundColor', [
						'label' => 'Fond du site',
						'value' => $this->getData(['config', 'theme', 'color', 'background']),
						'transparent' => false,
						'required' => 'required',
						'col' => 3
					]).
					template::colorPicker('headerColor', [
						'label' => 'Bannière',
						'value' => $this->getData(['config', 'theme', 'color', 'header']),
						'col' => 3
					]).
					template::colorPicker('menuColor', [
						'label' => 'Menu',
						'value' => $this->getData(['config', 'theme', 'color', 'menu']),
						'col' => 3
					]).
					template::colorPicker('elementColor', [
						'label' => 'Éléments',
						'value' => $this->getData(['config', 'theme', 'color', 'element']),
						'transparent' => false,
						'required' => 'required',
						'col' => 3
					]).
					template::closeRow().
					template::subTitle('Polices de caractères').
					template::openRow().
					template::select('titleFont', self::$fonts, [
						'label' => 'Titres',
						'selected' => $this->getData(['config', 'theme', 'font', 'title']),
						'col' => 6
					]).
					template::select('textFont', self::$fonts, [
						'label' => 'Texte',
						'selected' => $this->getData(['config', 'theme', 'font', 'text']),
						'col' => 6
					]).
					template::closeRow().
					template::subTitle('Site').
					template::openRow().
					template::select('siteWidth', [
						'themeSiteWidthSmall' => 'Petit',
						'themeSiteWidthMedium' => 'Moyen',
						'themeSiteWidthLarge' => 'Large'
					], [
						'label' => 'Largeur',
						'selected' => $this->getData(['config', 'theme', 'class', 'siteWidth']),
						'col' => 6
					]).
					template::select('backgroundImage', helper::listUploads('Aucune image', ['png', 'jpeg', 'jpg', 'gif']), [
						'label' => 'Image du fond',
						'help' => 'Seule une image de format .png, .gif, .jpg ou .jpeg du gestionnaire de fichiers est acceptée.',
						'selected' => $this->getData(['config', 'theme', 'image', 'background']),
						'col' => 6
					]).
					template::newRow().
					template::div([
						'id' => 'backgroundImageOptions',
						'class' => 'displayNone',
						'text' =>
							template::select('backgroundImageRepeat', [
								'themeBackgroundImageRepeatNo' => 'Ne pas répéter',
								'themeBackgroundImageRepeatX' => 'Sur l\'axe horizontal',
								'themeBackgroundImageRepeatY' => 'Sur l\'axe vertical',
								'themeBackgroundImageRepeatAll' => 'Sur les deux axes'
							], [
								'label' => 'Répétition',
								'selected' => $this->getData(['config', 'theme', 'class', 'backgroundImageRepeat']),
								'col' => 4
							]).
							template::select('backgroundImagePosition', [
								'themeBackgroundImagePositionTopLeft' => 'En haut à gauche',
								'themeBackgroundImagePositionTopCenter' => 'En haut au centre',
								'themeBackgroundImagePositionTopRight' => 'En haut à droite',
								'themeBackgroundImagePositionCenterLeft' => 'Au milieu à gauche',
								'themeBackgroundImagePositionCenterCenter' => 'Au milieu au centre',
								'themeBackgroundImagePositionCenterRight' => 'Au milieu à droite',
								'themeBackgroundImagePositionBottomLeft' => 'En bas à gauche',
								'themeBackgroundImagePositionBottomCenter' => 'En bas au centre',
								'themeBackgroundImagePositionBottomRight' => 'En bas à droite',
							], [
								'label' => 'Alignement',
								'selected' => $this->getData(['config', 'theme', 'class', 'backgroundImagePosition']),
								'col' => 4
							]).
							template::select('backgroundImageAttachment', [
								'themeBackgroundImageAttachmentScroll' => 'Normale',
								'themeBackgroundImageAttachmentFixed' => 'Fixe'
							], [
								'label' => 'Position',
								'selected' => $this->getData(['config', 'theme', 'class', 'backgroundImageAttachment']),
								'col' => 4
							])
					]).
					template::script('
						// Affiche/cache les options de l\'image du fond
						$("#backgroundImage").on("change", function() {
							var backgroundImageOptionsDOM = $("#backgroundImageOptions");
							if($(this).val() === "") {
								backgroundImageOptionsDOM.slideUp();
							}
							else {
								backgroundImageOptionsDOM.slideDown();
							}
						}).trigger("change");
					').
					template::newRow().
					template::checkbox('siteRadius', true, 'Arrondir les coins du site', [
						'checked' => $this->getData(['config', 'theme', 'class', 'siteRadius'])
					]).
					template::newRow().
					template::checkbox('siteShadow', true, 'Ajouter une ombre autour du site', [
						'checked' => $this->getData(['config', 'theme', 'class', 'siteShadow'])
					]).
					template::closeRow().
					template::subTitle('Bannière').
					template::openRow().
					template::select('headerImage', helper::listUploads('Aucune image', ['png', 'jpeg', 'jpg', 'gif']), [
						'label' => 'Remplacer le titre par une image',
						'help' => 'Seule une image de format .png, .gif, .jpg ou .jpeg du gestionnaire de fichiers est acceptée.',
						'selected' => $this->getData(['config', 'theme', 'image', 'header'])
					]).
					template::newRow().
					template::select('headerPosition', [
						'themeHeaderPositionHide' => 'Invisible',
						'themeHeaderPositionTop' => 'Dans le haut de la page',
						'themeHeaderPositionSite' => 'Dans le site'
					], [
						'label' => 'Emplacement',
						'selected' => $this->getData(['config', 'theme', 'class', 'headerPosition']),
						'col' => 4
					]).
					template::select('headerHeight', [
						'themeHeaderHeightSmall' => 'Petit',
						'themeHeaderHeightMedium' => 'Moyen',
						'themeHeaderHeightLarge' => 'Grand',
						'themeHeaderHeightAuto' => 'Automatique'
					], [
						'label' => 'Hauteur',
						'selected' => $this->getData(['config', 'theme', 'class', 'headerHeight']),
						'col' => 4
					]).
					template::select('headerTextAlign', [
						'themeHeaderTextAlignLeft' => 'Gauche',
						'themeHeaderTextAlignCenter' => 'Centre',
						'themeHeaderTextAlignRight' => 'Droite'
					], [
						'label' => 'Alignement du contenu',
						'selected' => $this->getData(['config', 'theme', 'class', 'headerTextAlign']),
						'col' => 4
					]).
					template::newRow().
					template::checkbox('headerMargin', true, 'Aligne la bannière avec le contenu du site', [
						'checked' => $this->getData(['config', 'theme', 'class', 'headerMargin']),
						'class' => 'displayNone'
					]).
					template::script('
						// Affiche/cache l\'alignement de la bannière avec le contenu du site
						$("#headerPosition").on("change", function() {
							var headerMarginWrapperDOM = $("#headerMarginWrapper");
							if($(this).val() === "themeHeaderPositionSite") {
								headerMarginWrapperDOM.slideDown();
							}
							else {
								headerMarginWrapperDOM.slideUp(function() {
									$("#headerMargin").prop("checked", false);
								});
							}
						}).trigger("change");
					').
					template::closeRow().
					template::subTitle('Menu').
					template::openRow().
					template::select('menuPosition', [
						'themeMenuPositionTop' => 'Dans le haut de la page',
						'themeMenuPositionSite' => 'Dans le site'
					], [
						'label' => 'Emplacement',
						'selected' => $this->getData(['config', 'theme', 'class', 'menuPosition']),
						'col' => 4
					]).
					template::select('menuHeight', [
						'themeMenuHeightSmall' => 'Petit',
						'themeMenuHeightMedium' => 'Moyen',
						'themeMenuHeightLarge' => 'Grand'
					], [
						'label' => 'Hauteur',
						'selected' => $this->getData(['config', 'theme', 'class', 'menuHeight']),
						'col' => 4
					]).
					template::select('menuTextAlign', [
						'themeMenuTextAlignLeft' => 'Gauche',
						'themeMenuTextAlignCenter' => 'Centre',
						'themeMenuTextAlignRight' => 'Droite'
					], [
						'label' => 'Alignement du contenu',
						'selected' => $this->getData(['config', 'theme', 'class', 'menuTextAlign']),
						'col' => 4
					]).
					template::newRow().
					template::checkbox('menuMargin', true, 'Aligne le menu avec le contenu du site', [
						'checked' => $this->getData(['config', 'theme', 'class', 'menuMargin']),
						'class' => 'displayNone'
					]).
					template::script('
						// Affiche/cache l\'alignement du menu avec le contenu du site
						$("#menuPosition").on("change", function() {
							var menuMarginWrapperDOM = $("#menuMarginWrapper");
							if($(this).val() === "themeMenuPositionSite") {
								menuMarginWrapperDOM.slideDown();
							}
							else {
								menuMarginWrapperDOM.slideUp(function() {
									$("#menuMargin").prop("checked", false);
								});
							}
						}).trigger("change");
					').
					template::closeRow()
			]).
			template::script('
				// Aperçu de la personnalisation en direct
				$(".tabContent[data-1=3]").on("change", function() {
					var tabContentDOM = $(this);
					var bodyDOM = $("body");
					var fonts = ' . json_encode(self::$fonts) . ';
					// Importe les polices de caractères
					var css = "@import url(\'https://fonts.googleapis.com/css?family=" + $("#textFont option:selected").val() + "|" + $("#titleFont option:selected").val() + "\');";
					// Supprime les anciennes classes
					bodyDOM.removeClass();
					// Ajoute les nouvelles classes
					// Pour les selects
					tabContentDOM.find("select").each(function() {
						var selectDOM = $(this);
						var option = selectDOM.find("option:selected").val();
						// Pour le select d\'ajout d\'image dans la bannière
						if(selectDOM.attr("id") === "headerImage") {
							$("header img").remove();
							if(option === "") {
								bodyDOM.removeClass("themeHeaderImage");
							}
							else {
								bodyDOM.addClass("themeHeaderImage");
								$("header").append(
									$("<img>").attr("src", "' . helper::baseUrl(false) . '" + option)
								);
							}
						}
						// Pour le select d\'ajout d\'image de fond
						else if(selectDOM.attr("id") === "backgroundImage") {
							bodyDOM.css("background-image", "url(\'' . helper::baseUrl(false) . '" + option + "\')");
						}
						// Pour les select de choix de la police de caractères
						else if(selectDOM.attr("id") === "textFont" || selectDOM.attr("id") === "titleFont") {
							// Ajout du css pour le texte
							if(selectDOM.attr("id") === "textFont") {
								css += "
									body {
										font-family: \'" + fonts[option] + "\', sans-serif;
									}
								";
							}
							// Ajout du css pour les titres
							else if(selectDOM.attr("id") === "titleFont") {
								css += "
									h1,
									h2,
									h3,
									h4,
									h5,
									h6,
									.tabTitles {
										font-family: \'" + fonts[option] + "\', sans-serif;
									}
								";
							}
						}
						// Pour les autres
						else {
							if(option) {
								bodyDOM.addClass(option);
							}
						}
					});
					// Pour les inputs
					tabContentDOM.find("input").each(function() {
						var inputDOM = $(this);
						// Cas spécifique pour les checkboxs
						if(inputDOM.is(":checkbox")) {
							if(inputDOM.is(":checked")) {
								var name = inputDOM.attr("name").replace("[]", "");
								bodyDOM.addClass("theme" + name.charAt(0).toUpperCase() + name.slice(1));
							}
						}
						// Cas simple (ignore les colorPickers)
						else if(!inputDOM.hasClass("jscolor")) {
							bodyDOM.addClass(inputDOM.val());
						}
					});
					// Pour les colorPickers
					$(this).find(".jscolor").each(function() {
						var jscolorDOM = $(this);
						var rgb;
						var color;
						var colorDark;
						var colorVeryDark;
						var textVariant;
						// Calcul des couleurs
						if(jscolorDOM.val()) {
							rgb = hexToRgb(jscolorDOM.val());
							color = rgb.r + "," + rgb.g + "," + rgb.b + ",1";
							colorDark = (rgb.r - 20) + "," + (rgb.g - 20) + "," + (rgb.b - 20) + ",1";
							colorVeryDark = (rgb.r - 25) + "," + (rgb.g - 25) + "," + (rgb.b - 25) + ",1";
							textVariant = (.213 * rgb.r + .715 * rgb.g + .072 * rgb.b > 127.5) ? "inherit" : "#FFF";
						}
						// Transparence
						else {
							color = "0,0,0,0";
							colorDark = "0,0,0,.09";
							colorVeryDark = "0,0,0,.12";
							textVariant = "inherit";
						}
						// Couleur du header
						if(jscolorDOM.attr("id") === "headerColor") {
							css += "
								/* Couleur normale */
								header {
									background-color: rgba(" + color + ");
								}
								header h1 {
									color: " + textVariant + ";
								}
							";
						}
						// Couleurs du menu
						else if(jscolorDOM.attr("id") === "menuColor") {
							if(!jscolorDOM.val()) {
								css += "
									@media (min-width: 768px) {
										/* Couleur blanche des sous menus */
										nav li ul {
											background-color: rgb(255,255,255);
										}
										nav li ul a:hover {
											background-color: rgb(245,245,245);
										}
										nav li ul a:active,
										nav li ul a.current {
											background-color: rgb(235,235,235);
										}
									}
								";
							}
							css += "
								/* Couleur normale */
								.toggle,
								nav,
								nav ul {
									background-color: rgba(" + color + ");
								}
								.toggle span,
								nav a {
									color: " + textVariant + ";
								}
								/* Couleur foncée */
								.toggle:hover,
								nav a:hover {
									background-color: rgba(" + colorDark + ");
								}
								/* Couleur très foncée */
								.toggle:active,
								nav a:active,
								nav a.current {
									background-color: rgba(" + colorVeryDark + ");
								}
							";
						}
						// Couleurs des éléments
						else if(jscolorDOM.attr("id") === "elementColor") {
							css += "
								/* Couleur normale */
								input[type=\'submit\'],
								.button,
								.pagination a,
								input[type=\'checkbox\']:checked + label:before,
								input[type=\'radio\']:checked + label:before,
								.helpContent {
									background-color: rgba(" + color + ");
									color: " + textVariant + ";
								}
								h2,
								h4,
								h6,
								a,
								.tabTitle.current,
								.helpButton span {
									color: rgba(" + color + ");
								}
								input[type=\'text\']:hover,
								input[type=\'password\']:hover,
								.inputFile:hover,
								select:hover,
								textarea:hover {
									border: 1px solid rgba(" + color + ");
								}
								/* Couleur foncée */
								input[type=\'submit\']:hover,
								.button:hover,
								.pagination a:hover,
								input[type=\'checkbox\']:not(:active):checked:hover + label:before,
								input[type=\'checkbox\']:active + label:before,
								input[type=\'radio\']:checked:hover + label:before,
								input[type=\'radio\']:not(:checked):active + label:before {
									background-color: rgba(" + colorDark + ");
								}
								.helpButton span:hover {
									color: rgba(" + colorDark + ");
								}
								/* Couleur très foncée */
								input[type=\'submit\']:active,
								.button:active,
								.pagination a:active {
									background-color: rgba(" + colorVeryDark + ");
								}
							";
						}
						// Couleur du fond
						else if(jscolorDOM.attr("id") === "backgroundColor") {
							css += "
								/* Couleur normale */
								body {
									background-color: rgba(" + color + ");
								}
							";
						}
					});
					// Supprime le css déjà ajouté
					var headDOM = $("head");
					headDOM.find("style").remove();
					// Retourne le nouveau css
					$("<style>").text(css).appendTo(headDOM);
				}).trigger("change");
			').
			template::openRow().
			template::button('clean', [
				'value' => 'Vider le cache',
				'href' => helper::baseUrl() . 'clean',
				'col' => 3,
			]).
			template::button('export', [
				'value' => 'Exporter le contenu',
				'href' => helper::baseUrl() . 'export',
				'col' => 3
			]).
			template::submit('submit', [
				'col' => 2,
				'offset' => 4
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Suppression du cache */
	public function clean()
	{
		// Sauvegarde les données en supprimant le cache
		$this->saveData(true);
		// Notification de suppression
		$this->setNotification('Cache vidé avec succès !');
		// Redirige vers la page de configuration
		helper::redirect('config');
	}

	/** Création d'une page */
	public function create()
	{
		// Titre de la nouvelle page
		$title = helper::translate('Nouvelle page');
		// Incrémente la clef de la page pour éviter les doublons
		$key = helper::increment(helper::filter($title, helper::URL), $this->getData('page'));
		// Crée la page
		$this->setData([
			'page',
			$key,
			[
				// Si cette partie est modifiée il faut modifier : la création, l'édition, et l'enregistrement ajax de la page
				'blank' => false,
				'content' => '<p>' . helper::translate('Contenu de la page.') . '</p>',
				'description' => '',
				'hideTitle' => $this->getPost('hideTitle', helper::BOOLEAN),
				'metaTitle' => '',
				'module' => '',
				'parent' => '',
				'position' => 0,
				'title' => $title
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Notification de création
		$this->setNotification('Nouvelle page créée avec succès !');
		// Redirection vers la page
		helper::redirect($key);
	}

	/** Suppression de page et de fichier */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData(['page', $this->getUrl(0)]) AND !is_file('data/upload/' . $this->getUrl(0))) {
			return false;
		}
		// Pour les pages
		elseif($this->getData(['page', $this->getUrl(0)])) {
			// La page est utilisée comme page d'accueil et ne peut être supprimée
			if($this->getUrl(0) === $this->getData(['config', 'index'])) {
				$this->setNotification('Impossible de supprimer la page d\'accueil !', true);
			}
			// Impossible de supprimer une page contenant des enfants
			elseif(!empty($this->getHierarchy()[$this->getUrl(0)])) {
				$this->setNotification('Impossible de supprimer une page contenant des enfants !', true);
			}
			// Supprime la page
			elseif($this->getData(['page', $this->getUrl(0)])) {
				// Supprime la page et les données du module rattachées à la page
				$this->removeData(['page', $this->getUrl(0)]);
				$this->removeData($this->getUrl(0));
				// Enregistre les données
				$this->saveData();
				// Notification de suppression
				$this->setNotification('Page supprimée avec succès !');
			}
			// Redirige vers la page d'accueil du site
			helper::redirect($this->getData(['config', 'index']));
		}
		// Pour les fichiers
		else {
			// Tente de supprimer le fichier
			if(@unlink('data/upload/' . $this->getUrl(0))) {
				// Notification de suppression
				$this->setNotification('Fichier supprimé avec succès !');
			}
			else {
				// Notification de suppression
				$this->setNotification('Impossible de supprimer le fichier demandé !', true);
			}
			// Redirige vers le gestionnaire de fichiers
			helper::redirect('manager');
		}
	}

	/** Édition de page (faux module système) */
	public function edit()
	{
		// Erreur 404
		if(!$this->getData(['page', $this->getUrl(0)])) {
			return false;
		}
		// Traitement du formulaire
		elseif($this->getPost('submit')) {
			// Modifie la clef de la page si le titre a été modifié
			$key = $this->getPost('title') ? $this->getPost('title', helper::URL_STRICT) : $this->getUrl(0);
			// Sauvegarde le module de la page
			$module = $this->getData(['page', $this->getUrl(0), 'module']);
			// Si la clef à changée
			if($key !== $this->getUrl(0)) {
				// Incrémente la nouvelle clef de la page pour éviter les doublons
				$key = helper::increment($key, $this->getData('page'));
				$key = helper::increment($key, self::$system); // Evite à une page d'avoir la même clef qu'un module système
				// Modifie les enfants si la page est une page parente
				foreach ($this->getHierarchy($this->getUrl(0)) as $childrenKey) {
					$this->setData(['page', $childrenKey, 'parent', $key]);
				}
				// Supprime l'ancienne page
				$this->removeData(['page', $this->getUrl(0)]);
				// Crée les nouvelles données du module de la page (avec la nouvelle clef) en copiant les anciennes
				$this->setData([$key, $this->getData($this->getUrl(0))]);
				// Supprime les données du module de l'ancienne page
				$this->removeData($this->getUrl(0));
				// Si la page est la page d'accueil, modification la clef dans la configuration du site
				if($this->getData(['config', 'index']) === $this->getUrl(0)) {
					$this->setData(['config', 'index', $key]);
				}
			}
			// Check si il faut supprimer l'ensemble du cache
			// - si la position de la page a changée
			// - ou si le parent de la page a changé
			// - ou si le nom de la page a changé
			$position = $this->getPost('position', helper::INT);
			$parent = $this->getPost('parent', helper::STRING);
			$title = $this->getPost('title', helper::STRING);
			if(
				$position !== $this->getData(['page', $this->getUrl(0), 'position'])
				OR $parent !== $this->getData(['page', $this->getUrl(0), 'parent'])
				OR $title !== $this->getData(['page', $this->getUrl(0), 'title'])
			) {
				$removeAllCache = true;
			}
			else {
				$removeAllCache = false;
			}
			// Actualise la positions des pages suivantes de même parent si la position ou le parent de la page à changée
			if(
				$position !== $this->getData(['page', $this->getUrl(0), 'position'])
				OR $parent !== $this->getData(['page', $this->getUrl(0), 'parent'])
			) {
				$hierarchy = $this->getHierarchy();
				// Supérieur à 1 pour ignorer les options ne pas afficher et au début
				// Sinon incrémente de +1 si la nouvelle position est supérieure à la position actuelle afin de prendre en compte la page courante qui n'appraît pas dans la liste
				if($position > 1 AND $position >= $this->getData(['page', $this->getUrl(0), 'position'])) {
					$position++;
				}
				// Modifie les positions des pages dans parents
				if(empty($parent)) {
					foreach(array_keys($hierarchy) as $index => $parentKey) {
						// Commence à 1 et non 0
						$index++;
						// Incrémente de +1 la position des pages suivantes
						if($index >= $position AND $position !== 0) {
							$index++;
						}
						// Change les positions
						$this->setData(['page', $parentKey, 'position', $index]);
					}
				}
				// Modifie les positions des pages avec le même parent
				elseif(!empty($hierarchy[$parent])) {
					foreach($hierarchy[$parent] as $index => $childKey) {
						// Commence à 1 et non 0
						$index++;
						// Incrémente de +1 la position des pages suivantes
						if($index >= $position) {
							$index++;
						}
						// Change les positions
						$this->setData(['page', $childKey, 'position', $index]);
					}
				}
			}
			// Modifie la page ou en crée une nouvelle si la clef à changée
			$this->setData([
				'page',
				$key,
				[
					// Si cette partie est modifiée il faut modifier : la création, l'édition, et l'enregistrement ajax de la page
					'blank' => $this->getPost('blank', helper::BOOLEAN),
					'content' => $this->getPost('content'),
					'description' => $this->getPost('description', helper::STRING),
					'hideTitle' => $this->getPost('hideTitle', helper::BOOLEAN),
					'metaTitle' => $this->getPost('metaTitle', helper::STRING),
					'module' => $module,
					'parent' => $parent,
					'position' => $position,
					'title' => $title
				]
			]);
			// Supprime l'ancienne page si la clef à changée
			if($key !== $this->getUrl(0)) {
				$this->removeData(['page', $this->getUrl(0)]);
			}
			// Enregistre les données
			$this->saveData($removeAllCache);
			// Notification de modification
			$this->setNotification('Page modifiée avec succès !');
			// Redirige vers la nouvelle page si la clef à changée ou sinon vers l'ancienne
			helper::redirect($key);
		}
		// Liste des pages sans parent
		$pagesNoParent = ['' => 'Aucune'];
		$selected = '';
		$hierarchy = $this->getHierarchy();
		foreach($hierarchy as $parentKey => $childrenKeys) {
			// Sélectionne le parent de la page courante
			if($parentKey === $this->getData(['page', $this->getUrl(0), 'parent'])) {
				$selected = $parentKey;
			}
			// Ajoute la page à la liste des pages parentes si elle ne correspond pas à la page courante
			if($parentKey !== $this->getUrl(0)) {
				$pagesNoParent[$parentKey] = $this->getData(['page', $parentKey, 'title']);
			}
		}
		// Template de la page
		self::$title = $this->getData(['page', $this->getUrl(0), 'title']);
		self::$content =
			template::openForm().
			template::tabs([
				'Options principaux' =>
					template::openRow().
					template::text('title', [
						'label' => 'Titre de la page',
						'value' => $this->getData(['page', $this->getUrl(0), 'title']),
						'required' => 'required'
					]).
					template::newRow().
					template::select('parent', $pagesNoParent, [
						'label' => 'Page parente',
						'selected' => $selected,
						'col' => 6,
						'classWrapper' => (empty($hierarchy[$this->getUrl(0)]) ?: 'displayNone')
					]).
					template::select('position', [], [
						'label' => 'Position dans le menu',
						'col' => (empty($hierarchy[$this->getUrl(0)]) ? 6 : 12)
					]).
					template::script('
						// Affiche les bonnes pages dans le select des positions en fonction de la page parente
						var hierarchy = ' . json_encode($this->getHierarchy()) . ';
						var pages = ' . json_encode($this->getData(['page'])) . ';
						$("#parent").on("change", function() {
							var positionDOM = $("#position");
							var positionLabelDOM = $("label[form=position]");
							positionDOM.empty().append(
								$("<option>").val(0).text("' . helper::translate('Ne pas afficher') . '"),
								$("<option>").val(1).text("' . helper::translate('Au début') . '")
							);
							var parentSelected = $(this).find("option:selected").val();
							var positionSelected = 0;
							var positionPrevious = 1;
							// Aucune page parente selectionnée
							if(parentSelected === "") {
								// Liste des pages sans parents
								for(var key in hierarchy) {
									// Pour page courante sélectionne la page précédente (pas de - 1 à positionSelected à cause des options par défaut)
									if(key === "' . $this->getUrl(0) . '") {
										positionSelected = positionPrevious;
									}
									// Sinon ajoute la page à la liste
									else {
										// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
										positionPrevious++;
										// Ajout à la liste
										positionDOM.append(
											$("<option>").val(positionPrevious).text("' . helper::translate('Après') . ' \"" + pages[key].title + "\"")
										);
									}
								}
							}
							// Un page parente est selectionnée
							else {
								// Liste des pages enfants de la page parente
								for(var i = 0; i < hierarchy[parentSelected].length; i++) {
									// Pour page courante sélectionne la page précédente (pas de - 1 à positionSelected à cause des options par défaut)
									if(hierarchy[parentSelected][i] === "' . $this->getUrl(0) . '") {
										positionSelected = positionPrevious;
									}
									// Sinon ajoute la page à la liste
									else {
										// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
										positionPrevious++;
										// Ajout à la liste
										positionDOM.append(
											$("<option>").val(positionPrevious).text("' . helper::translate('Après') . ' \"" + pages[hierarchy[parentSelected][i]].title + "\"")
										);
									}
								}
							}
							// Sélectionne la bonne position
							positionDOM.find("option[value=" + positionSelected + "]").prop("selected", true);
						}).trigger("change");
					').
					template::newRow().
					template::textarea('content', [
						'value' => $this->getData(['page', $this->getUrl(0), 'content']),
						'editor' => true
					]).
					template::newRow().
					template::hidden('key', [
						'value' => $this->getUrl(0)
					]).
					template::hidden('oldModule', [
						'value' => $this->getData(['page', $this->getUrl(0), 'module'])
					]).
					template::select('module', helper::listModules('Aucun module'), [
						'label' => 'Inclure le module',
						'help' => 'En cas de changement de module, les données du module précédent seront supprimées.',
						'selected' => $this->getData(['page', $this->getUrl(0), 'module']),
						'col' => 11
					]).
					template::button('admin', [
						'value' => template::ico('gear'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0),
						'disabled' => $this->getData(['page', $this->getUrl(0), 'module']) ? '' : 'disabled',
						'col' => 1
					]).
					template::script('
							// Enregistre le module de la page en AJAX
							$("#module").on("change", function() {
								var newModule = $("#module").val();
								var admin = $("#admin");
								var ok = true;
								if($("#oldModule").val() != "") {
									ok = confirm("' . helper::translate('Si vous confirmez, les données du module précédent seront supprimées !') . '");
								}
								if(ok) {
									$.ajax({
										type: "POST",
										url: "' . helper::baseUrl() . 'save/" + $("#key").val(),
										data: {module: newModule},
										success: function() {
											$("#oldModule").val(newModule);
											if(newModule == "") {
												admin.addClass("disabled");
											}
											else {
												admin.removeClass("disabled");
												admin.attr("target", "_blank")
											}
										},
										error: function() {
											alert("' . helper::translate('Impossible d\"enregistrer le module !') . '");
											admin.addClass("disabled");
										}
									});
								}
							});
						').
					template::closeRow(),
				'Options avancés' =>
					template::openRow().
					template::text('metaTitle', [
						'label' => 'Méta titre de la page',
						'help' => 'Si le champ est vide, le titre du site est utilisé.',
						'value' => $this->getData(['page', $this->getUrl(0), 'metaTitle'])
					]).
					template::newRow().
					template::textarea('description', [
						'label' => 'Méta description de la page',
						'help' => 'Si le champ est vide, la description du site est utilisée.',
						'value' => $this->getData(['page', $this->getUrl(0), 'description'])
					]).
					template::newRow().
					template::checkbox('hideTitle', true, 'Ne pas afficher le titre en mode public', [
						'checked' => $this->getData(['page', $this->getUrl(0), 'hideTitle'])
					]).
					template::newRow().
					template::checkbox('blank', true, 'Ouvrir dans un nouvel onglet en mode public', [
						'checked' => $this->getData(['page', $this->getUrl(0), 'blank'])
					]).
					template::closeRow()
			]).
			template::openRow().
			template::button('delete', [
				'value' => 'Supprimer',
				'href' => helper::baseUrl() . 'delete/' . $this->getUrl(0),
				'onclick' => 'return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir supprimer cette page ?') . '\');',
				'col' => 2,
				'offset' => 8
			]).
			template::submit('submit', [
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Exporte les données et fichiers uploadés */
	public function export()
	{
		// Creation du ZIP
		$fileName = 'data_' . date('Ymdhis', time()) . '.zip';
		$zip = new ZipArchive();
		if($zip->open('core/tmp/' . $fileName, ZipArchive::CREATE) == TRUE){
			$zip->addFile('data/data.json');
			foreach(helper::listUploads() as $uploadPath => $uploadName) {
				$zip->addFile($uploadPath);
			}
		}
		$zip->close();
		// Téléchargement du ZIP
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="' . $fileName . '"');
		header('Content-Length: ' . filesize('core/tmp/' . $fileName));
		readfile('core/tmp/' . $fileName);
		// Utilise le layout vide
		self::$layout = 'BLANK';
	}

	/** Connexion (faux module système) */
	public function login()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Crée un cookie (de durée infinie si la case est cochée) si le mot de passe est correct
			if($this->getPost('password', helper::PASSWORD) === $this->getData(['config', 'password'])) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				$this->setCookie($this->getPost('password'), $time);
			}
			// Notification d'échec si le mot de passe incorrect
			else {
				$this->setNotification('Mot de passe incorrect !', true);
			}
			// Redirection vers l'URL courante
			helper::redirect($this->getUrl(null, false));
		}
		// Contenu de la page
		self::$title = helper::translate('Connexion');
		self::$content =
			template::openForm().
			template::openRow().
			template::password('password', [
				'required' => 'required',
				'col' => 4
			]).
			template::newRow().
			template::checkbox('time', true, 'Me connecter automatiquement à chaque visite').
			template::newRow().
			template::submit('submit', [
				'value' => 'Me connecter',
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Déconnexion */
	public function logout()
	{
		// Supprime le cookie de connexion
		$this->removeCookie();
		// Redirige vers la page d'accueil du site
		helper::redirect('./', false);
	}

	/** Gestionnaire de fichiers */
	public function manager()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			$this->upload(core::$managerExtensions);
		}
		// Met en forme les fichiers pour les afficher dans un tableau
		$filesTable = [];
		foreach(helper::listUploads() as $path => $file) {
			$filesTable[] = [
				$file,
				template::button('preview[]', [
					'value' => template::ico('eye'),
					'href' => $path,
					'target' => '_blank'
				]),
				template::button('delete[]', [
					'value' => template::ico('cancel'),
					'href' => helper::baseUrl() . 'delete/' . $file,
					'onclick' => 'return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir supprimer ce fichier ?') . '\');'
				])
			];
		}
		if($filesTable) {
			self::$content =
				template::openRow() .
				template::table([10, 1, 1], $filesTable) .
				template::closeRow();
		}
		// Contenu de la page
		self::$title = helper::translate('Gestionnaire de fichiers');
		self::$content =
			template::title('Envoyer un fichier').
			template::openForm('form', [
				'enctype' => 'multipart/form-data'
			]).
			template::openRow().
			template::file('file', [
				'label' => 'Parcourir mes fichiers',
				'help' => helper::translate('Les formats de fichiers autorisés sont :') . ' ' . implode(', .', core::$managerExtensions) . '.',
				'col' => '10'
			]).
			template::submit('submit', [
				'value' => 'Envoyer',
				'col' => '2'
			]).
			template::closeRow().
			template::closeForm().
			template::title('Liste des fichiers').
			(self::$content ? self::$content : template::subTitle('Aucun fichier...'));
	}

	/** Redirection vers le bon mode (édition ou public) */
	public function mode()
	{
		// Switch de mode
		$this->setMode(!$this->getMode());
		// Redirection spécifique pour le module système "module" pour pointer vers la page
		if($this->getUrl(0) === 'module') {
			helper::redirect($this->getUrl(1));
		}
		// Sinon redirection vers la page courante
		else {
			helper::redirect($this->getUrl());
		}
	}

	/** Configuration du module d'une page */
	public function module()
	{
		// Erreur 404
		if(!$this->getData(['page', $this->getUrl(0), 'module'])) {
			return false;
		}
		// Contenu de la page
		$module = $this->getData(['page', $this->getUrl(0), 'module']) . 'Adm';
		$module = new $module;
		$method = in_array($this->getUrl(1), $module::$views) ? $this->getUrl(1) : 'index';
		$module->$method(); // Retourne la variable self::content
		self::$title = $this->getData(['page', $this->getUrl(0), 'title']);
	}

	/** PHPInfo */
	public function phpinfo()
	{
		self::$layout = 'BLANK';
		self::$content = phpinfo();
	}

	/** Enregistrement du module en AJAX */
	public function save()
	{
		// Erreur 404
		if(!$this->getData(['page', $this->getUrl(0)])) {
			return false;
		}
		// Supprime les données du module de la page si le module à changé
		if($this->getPost('module') !== $this->getData(['page', $this->getUrl(0), 'module'])) {
			$this->removeData($this->getUrl(0));
		}
		// Modifie le module de la page
		$this->setData([
			'page',
			$this->getUrl(0),
			[
				// Si cette partie est modifiée il faut modifier : la création, l'édition, et l'enregistrement ajax de la page
				'blank' => $this->getData(['page', $this->getUrl(0), 'blank']),
				'content' => $this->getData(['page', $this->getUrl(0), 'content']),
				'description' => $this->getData(['page', $this->getUrl(0), 'description']),
				'hideTitle' => $this->getData(['page', $this->getUrl(0), 'hideTitle']),
				'metaTitle' => $this->getData(['page', $this->getUrl(0), 'metaTitle']),
				'module' => $this->getPost('module', helper::STRING),
				'parent' => $this->getData(['page', $this->getUrl(0), 'parent']),
				'position' => $this->getData(['page', $this->getUrl(0), 'position']),
				'title' => $this->getData(['page', $this->getUrl(0), 'title'])
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Utilise le layout JSON
		self::$layout = 'JSON';
		self::$content = true;
	}

	/**
	 * Upload d'un fichier en POST et en AJAX
	 * A importer entre un if($this->getPost()) en POST ; A appeler depuis un fichier JS en AJAX
	 * @param array $extensions Extensions autorisées
	 * @return bool
	 */
	public function upload(array $extensions = ['png', 'gif', 'jpg', 'jpeg'])
	{
		// Erreur 404
		if(!isset($_FILES['file'])) {
			return false;
		}
		$target = 'data/upload/' . helper::filter(basename($_FILES['file']['name']), helper::URL);
		// Check la taille du fichier (limité à environs 100 mo)
		if($_FILES['file']['size'] > 100000000) {
			$data['error'] = 'Fichier trop volumineux !';
		}
		// Check le type de fichier
		elseif(!in_array(strtolower(pathinfo($target, PATHINFO_EXTENSION)), $extensions)) {
			$data['error'] = 'Format du fichier non autorisé !';
		}
		// Check les erreurs au chargement du fichier
		elseif($_FILES['file']['error']) {
			$data['error'] = 'Erreur au chargement du fichier !';
		}
		// Check qu'il n'existe aucune notice
		if(empty($data['error'])) {
			// Tente de déplacer le fichier dans le bon dossier
			if(@move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
				$data['success'] = 'Fichier envoyé avec succès !';
				$data['link'] = helper::baseUrl(false) . $target;
			}
			else {
				$data['error'] = 'Impossible de communiquer avec le serveur !';
			}
		}
		// Pour une requête en AJAX
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			self::$layout = 'JSON';
			self::$content = $data;
		}
		// Pour une requête en POST
		else {
			// En cas de succès
			if(isset($data['success'])) {
				// Notification d'upload
				$this->setNotification($data['success']);
				// Redirige vers la page courante
				helper::redirect($this->getUrl(null, false));
			}
			// Sinon crée une notice en cas d'erreur
			else {
				template::$notices['file'] = $data['error'];
			}
		}
	}
}

class helper
{
	/** Statut de l'URL rewriting (pour éviter de lire le contenu du fichier .htaccess à chaque self::baseUrl()) */
	private static $rewriteStatus = null;

	/** Filtres personnalisés */
	const PASSWORD = 'FILTER_SANITIZE_PASSWORD';
	const BOOLEAN = 'FILTER_SANITIZE_BOOLEAN';
	const URL = 'FILTER_SANITIZE_URL'; // N'utilise pas FILTER_SANITIZE_URL de PHP qui est trop efficace
	const URL_STRICT = 'FILTER_SANITIZE_URL_STRICT'; // Supprime les "&", "?" et "/" (utile pour filtrer une partie d'URL, ne pas utiliser pour filtrer une URL complète)
	const STRING = FILTER_SANITIZE_STRING;
	const EMAIL = FILTER_SANITIZE_EMAIL;
	const FLOAT = FILTER_SANITIZE_NUMBER_FLOAT;
	const INT = FILTER_SANITIZE_NUMBER_INT;

	/**
	 * Retourne les valeurs d'une colonne du tableau de données
	 * @param  array   $array     Tableau cible
	 * @param  string  $columnKey Clé à extraire
	 * @param  string  $sort      Type de tri à appliquer au tableau (SORT_ASC, SORT_DESC, ou vide)
	 * @param  bool    $keep      Conserve le format clés => valeurs
	 * @return array
	 */
	public static function arrayCollumn($array, $columnKey, $sort = '', $keep = false)
	{
		$row = [];
		if(!empty($array)) {
			foreach($array as $key => $value) {
				if($value[$columnKey]) {
					$row[$key] = $value[$columnKey];
				}
			}
			switch($sort) {
				case 'SORT_ASC':
					asort($row);
					break;
				case 'SORT_DESC':
					arsort($row);
					break;
			}
			$row = $keep ? $row : array_keys($row);
		}
		return $row;
	}

	/**
	 * Retourne l'URL de base du site
	 * @param  bool   $queryString Affiche ou non le point d'interrogation
	 * @param  bool   $host        Affiche ou non l'host
	 * @return string
	 */
	public static function baseUrl($queryString = true, $host = true) {
		$currentPath = $_SERVER['PHP_SELF'];
		$pathInfo = pathinfo($currentPath);
		$hostName = $_SERVER['HTTP_HOST'];
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
		return ($host ? $protocol . $hostName  : '') . rtrim($pathInfo['dirname'], ' /') . '/' . (($queryString AND !helper::rewriteCheck()) ? '?' : '');
	}

	/**
	 * Filtre et incrémente une chaîne en fonction d'un tableau de données
	 * @param  string     $text   Chaîne à filtrer
	 * @param  int|string $filter Type de filtre à appliquer
	 * @return string
	 */
	public static function filter($text, $filter)
	{
		$search = '€,$,£,á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ, ,¨,\',",’,;';
		$replace = 'e,s,l,a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-,-,-,-,-,-';
		switch($filter) {
			case self::PASSWORD:
				$text = sha1($text);
				break;
			case self::BOOLEAN:
				$text = (bool)$text;
				break;
			case self::URL:
				$text = str_replace(explode(',', $search), explode(',', $replace), mb_strtolower($text, 'UTF-8'));
				break;
			case self::URL_STRICT:
				$text = str_replace(explode(',', $search . ',?,&,/'), explode(',', $replace . ',-,-,-'), mb_strtolower($text, 'UTF-8'));
				break;
			case self::INT:
				$text = filter_var($text, $filter);
				$text = (int)$text;
				break;
			case self::FLOAT:
				$text = filter_var($text, $filter);
				$text = (float)$text;
				break;
			default:
				$text = filter_var($text, $filter);
		}
		return get_magic_quotes_gpc() ? stripslashes($text) : $text;
	}

	/**
	 * Convertit un code hexadecimal en rgb
	 * @param  mixed  $hex Code hexadecimal à convertir
	 * @return mixed
	 */
	public static function hexToRgb($hex)
	{
		if(!empty($hex)) {
			list($r, $g, $b) = str_split($hex, 2);
			return [
				'r' => hexdec($r),
				'g' => hexdec($g),
				'b' => hexdec($b)
			];
		}
	}

	/**
	 * Incrémente une clé en fonction des clés ou des valeurs d'un tableau
	 * @param  mixed  $key   Clé à incrémenter
	 * @param  array  $array Tableau à vérifier
	 * @return string
	 */
	public static function increment($key, $array)
	{
		// Pas besoin d'incrémenter Si la clef n'existe pas
		if(empty($array)) {
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
	 * Crée une liste des langues (format : fichier et extension => fichier)
	 * @param  mixed $default Valeur par défaut
	 * @return array
	 */
	public static function listLanguages($default = false)
	{
		$languages = [];
		if($default) {
			$languages[''] = self::translate($default);
		}
		$it = new DirectoryIterator('core/lang/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getExtension() === 'json') {
				$languages[$file->getBasename()] = $file->getBasename('.json');
			}
		}
		return $languages;
	}

	/**
	 * Crée une liste des modules (format : fichier => nom du module)
	 * @param  mixed $default Valeur par défaut
	 * @return array
	 */
	public static function listModules($default = false)
	{
		$modules = [];
		if($default) {
			$modules[''] = self::translate($default);
		}
		$it = new DirectoryIterator('module/');
		foreach($it as $dir) {
			if($dir->isDir() AND $dir->getBasename() !== '.' AND $dir->getBasename() !== '..') {
				$module = $dir->getBasename() . 'Adm';
				$module = new $module;
				$modules[$dir->getBasename()] = $module::$name;
			}
		}
		return $modules;
	}

	/**
	 * Crée une liste des fichiers uploadés (format : chemin du fichier => fichier)
	 * @param  mixed    $default    Valeur par défaut
	 * @param  mixed    $extensions N'autorise que certains extensions
	 * @param  null|int $size       N'autorise que les images de taille inférieure à x ko
	 * @param  null|int $height     N'autorise que les images de x hauteur
	 * @param  null|int $width      N'autorise que les images de x largeur
	 * @return array
	 */
	public static function listUploads($default = false, array $extensions = [], $size = null, $height = null, $width = null)
	{
		$uploads = [];
		if($default) {
			$uploads[''] = self::translate($default);
		}
		$it = new DirectoryIterator('data/upload/');
		foreach($it as $file) {
			if(
				// Ingore les dossiers
				$file->isFile()
				// Ignore le fichier .gitkeep
				AND $file->getBasename() !== '.gitkeep'
				AND (
					// Aucun check si aucune extension n'est précisée
					empty($extensions)
					// Ignore les fichiers avec une extension incorrecte
					OR in_array(strtolower($file->getExtension()), $extensions)
				)
				// Ignore les fichiers trop volumineux
				AND ($size === null OR $size < $file->getSize())
			) {
				if(
					// Si le fichier est une image stock ses données dans une variable, sinon ignore le if
					$imageSize = @getimagesize('data/upload/' . $file->getBasename())
					// Ignore les fichiers qui dépassent la hauteur max
					AND ($height !== null AND $height > $imageSize[1])
					//Ignore les fichiers qui dépassent la largeur max
					AND ($width !== null AND $width > $imageSize[0])
				) {
					continue;
				}
				$uploads['data/upload/' . $file->getBasename()] = $file->getBasename();
			}
		}
		return $uploads;
	}

	/**
	 * Envoi un mail
	 * @param  string $from    Expéditeur
	 * @param  string $to      Destinataire
	 * @param  string $subject Sujet
	 * @param  string $message Message
	 * @return bool
	 */
	public static function mail($from, $to, $subject, $message)
	{
		// Retour chariot différent pour les adresses Microsoft
		$n = preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|outlook).[a-z]{2,4}$#", $to) ? "\n" : "\r\n";
		// Définition du séparateur
		$boundary = '-----=' . md5(rand());
		// Création du template
		$html = '<html><head></head><body>' . nl2br($message) . '</body></html>';
		$txt = strip_tags($html);
		// Définition du header
		$header = 'Reply-To: ' . $to . $n;
		if($from) {
			$header .= 'From: ' . $from . $n;
		}
		else {
			$header .= 'From: ' . helper::translate('Votre site ZwiiCMS') . ' <no-reply@' . $_SERVER['SERVER_NAME'] . '>' . $n;
		}
		$header .= 'MIME-Version: 1.0' . $n;
		$header .= 'Content-Type: multipart/alternative;' . $n . ' boundary="' . $boundary . '"' . $n;
		// Message au format texte
		$message .= $n . '--' . $boundary . $n;
		$message .= 'Content-Type: text/plain; charset="utf-8"' . $n;
		$message .= 'Content-Transfer-Encoding: 8bit' . $n;
		$message .= $n . $txt . $n;
		// Message au format HTML
		$message .= $n . '--' . $boundary . $n;
		$message .= 'Content-Type: text/html; charset="utf-8"' . $n;
		$message .= 'Content-Transfer-Encoding: 8bit' . $n;
		$message .= $n . $html . $n;
		// Fermeture des séparateurs
		$message .= $n . '--' . $boundary . '--' . $n;
		$message .= $n . '--' . $boundary . '--' . $n;
		// Accents dans le sujet d'un mail
		$subject = mb_encode_mimeheader($subject,'UTF-8', 'Q', $n);
		// Envoi du mail
		return @mail($to, $subject, $message, $header);
	}

	/**
	 * Minimise du css
	 * @param string  $css Css à minimiser
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
	 * @param string  $js Js à minimiser
	 * @return string
	 */
	public static function minifyJs($js) {
		// Supprime les commentaires
		$js =  preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|\s*(?<![\:\=])\/\/.*)/', '', $js);
		// Supprime les tabulations, espaces, nouvelles lignes, etc...
		$js = str_replace(["\r\n", "\r", "\t", "\n", '  ', '    ', '     '], '', $js);
		$js = preg_replace(['(( )+\))', '(\)( )+)'], ')', $js);
		// Retourne le js minifié
		return $js;
	}

	/**
	 * Vérifie que le module d'URL rewriting est activé sur le serveur
	 * @return bool
	 */
	public static function modRewriteCheck()
	{
		// Check si l'URL rewriting est activée
		if(function_exists('apache_get_modules')) {
			if(in_array('mod_rewrite', apache_get_modules())) {
				return true;
			}
		}
		// Check si l'URL rewriting est activée (si la fonction apache_get_modules() n'existe pas)
		if(function_exists('phpinfo') AND strpos(ini_get('disable_functions'), 'phpinfo') === false) {
			ob_start();
			phpinfo(8);
			$phpinfo = ob_get_clean();
			if(strpos($phpinfo, 'mod_rewrite') !== false) {
				return true;
			}
		}
		// Check si l'URL rewriting est activée (si PHP est installé en FastCGI)
		$htaccess =
			'RewriteEngine on' . PHP_EOL .
			'RewriteBase ' . helper::baseUrl(false, false) . 'core/tmp/' . PHP_EOL .
			'RewriteRule test check';
		if(
			!file_exists('core/tmp/.htaccess')
			OR !file_exists('core/tmp/check')
			OR md5_file('core/tmp/.htaccess') !== md5($htaccess)
		) {
			file_put_contents('core/tmp/.htaccess', $htaccess);
			file_put_contents('core/tmp/check', 'ok');
		}
		if(get_headers(helper::baseUrl(false) . 'core/tmp/test')[0] === 'HTTP/1.1 200 OK') {
			return true;
		}
		// l'URL rewriting n'est pas prise en charge
		return false;
	}

	/**
	 * Crée un système de pagination (retourne un tableau contenant les informations sur la pagination (first, last, pages))
	 * @param  array    $array Tableau de donnée à utiliser
	 * @param  string   $url   URL à utiliser, la dernière partie doit correspondre au numéro de page, par défaut utiliser $this->getUrl()
	 * @param  null|int $tab   ID d'un onglet
	 * @return array
	 */
	public static function pagination($array, $url, $tab = null)
	{
		// Scinde l'url
		$url = explode('/', $url);
		// Url de pagination
		$urlPagination = is_numeric(end($url)) ? array_pop($url) : 1;
		// Url de la page courante
		$urlCurrent = implode('/', $url);
		// Nombre d'éléments à afficher
		$nbElements = count($array);
		// Nombre de page
		$nbPage = ceil($nbElements / 10);
		// Page courante
		$currentPage = is_numeric($urlPagination) ? (int) $urlPagination : 1;
		// Premier élément de la page
		$firstElement = ($currentPage - 1) * 10;
		// Dernier élément de la page
		$lastElement = $firstElement + 10;
		$lastElement = ($lastElement > $nbElements) ? $nbElements : $lastElement;
		// Mise en forme de la liste des pages
		$pages = false;
		for($i = 1; $i <= $nbPage; $i++)
		{
			$disabled = ($i === $currentPage) ? ' class="disabled"' : false;
			$pages .= '<a href="' . helper::baseUrl() . $urlCurrent . '/' . $i . $tab . '"' . $disabled . '>' . $i . '</a>';
		}
		// Retourne un tableau contenant les informations sur la pagination
		return [
			'first' => $firstElement,
			'last' => $lastElement,
			'page' => template::div([
				'text' => $pages,
				'class' => 'pagination'
			])
		];
	}

	/**
	 * Redirige vers une page du site ou une page externe et sauvegarde les données du formulaire si il existe des notices
	 * @param string  $url     Url de destination
	 * @param bool    $baseUrl Ajoute ou non l'URL de base à la redirection
	 */
	public static function redirect($url, $baseUrl = true)
	{
		// Sauvegarde des données en méthode POST si une notice existe
		if(template::$notices) {
			foreach($_POST as $postKey => $postValue) {
				if(is_array($postValue)) {
					foreach($postValue as $subPostKey => $subPostValue) {
						template::$before[$postKey . '[' . $subPostKey . ']'] = $subPostValue;
					}
				}
				else {
					template::$before[$postKey] = $postValue;
				}
			}
		}
		// Sinon redirection
		else {
			http_response_code(301);
			header('Location: ' . ($baseUrl ? self::baseUrl() : false) . $url);
			exit();
		}
	}

	/**
	 * Vérifie l'état de l'URL rewriting
	 * @return bool
	 */
	public static function rewriteCheck()
	{
		if(self::$rewriteStatus === null) {
			// Ouvre et scinde le fichier .htaccess
			$htaccess = explode('# URL rewriting', file_get_contents('.htaccess'));
			// Retourne un boolean en fonction du contenu de la partie réservée à l'URL rewriting
			self::$rewriteStatus = !empty($htaccess[1]);
		}
		return self::$rewriteStatus;
	}

	/**
	 * Traduit les textes
	 * @param  string $text Texte à traduire
	 * @return string
	 */
	public static function translate($text) {
		// Traduit le texte en cherchant dans le tableau de langue (ajout d'un (string) au cas ou un $key est vide)
		if(array_key_exists((string) $text, core::$language)) {
			$text = core::$language[$text];
		}
		return $text;
	}
}

class template
{
	/** @var array Notices rattachées à des champs ($input => $notice) */
	public static $notices = [];

	/** @var array Valeur des champs avant validation et erreur dans le formulaire */
	public static $before = [];

	############################################################
	# GETTERS/SETTERS & AUTRES

	/**
	 * Valeur du champ avant validation et erreur dans le formulaire
	 * @param  string $id Dd du champ
	 * @return mixed
	 */
	private static function getBefore($id) {
		return array_key_exists($id, self::$before) ? self::$before[$id] : null;
	}

	/**
	 * Retourne et met en forme une notice depuis une $id
	 * @param  string $id Id du champ
	 * @return string
	 */
	private static function getNotice($id) {
		return '<div class="notice">' . helper::translate(self::$notices[$id]) . '</div>';
	}

	/**
	 * Retourne une notice pour les champs obligatoires
	 * @param string $name Nom du champ
	 */
	public static function getRequired($name)
	{
		if(!empty($_SESSION['REQUIRED']) AND array_key_exists($name . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			self::$notices[$name] = 'Ce champ est requis';
		}
	}

	/**
	 * Enregistre un champ comme obligatoire
	 * @param string $id         Id du champ
	 * @param array  $attributes Transmet l'attribut "required" à la méthode
	 */
	private static function setRequired($id, $attributes)
	{
		// Supprime l'id du champs si il existe déjà (au cas ou un champ devient non obligatoire)
		if(!empty($_SESSION['REQUIRED']) AND array_key_exists($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			unset($_SESSION['REQUIRED'][$id . '.' . md5($_SERVER['QUERY_STRING'])]);
		}
		// Enregistre l'id du champ comme obligatoire
		if(!empty($attributes['required']) AND (empty($_SESSION['REQUIRED']) OR !array_key_exists($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED']))) {
			$_SESSION['REQUIRED'][$id . '.' . md5($_SERVER['QUERY_STRING'])] = true;
		}
	}

	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param  array $array   Liste des attributs ($key => $value)
	 * @param  array $exclude Clés à ignorer ($key)
	 * @return string
	 */
	private static function sprintAttributes(array $array = [], array $exclude = [])
	{
		// Required est exclu pour privilégier le système de champs requis du système
		$exclude = array_merge(['col', 'offset', 'label', 'help', 'selected', 'required'], $exclude);
		$attributes = [];
		foreach($array as $key => $value) {
			if($value AND !in_array($key, $exclude)) {
				// Champs à traduire
				if(in_array($key, ['placeholder'])) {
					$attributes[] = sprintf('%s="%s"', $key, helper::translate($value));
				}
				else {
					$attributes[] = sprintf('%s="%s"', $key, $value);
				}
			}
		}
		return implode(' ', $attributes);
	}

	############################################################
	# FORMULAIRE & ROW

	/**
	 * Ferme le formulaire
	 * @return string
	 */
	public static function closeForm()
	{
		return '</form>';
	}

	/**
	 * Ferme une ligne
	 * @return string
	 */
	public static function closeRow()
	{
		return '</div>';
	}

	/**
	 * Ferme la ligne courante et ouvre une ligne
	 * @return string
	 */
	public static function newRow()
	{
		return '</div><div class="row">';
	}

	/**
	 * Crée un formulaire
	 * @param  string $nameId     Nom & id du formulaire
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string
	 */
	public static function openForm($nameId = 'form', $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'action' => '',
			'method' => 'post',
			'enctype' => '',
			'class' => ''
		], $attributes);
		// Retourne le html
		return sprintf('<form %s>', self::sprintAttributes($attributes));
	}

	/**
	 * Ouvre une ligne
	 * @return string
	 */
	public static function openRow()
	{
		return '<div class="row">';
	}

	############################################################
	# CHAMPS

	/**
	 * Crée un bouton
	 * @param  string $nameId     Nom & id du bouton
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function button($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => 'Bouton',
			'href' => 'javascript:void(0);',
			'target' => '',
			'onclick' => '',
			'disabled' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Bouton
		$html .= sprintf(
			'<a %s class="button %s %s">%s</a>',
			self::sprintAttributes($attributes, ['value', 'class', 'disabled']),
			$attributes['disabled'] ? 'disabled' : '',
			$attributes['class'],
			helper::translate($attributes['value'])
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ capcha
	 * @param  string $nameId     Nom & id du champ texte court
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function capcha($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'required' => 'required',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Génère deux nombres pour le capcha
		$firstNumber = mt_rand(1, 15);
		$secondNumber = mt_rand(1, 15);
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper']. '">';
		// Label
		$html .= self::label($attributes['id'], 'Qu\'elle est la somme de ' . $firstNumber . ' + ' . $secondNumber . ' ?', [
			'help' => $attributes['help']
		]);
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Capcha
		$html .= sprintf(
			'<input type="text" %s>',
			self::sprintAttributes($attributes)
		);
		// Champs cachés contenant les nombres
		$html .= self::hidden($nameId . 'FirstNumber', [
			'value' => $firstNumber,
			'before' => false
		]);
		$html .= self::hidden($nameId . 'SecondNumber', [
			'value' => $secondNumber,
			'before' => false
		]);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée case à cocher à sélection multiple
	 * @param  string $nameId     Nom & id de la case à cocher à sélection multiple
	 * @param  string $value      Valeur de la case à cocher à sélection multiple
	 * @param  string $label      Label de la case à cocher à sélection multiple
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function checkbox($nameId, $value, $label, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'checked' => '',
			'disabled' => '',
			'required' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="checkbox" value="%s" %s>',
			$value,
			self::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($attributes['id'], $label, [
			'help' => $attributes['help']
		]);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un sélecteur de couleur
	 * @param  string $nameId     Nom & id du sélecteur de couleur
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function colorPicker($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'placeholder' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'transparent' => true,
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($attributes['id'])) !== null) {
			$attributes['value'] = $value;
		}
		// Message d'aide si la transparence est activée
		if($attributes['transparent']) {
			$attributes['help'] = 'Vous pouvez utiliser la transparence en laissant le champ vide.';
		}
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper']. '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="text" class="jscolor {required: %s, shadow: false, borderRadius: false} %s" %s>',
			$attributes['transparent'] ? 'false' : 'true', // Pour afficher les booleans en string
			$attributes['class'],
			self::sprintAttributes($attributes, ['class', 'transparent'])
		);
		// Fin col
		$html .= '</div>';
		// Charge la librairie jsColor
		core::$vendor['jscolor'] = true;
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une div
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string
	 */
	public static function div($attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => '',
			'text' => '',
			'class' => '',
			'data-1' => '',
			'data-2' => '',
			'data-3' => '',
			'col' => 0,
			'offset' => 0
		], $attributes);
		// Retourne le html
		return sprintf(
			'<div class="col%s offset%s %s" %s>%s</div>',
			$attributes['col'],
			$attributes['offset'],
			$attributes['class'],
			self::sprintAttributes($attributes, ['class', 'text']),
			helper::translate($attributes['text'])
		);
	}

	/**
	 * Crée un champ d'upload de fichier
	 * @param  string $nameId     Nom & id du champ d'upload de fichier
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function file($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'disabled' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($attributes['id'])) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<label class="inputFile %s">' . self::ico('download') . '<span class="inputFileLabel">' . helper::translate('Choisissez un fichier') . '</span><input type="file" %s></label>',
			$attributes['class'],
			self::sprintAttributes($attributes, ['class'])
		);
		// Fin col
		$html .= '</div>';
		// Script
		$html .= self::script('			
			$("#' . $attributes['id'] . '").on("change", function() {
				var fileDOM = $(this);
				var fileName = fileDOM.val().split("\\\").pop();
				if(!fileName) {
					fileName = "' . helper::translate('Choisissez un fichier') . '";
				}
				fileDOM.parents(".inputFile").find(".inputFileLabel").text(fileName);
			})
		');
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une aide qui s'affiche au survole
	 * @param  string $text Texte de l'aide
	 * @return string
	 */
	public static function help($text)
	{
		return '<span class="helpButton">' . self::ico('help') . '<div class="helpContent">' . helper::translate($text) . '</div></span>';
	}

	/**
	 * Crée un champ caché
	 * @param  string $nameId     Nom & id du champ caché
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function hidden($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'class' => '',
			'before' => true
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($attributes['id'])) !== null AND $attributes['before']) {
			$attributes['value'] = $value;
		}
		// Texte
		$html = sprintf('<input type="hidden" %s>', self::sprintAttributes($attributes, ['before']));
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un icône
	 * @param  string $ico    Nom de l'icône à ajouter
	 * @param  bool   $margin Ajoute un margin à droite de l'icône
	 * @return string
	 */
	public static function ico($ico, $margin = false)
	{
		return '<span class="zwiico-' . $ico . ($margin ? ' zwiico-margin' : '') . '"></span>';
	}

	/**
	 * Crée un label
	 * @param  string $for        For du label
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @param  string $text       Texte du label
	 * @return string
	 */
	public static function label($for, $text, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'for' => $for,
			'help' => '',
			'class' => ''
		], $attributes);
		// Traduit le text
		$text = helper::translate($text);
		// Ajout d'une aide
		if(!empty($attributes['help'])) {
			$text = $text . self::help($attributes['help']);
		}
		// Retourne le html
		return sprintf(
			'<label %s>%s</label>',
			self::sprintAttributes($attributes),
			$text
		);
	}

	/**
	 * Crée un champ mot de passe
	 * @param  string $nameId     Nom & id du champ mot de passe
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function password($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'autocomplete' => 'on',
			'placeholder' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Mot de passe
		$html .= sprintf(
			'<input type="password" %s>',
			self::sprintAttributes($attributes)
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une case à cocher à sélection unique
	 * @param  string $nameId     Nom & id de la case à cocher à sélection unique
	 * @param  string $value      Valeur de la case à cocher à sélection unique
	 * @param  string $label      Label de la case à cocher à sélection unique
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function radio($nameId, $value, $label, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'checked' => '',
			'disabled' => '',
			'required' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="radio" value="%s" %s>',
			$value,
			self::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($attributes['id'], $label, [
			'help' => $attributes['help']
		]);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un script et le minimise
	 * @param  string $script Script à intégrer
	 * @return string
	 */
	public static function script($script)
	{
		return '<script>' . helper::minifyJs($script) . '</script>';
	}

	/**
	 * Crée un champ sélection
	 * @param  string $nameId     Nom & id du champ de sélection
	 * @param  array  $options    Liste des options du champ de sélection ($value => $text)
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function select($nameId, array $options, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'selected' => '',
			'disabled' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($selected = self::getBefore($attributes['id'])) {
			$attributes['selected'] = $selected;
		}
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Début sélection
		$html .= sprintf('<select %s>',
			self::sprintAttributes($attributes)
		);
		// Options
		foreach($options as $value => $text) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				$value,
				$attributes['selected'] === $value ? ' selected' : '',
				helper::translate($text)
			);
		}
		// Fin sélection
		$html .= '</select>';
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un bouton validation
	 * @param  string $nameId     Nom & id du bouton validation
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function submit($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => 'Enregistrer',
			'disabled' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Bouton
		$html .= sprintf(
			'<input type="submit" value="%s" %s>',
			helper::translate($attributes['value']),
			self::sprintAttributes($attributes, ['value'])
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un sous-titre
	 * @param  string $text Texte du sous-titre
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string
	 */
	public static function subTitle($text, $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => '',
			'class' => '',
			'data-1' => '',
			'data-2' => '',
			'data-3' => ''
		], $attributes);
		// Retourne le html
		return sprintf(
			'<h4 %s>%s</h4>',
			self::sprintAttributes($attributes),
			helper::translate($text)
		);
	}

	/**
	 * Crée un tableau
	 * @param  array  $cols       Cols des colonnes du tableau (format: [col colonne1, col colonne2, col colonne3, etc])
	 * @param  array  $body       Contenu du tableau (format: [[contenu1, contenu2, contenu3, etc], [contenu1, contenu2, contenu3, etc]])
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function table(array $cols = [], array $body = [], array $attributes = []) {
		// Attributs possibles
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Début tableau
		$html .= '<table class="' . $attributes['class']. '">';
		// Début contenu
		$html .= '<tbody>';
		foreach($body as $tr) {
			$html .= '<tr>';
			$i = 0;
			foreach($tr as $td) {
				$html .= '<td class="col' . $cols[$i] . '">' . $td . '</td>';
				$i++;
			}
			$html .= '</tr>';
		}
		// Fin contenu
		$html .= '</tbody>';
		// Début tableau
		$html .= '<table class="' . $attributes['class']. '">';
		// Fin tableau
		$html .= '</table>';
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée des onglets
	 * @param  array $tabs Onglets à créer (format: ['titre onglet 1' => 'contenu onglet 1', 'titre onglet 2' => 'contenu onglet 2', etc])
	 * @return string
	 */
	public static function tabs(array $tabs = [])
	{
		$id = uniqid();
		$titles = '';
		$contents = '';
		$i = 1;
		// Met en forme les onglets
		foreach($tabs as $title => $content) {
			$titles .= self::div([
				'class' => 'tabTitle ' . $id . ($i === 1 ? ' current' : ''),
				'data-1' => $i,
				'text' => $title
			]);
			$contents .= self::div([
				'class' => 'tabContent ' . $id . ($i === 1 ? '' : ' displayNone'),
				'data-1' => $i,
				'text' => $content
			]);
			$i++;
		}
		return
			self::div([
				'class' => 'tabTitles',
				'text' => $titles
			]).
			$contents.
			self::script('
				// Affiche/cache les onglets
				var tabTitles = $("#' . $id . '");
				$(".' . $id . '.tabTitle").on("click", function() {
					var tabTitle = $(this);
					// Si le titre cliqué n\'est pas celui de l\'onglet courant
					if(tabTitle.hasClass("current") === false) {
						// Sélectionne le titre de l\'onglet courant
						$(".' . $id . '.tabTitle.current").removeClass("current");
						tabTitle.addClass("current");
						// Affiche le contenu de l\'onglet courant
						$(".' . $id . '.tabContent:visible").hide();
						$(".' . $id . '.tabContent[data-1=" + tabTitle.attr("data-1") + "]").show();
					}
					// Ajoute le hash dans l\'URL
					window.location.hash = tabTitle.attr("data-1");
				});
				// Affiche le bon onglet si un hash est présent dans l"URL
				var hash = window.location.hash.substr(1);
				if(hash) {
					var tabTitle = $(".' . $id . '.tabTitle[data-1=\'" + hash + "\']");
					if(tabTitle.length) {
						tabTitle.trigger("click");
					}
				}
			');
	}

	/**
	 * Crée un champ texte court
	 * @param  string $nameId     Nom & id du champ texte court
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function text($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'placeholder' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($attributes['id'])) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper']. '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="text" %s>',
			self::sprintAttributes($attributes)
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte long
	 * @param  string $nameId     Nom & id du champ texte long
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function textarea($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'editor' => false,
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($attributes['id'], $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($attributes['id'])) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$attributes['id']])) {
			$html .= self::getNotice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Texte long
		$html .= sprintf(
			'<textarea %s>%s</textarea>',
			self::sprintAttributes($attributes, ['value', 'editor']),
			$attributes['value']
		);
		// Fin col
		$html .= '</div>';
		// Charge la librairie TinyMCE
		if($attributes['editor']) {
			core::$vendor['tinymce'] = true;
			$html .= self::script('
				// Charge tinyMCE
				var language = navigator.languages ? navigator.languages[0] : (navigator.language || navigator.userLanguage);
				var body = $("body");
				tinymce.init({
					selector: "#' . $attributes['id'] . '",
					language: language.split("-")[0],
					plugins: "advlist anchor autolink autoresize charmap code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media nonbreaking noneditable paste preview print searchreplace tabfocus table textcolor textpattern visualchars wordcount",
					toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
					body_class: "editor",
					content_css: [
						"core/theme.css",
						"core/cache/' . core::$cssVersion . '.css",
					],
					relative_urls: false,
					file_browser_callback: function(fieldName) {
						$("#editorField").val(fieldName);
						$("#editorFile").trigger("click");
					},
					file_browser_callback_types: "image"
				});
			');
		}
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un titre
	 * @param  string $text Texte du titre
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string
	 */
	public static function title($text, $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => '',
			'class' => '',
			'data-1' => '',
			'data-2' => '',
			'data-3' => ''
		], $attributes);
		// Retourne le html
		return sprintf(
			'<h3 %s>%s</h3>',
			self::sprintAttributes($attributes),
			helper::translate($text)
		);
	}
}