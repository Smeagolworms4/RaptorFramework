<?php
/**
 * Class PHP permettant de gérer la configuration
 * 
 */
class RaptorConfig {
	
	/**
	 * L'instance
	 * @var RaptorConfig
	 */
	private static $_instance = null;
	
	/**
	 * Liste des paramètres de la config qui seront envoyés au JS
	 * @var array
	 */
	private $_javascriptConfig = array (
		'DATE_FORMAT',
		'NUMBER_DEC_SEPARATOR',
		'VERSION',
	);
	
	/**
	 * Liste des paramètres de la config qui seront envoyés au JS
	 * @var array
	 */
	private $_javascriptConfigEdit = array (
		'LIST_EDIT_SHORTCUT',
	);
	
	/**
	 * Retoune l'instance
	 * @return RaptorConfig
	 */
	public static function getInstance () {
		if (self::$_instance == null) {
			self::$_instance = new RaptorConfig ();
		}
		return self::$_instance;
	}
	
	/**
	 * Constructeur
	 */
	private function __construct () {
	}
	
	/**
	 * Renvoie la config spécial pour le JS
	 * @param bool $isEditor
	 * @return array
	 */
	public function getJavascriptConfig ($isEditor = false) {
		$return = array ();
		foreach ($this->_javascriptConfig as $key) {
			$return[$key] = $this->$key;
		}
		if ($isEditor) {
			foreach ($this->_javascriptConfigEdit as $key) {
				$return[$key] = $this->$key;
			}
		}
		return $return;
	}
	
	public function localIsAvailable ($local) {
		return in_array($local, $this->localAvailable);
	}
	
	public $localAvailable = array ('fr_FR', 'fr', 'en_EN', 'en');
	
	/**
	 * Liste des connexions
	 * @var array ('driver'=>'pdo_mysq', 'connectionName'=>array ('host'=>'', 'database'=>'', 'user'=>'', 'password'=>''))
	 */
	public $arConnection = array ();
	
	/**
	 * Nom de la connexion par défaut
	 * @var string
	 */
	public $defaultConnection = null;
	
	/**
	 * Format date par défaut compatible JS
	 * @var string
	 */
	public $DATE_FORMAT = 'dd/mm/yy';
	
	/**
	 * Séparateur de nombre par défaut
	 * @var string
	 */
	public $NUMBER_DEC_SEPARATOR = ',';
	
	/**
	 * Mode production (DEV/PROD)
	 * @var unknown_type
	 */
	public $MODE = 'PROD';
	
	/**
	 * Liste des raccourcis de l'editor
	 */
	public $LIST_EDIT_SHORTCUT = array (
		'menu.file' => array ('Alt', 'F'),
		'menu.file.new'    => array ('Ctrl', 'N'),
		'menu.file.open'   => array ('Ctrl', 'O'),
		'menu.file.save'   => array ('Ctrl', 'S'),
		'menu.file.saveto' => array ('Ctrl', 'Shift', 'S'),
		'menu.file.import' => array ('Ctrl', 'I'),
		
		'menu.edit' => array ('Alt', 'E'),
	);

	/**
	 * Page d'accueil - format : module|controler|action
	 * @var string
	 */
	public $homePage = 'default|default|default';

	/**
	 * Page d'accueil - format : module|controler|action
	 * @var string
	 */
	public $error404Page = 'default|default|404';
	
	/**
	 * Titre des pages
	 * @var string
	 */
	public $titlePage = 'Raptor Framework';
	
	/**
	 * Script par défaut
	 * @var string
	 */
	public $defaultScript = 'index.php';

	/**
	 * Préfixe des tables de la bdd
	 * @var string
	 */
	public $dataTablePrefixe = 'rtp_';
	
	/**
	 * Thème du frameworkpour les surcharge de ressource
	 * @var string
	 */
	public $theme = NULL;
}