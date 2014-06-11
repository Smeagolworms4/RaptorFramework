<?php

/**
 * Class permettant de centraliserr la gestion des requete $_GET et $_POST
 *
 */
class RaptorRequest {

	/**
	 * Liste des request
	 * @var array
	 */
	private static $_request = array();

	/**
	 * Initialise les variables request
	 */
	private static function _initialise () {
		if (!self::$_request) {
			self::$_request = array_merge ($_GET, $_POST);
		}
		
	}
	
	/**
	 * Affecte une valeur
	 * @param string $name
	 * @param mixed $value
	 */
	public static function set ($name, $value) {
		self::_initialise();
		self::$_request[$name] = $value;
	}
	
	/**
	 * Renvoie la valeur $_GET ou $_POST correspondant à name
	 * @param string $name
	 * @param mixed  $defaultValue
	 * @return mixed
	 */
	public static function get ($name, $defaultValue = NULL) {
		self::_initialise();
		if (isset (self::$_request[$name])) {
			return self::$_request[$name];
		}
		return $defaultValue;
	}
	
	/**
	 * @param string $name
	 */
	public static function assert ($name) {
		if (!isset (self::$_request[$name])) {
			throw new RaptorRequestException (__('Le paramètre \'%0\' n\'existe pas.', $name));
		}
	}

	/**
	 * @param string $name
	 * return boolean
	 */
	public static function test ($name) {
		try {
			self::assert ($name);
			return true;
		} catch (RaptorRequestException $e) {
			return false;
		}
	}
	
}
