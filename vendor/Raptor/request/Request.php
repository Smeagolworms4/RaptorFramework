<?php

namespace Raptor\request;

use Raptor\annotation\annotations\Service;

/**
 * Class permettant de centraliserr la gestion des requete $_GET et $_POST
 * @Service ("request")
 */
class Request {

	/**
	 * Liste des request
	 * @var array
	 */
	private $_request = array();

	/**
	 * Initialise les variables request
	 */
	public function __construct ($get = NULL, $post = NULL, $server = NULL) {

		$get    = ($get)    ? $get    : $_GET;
		$post   = ($post)   ? $post   : $_POST;
		$server = ($server) ? $server : $_SERVER;
		
		if (!$this->_request) {
			$this->_request = array_merge ($get, $post);
		}
		
	}
	
	/**
	 * Affecte une valeur
	 * @param string $name
	 * @param mixed $value
	 */
	public function set ($name, $value) {
		$this->_request[$name] = $value;
	}
	
	/**
	 * Renvoie la valeur $_GET ou $_POST correspondant à name
	 * @param string $name
	 * @param mixed  $defaultValue
	 * @return mixed
	 */
	public function get ($name, $defaultValue = NULL) {
		if (isset ($this->_request[$name])) {
			return $this->_request[$name];
		}
		return $defaultValue;
	}
	
	/**
	 * @param string $name
	 */
	public function assert ($name) {
		if (!isset ($this->_request[$name])) {
			throw new RequestException (__('Le paramètre \'%0\' n\'existe pas.', $name));
		}
	}

	/**
	 * @param string $name
	 * return boolean
	 */
	public function test ($name) {
		try {
			$this->assert ($name);
			return true;
		} catch (RequestException $e) {
			return false;
		}
	}
	
}
