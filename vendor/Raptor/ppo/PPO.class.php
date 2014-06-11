<?php 

namespace Raptor/ppo;

/**
 * Class permettant de faire passer des datas à smarty de manière propre sans générer de notice
 *
 */
class PPO {
	
	/**
	 * Variable initialisé à la construction de l'objet
	 * @var array
	 */
	private static $_initialiseVars = array ();
	
	/**
	 * Constructeur
	 */
	public function __construct () {
		foreach (self::$_initialiseVars as $key=>$value) {
			$this->$key = $value;
		}
	}
	
	/**
	 * Ajoute une variable pour la construction de l'objet
	 * @param string $name
	 * @param mixed $value
	 */
	public static function addInitVars ($name, $value) {
		self::$_initialiseVars[$name] = $value;
	}
	
	/**
	 * Supprime une variale de construction
	 * @param string $key
	 */
	public static function delInitVars ($name) {
		if (isset (self::$_initialiseVars[$name])) {
			unset (self::$_initialiseVars[$name]);
		}
	}
	
	/**
	* Retourne l'élément où sauvegarder la donnée
	*
	* @param string $pName Nom de la propriété à récupérer
	* @return mixed
	*/
	public function __get ($pName) {
		$this->$pName = new PPO ();
		return $this->$pName;
	}
	
	/**
	 * En cas de demande d'affichage directe
	 *
	 * @return string
	 */
	public function __toString () {
		return '';
	}
}