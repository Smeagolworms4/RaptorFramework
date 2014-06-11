<?php

namespace Raptor\exception;

/**
 * Gestion des exception pour Raptor
 * 
 */
class Exception extends \Exception {
	/**
	 * Informations supplémentaires
	 * @var array
	 */
	private $_extras = array ();
	
	/**
	 * Constructeur
	 *
	 * @param string $msg    Texte du message d'erreur
	 * @param int    $code   Code du message
	 * @param array  $extras Informations supplémentaires
	 */
	public function __construct ($msg, $code = 0, $extras = array ()) {
		parent::__construct ($msg, $code);
		$this->_extras = $extras;
	}
	
	/**
	 * Retourne les informations supplémentaires
	 *
	 * @return array
	 */
	public function getExtras () {
		return $this->_extras;
	}
	
	/**
	 * Retourne une information particulière, ou la valeur par défaut si elle n'existe pas
	 *
	 * @param string $name         Nom de l'information
	 * @param mixed  $defaultValue
	 * @return mixed
	 */
	public function getExtra ($name, $defaultValue = null) {
		return (isset ($this->_extras [$name])) ? $this->_extras[$name] : $defaultValue;
	}
}