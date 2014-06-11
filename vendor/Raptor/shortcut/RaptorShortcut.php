<?php

namespace Raptor\shortcut;

use Raptor\service\ServiceFactory;
class RaptorShortcut {
	
	/**
	 * RaptorRequest::get
	 * @param string $name
	 * @param mixed  $defaultValue
	 * @return mixed
	 */
	public static function request ($name, $defaultValue = NULL) {
		$request = self::service ('request');
		return $request->get ($name, $defaultValue); 
	}
	
	/**
	 * Crée our écupère la dernière instance de l'objet
	 * @param string $className
	 * @param mixed  ...
	 * @return mixed
	 */
	public static function service () {
		return call_user_func_array (array ("Raptor\\service\\ServiceFactory", "iOGet"), func_get_args ());
	}
	
	/**
	 * Retour d'action vide
	 * @return RaptorActionReturnNone
	 */
	public static function arNone () {
		return new Raptor\ActionReturnNone ();
	}
	
	/**
	 * Retour d'action avec telmplate smarty et template principale de la page
	 * @param PPO $ppo
	 *                  - $ppo->MAINTEMPLATE  = Adresse du template principal
	 *                  - $ppo->TITLEPAGE     = Titre de la page
	 *                  - $ppo->SUBTITLEPAGE = Sous titre de la page
	 * @param string    $pathTpl Adresse du template smarty
	 * @return RaptorActionReturnSmarty
	 */
	public static function arSmarty ($ppo, $pathTpl) {
		return new Raptor\ActionReturnSmarty ($ppo, $pathTpl);
	}
	
	/**
	 * Retour d'action avec telmplate smarty sans template principale
	 * @param PPO $ppo
	 * @param string    $pathTpl Adresse du template smarty
	 * @return RaptorActionReturnDirectSmarty
	 */
	public static function arDirectSmarty ($ppo, $pathTpl) {
		return new RaptorActionReturnDirectSmarty ($ppo, $pathTpl);
	}
	
	/**
	 * Retour d'action avec telmplate smarty sans template principale
	 * @return RaptorActionReturnRedirect
	 */
	public static function arRedirect ($url) {
		return new RaptorActionReturnRedirect ($url);
	}
	
	/**
	 * Retour d'action json
	 * @param PPO $ppo
	 * @return RaptorActionJSON
	 */
	public static function arJSON ($ppo) {
		return new RaptorActionReturnJSON ($ppo);
	}
	
	/**
	 * Renvoie une adresse d'une resource
	 * @param string $path
	 * @return string
	 */
	public static function resource ($path) {
		return iOClass ('RaptorResource')->get ($path);
	}
	
	/**
	 * Cherche une traduction dans la langue actuel
	 * @param string $value
	 * @param array  $params Paramètre pour remplire les %0, %1, %2... % s'écrira %%
	 */
	public static function __($value, $params = array ()) {
		return iOClass ('RaptorI18N')->get ($value, $params);
	}
	
	/**
	 * Execute une info
	 * @param mixed ...
	 */
	public static function info ($objet, $label = '') {
		iOClass ('RaptorLog')->info ($objet, $label);
	}
	
	/**
	 * Execute un log
	 * @param mixed $objet
	 * @param string $label
	 */
	public static function log ($objet, $label = '') {
		iOClass ('RaptorLog')->log ($objet, $label);
	}
	
	/**
	 * Execute un warning
	 * @param mixed $objet
	 * @param string $label
	 */
	public static function warn ($objet, $label = '') {
		iOClass ('RaptorLog')->warn ($objet, $label);
	}
	
	/**
	 * Execute une erreur
	 * @param mixed $objet
	 * @param string $label
	 */
	public static function error ($objet, $label = '') {
		iOClass ('RaptorLog')->error ($objet, $label);
	}
	
	/**
	 * Retourne l'url exacte en fonction de la destination
	 * @param string $dest Url ou raccourci pour selectionner un controleur
	 * @param array  $params
	 * @return string
	 */
	public static function url ($dest, $params = array()) {
		return iOClass ('RaptorUrl')->get ($dest, $params);
	}
	
	/**
	 * Effectue une requete
	 * @param string $sql
	 * @param array  $params
	 * @param string $dbname
	 * @return (RaptorDAORecord[] | int)
	 */
	public static function query ($sql, $params = array (), $dbname = NULL) {
		$db = RaptorDB::getConnection ($dbname);
		return $db->query ($sql, $params);
	}
	
	/**
	 * Crée une DAO et la retourne
	 * Attention les jointures se fond grace au tableau passée en 2eme apramètre 
	 * 
	 * @param string $tablename
	 * @param array  $jointures Peut être egal à array(array ('tableName2', 'condition(%0.id1 = %1.id2)'[, RaptorDAO::INNER]));
	 * @param string $connectionName Nom de la connexion
	 * @return RaptorDAO
	 */
	public static function dao ($tablename, $jointures = array (), $connectionName = NULL) {
		return Raptor\DAO::getInstance ($tablename, $jointures);
	}
	
	/**
	 * Crée une DAO Search Params et la retourne
	 * @param string $kind OR ou AND, si le groupe est régie par un OR ou AND
	 * @return RaptorDAOSearchParams
	 */
	public static function daoSP ($kind = RaptorDAO::KINDAND) {
		return new Raptor\DAOSearchParams ($kind);
	}
	
	/**
	 * Retourne le cotnext courrant
	 * @return string
	 */
	public static function currentContext () {
		return self::service('context')->getCurrent ();
	}
	
	/**
	 * Renvoie un objet stdClass spécifique pour un insert
	 * @param string $tablename
	 * @param string $connectionName Nom de la connexion
	 * @return stdClass
	 */
	public static function record ($tablename, $connectionName = NULL) {
		return Raptor\DAO::getInstance ($tablename, array (), $connectionName)->getRecord ();
	}
	
	/**
	 * Retourne la valeur d'une variable en session
	 *
	 * @param string $var          Nom de la variable
	 * @param string $namespace    Namespace dans lequel on veut lire la variable
	 * @param mixed  $defaultValue Valeur par défaut si la variable n'existe pas
	 * @return mixed
	 */
	public static function sessionGet ($var, $defaultValue = NULL, $namespace = RaptorSession::DEFAULTNAMESPACE) {
		return Raptor\Session::get ($var, $defaultValue, $namespace);
	}
	
	/**
	 * Définition d'une variable dans la session
	 *
	 * @param string $var       Nom de la variable
	 * @param mixed  $value     Valeur de la variable
	 * @param string $namespace Namespace dans lequel on veut placer la variable
	 */
	public static function sessionSet ($var, $value, $namespace = RaptorSession::DEFAULTNAMESPACE) {
		return Raptor\Session::set ($var, $value, $namespace);
	}
}
