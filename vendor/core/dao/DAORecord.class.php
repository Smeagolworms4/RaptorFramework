<?php

namespace Raptor;

/**
 * Objet de resultat d'une requete SQL
 */
class DAORecord {
	
	/**
	 * Liste des element à mettre à jour
	 * @var array
	 */
	private $_updateList = array ();
	private $_values = array ();
	
	/**
	 * Constructeur
	 */
	public function __construc () {
	}
	
	/**
	 * Affect les valeurs au DAORecord
	 * @param string $name
	 * @param Ambigous <NULL, multitype:> $value
	 */
	public function __set ($name, $value) {
		$this->_updateList[$name] = (isset ($this->_values[$name]) && $this->_values[$name] != $value);
		$this->_values[$name] = $value;
	}
	
	/**
	 * Renvoie in valeur du DAO Record
	 * @param string $name
	 * @return Ambigous <NULL, multitype:>
	 */
	public function __get ($name) {
		return isset ($this->_values[$name]) ? $this->_values[$name] : NULL;
	}
	
	/**
	 * Test si un champs doit etre mis à jour
	 * @param string $name
	 * @return boolean
	 */
	public function mustUpdate ($name) {
		return isset ($this->_updateList[$name]) ? $this->_updateList[$name] : false;
	}
	
	/**
	 * Convertit les valeurs en objet
	 */
	public function toArray () {
		return $this->_values;
	}
	
	public function updateAllField () {
		foreach ($this->_updateList as $key=>$value) {
			$this->_updateList[$key] = true;
		}
	}
}
