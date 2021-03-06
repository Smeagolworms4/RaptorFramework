<?php

namespace Raptor\config;

use Raptor\annotation\annotations\Service;

 /**
 * @Service ("config")
 * @author Damien Duboeuf
 */
class Config {

	const MODE_DEV = 'DEV';
	const MODE_PROD = 'PROD';
	public static $WORKSPACE_CONFIG_FILE = '';
	
	
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
	 * Constructeur
	 */
	public function __construct () {
		self::$WORKSPACE_CONFIG_FILE = WORKSPACE_PATH.'config.php';
	}
	
	/**
	 * Charge le fichier de configuration du workspace
	 */
	public function loadWorkspaceConfig () {
		if (file_exists (self::$WORKSPACE_CONFIG_FILE)) {
			require_once (self::$WORKSPACE_CONFIG_FILE);
		}
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
	 * @var string
	 */
	public $MODE = self::MODE_DEV;
	
	/**
	 * Mode production (DEV/PROD)
	 * @var string
	 */
	public $VERSION = '0.1';
	
	/**
	 * Ips autorisés à l'intallation du framework
	 * @var string[]
	 */
	public $arInstallIp = array ('127.0.0.1');
	
	/**
	 * Page d'accueil - format : module|controler|action
	 * @var string
	 */
	public $homePage = 'picross';

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
