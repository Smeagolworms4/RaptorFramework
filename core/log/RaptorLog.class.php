<?php
/**
 * Class PHP permettant de gérer les logs
 */
class RaptorLog {
	
	/**
	 * @var bool
	 */
	static private $_init = false;
	
	/**
	 * Initialise FirePhp
	 */
	static private function _initialise () {
		if (!self::$_init) {
			self::$_init =  true;
			require_once (LIBS_PATH.'Firephp/fb.php');
		}
	}
	
	/**
	 * Constructeur
	 */
	public function __construct () {
		self::_initialise ();
	}
	
	/**
	 * Execute une info
	 * @param mixed $objet
	 * @param string $label
	 */
	public function info ($objet, $label = '') {
		return FB::info ($objet, $label);
	}
	
	/**
	 * Execute un log
	 * @param mixed $objet
	 * @param string $label
	 */
	public function log ($objet, $label = '') {
		return FB::log ($objet, $label);
	}
	
	/**
	 * Execute un warning
	 * @param mixed $objet
	 * @param string $label
	 */
	public function warn ($objet, $label = '') {
		return FB::warn ($objet, $label);
	}
	
	/**
	 * Execute une erreur
	 * @param mixed $objet
	 * @param string $label
	 */
	public function error ($objet, $label = '') {
		return FB::error ($objet, $label);
	}
}