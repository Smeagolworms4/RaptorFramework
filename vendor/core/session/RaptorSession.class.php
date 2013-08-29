<?php 

/**
 * Class permettant de gérer les sessions PHP
 *
 */
class RaptorSession {
	
	
	const DEFAULT_NAMESPACE = 'default';
	const SESSION_ENVIRONNEMENT = 'RaptorSession';
	
	/**
	 * Initialisation
	 * @var array
	 */
	private static $_isInit = false;
	
	/**
	 * Initialise les variables request
	 */
	public static function initialise () {
		if (!self::$_isInit) {
			self::$_isInit = true;
			session_start ();
			if (!isset ($_SESSION[self::SESSION_ENVIRONNEMENT])) {
				$_SESSION[self::SESSION_ENVIRONNEMENT] = array ();
			}
		}
	}

	/**
	 * Destruction d'une variable en session
	 * @param string $var       Nom de la variable
	 * @param string $namespace Namespace dans lequel est la variable à supprimer
	 */
	public static function delete ($var, $namespace = self::DEFAULT_NAMESPACE) {
		self::initialise();
		
		if (isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace]) && isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace][$var])) {
			unset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace][$var]);
		}
	}
	
	/**
	 * Définition d'une variable dans la session
	 *
	 * @param string $var       Nom de la variable
	 * @param mixed  $value     Valeur de la variable
	 * @param string $namespace Namespace dans lequel on veut placer la variable
	 */
	public static function set ($var, $value, $namespace = self::DEFAULT_NAMESPACE) {
		self::initialise();
		
		if (!isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace])) {
			$_SESSION[self::SESSION_ENVIRONNEMENT][$namespace] = array ();
		}
		$_SESSION[self::SESSION_ENVIRONNEMENT][$namespace][$var] = $value;
	}
	
	/**
	 * Destruction de toutes les informations qui ont été rajoutées dans le namespace indiqué
	 * @param string $namespace Namespace à supprimer
	 */
	public static function destroyNamespace ($namespace = self::DEFAULT_NAMESPACE) {
		self::initialise();
		
		if (isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace])) {
			unset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace]);
		}
	}
	
	/**
	 * Retourne la valeur d'une variable en session
	 *
	 * @param string $var          Nom de la variable
	 * @param mixed  $defaultValue Valeur par défaut si la variable n'existe pas
	 * @param string $namespace    Namespace dans lequel on veut lire la variable
	 * @return mixed
	 */
	public static function get ($var, $defaultValue = null, $namespace = self::DEFAULT_NAMESPACE) {
		self::initialise();
		$return = $defaultValue;
		
		if (isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace]) && isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace][$var])) {
			$return = $_SESSION[self::SESSION_ENVIRONNEMENT][$namespace][$var];
		}
		
		return $return;
	}
	
	/**
	 * Indique si une variable existe en session
	 *
	 * @param string $var       Nom de la variable
	 * @param string $namespace Namespace
	 * @return bool
	 */
	public static function exists ($var, $namespace = self::DEFAULT_NAMESPACE) {
		self::initialise();
		
		return isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace]) && isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace][$var]);
	}
	
	/**
	 * Retourne la liste des namespaces
	 *
	 * @return array
	 */
	public static function getNamespaces () {
		self::initialise();
		
		return array_keys($_SESSION[self::SESSION_ENVIRONNEMENT]);
	}
	
	/**
	 * Retourne les variables définies dans le namespace $pNamespace
	 *
	 * @param string $namespace Namespace dont on veut les variables
	 * @return array
	 */
	public static function getVariables ($namespace = self::DEFAULT_NAMESPACE) {
		self::initialise();
		
		$return = array ();
		if (isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace])) {
			$return = array_keys ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace]);
		}
		return $return;
	}
	
	/**
	 * Indique si le namespace $pNamespace existe
	 *
	 * @param string $pNamespace Namespace dont on veut vérifier l'existance
	 * @return boolean
	 */
	public static function namespaceExists ($pNamespace) {
		self::initialise();
		
		return isset ($_SESSION[self::SESSION_ENVIRONNEMENT][$namespace]);
	}
	
}
