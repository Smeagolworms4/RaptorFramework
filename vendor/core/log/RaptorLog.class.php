<?php

require_once (LIBS_PATH.'Firephp/fb.php');

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
		if (_ioClass ('RaptorConfig')->MODE == RaptorConfig::MODE_DEV) {
			FB::info ($objet, $label);
		}
	}
	
	/**
	 * Execute un log
	 * @param mixed $objet
	 * @param string $label
	 */
	public function log ($objet, $label = '') {
		FB::log ($objet, $label);
	}
	
	/**
	 * Execute un warning
	 * @param mixed $objet
	 * @param string $label
	 */
	public function warn ($objet, $label = '') {
		FB::warn ($objet, $label);
	}
	
	/**
	 * Execute une erreur
	 * @param mixed $objet
	 * @param string $label
	 */
	public function error ($objet, $label = '') {
		FB::error ($objet, $label);
	}
}