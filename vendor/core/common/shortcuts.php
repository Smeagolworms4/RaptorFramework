<?php

/**
 * RaptorRequest::get
 * @param string $name
 * @param mixed  $defaultValue
 * @return mixed
 */
function _request ($name, $defaultValue = NULL) {
	return RaptorRequest::get ($name, $defaultValue); 
}

/**
 * Crée une nouvelle instance de l'objet
 * @param string $className
 * @param mixed  ...
 * @return mixed
 */
function _class () {
	return call_user_func_array('RaptorClassFactory::get', func_get_args ());
}

/**
 * Crée our écupère la dernière instance de l'objet
 * @param string $className
 * @param mixed  ...
 * @return mixed
 */
function _iOClass () {
	return call_user_func_array('RaptorClassFactory::iOGet', func_get_args ());
}

/**
 * Retour d'action vide
 * @return RaptorActionReturnNone
 */
function _arNone () {
	return new RaptorActionReturnNone ();
}

/**
 * Retour d'action avec telmplate smarty et template principale de la page
 * @param RaptorPPO $ppo
 *                  - $ppo->MAIN_TEMPLATE  = Adresse du template principal
 *                  - $ppo->TITLE_PAGE     = Titre de la page
 *                  - $ppo->SUB_TITLE_PAGE = Sous titre de la page
 * @param string    $pathTpl Adresse du template smarty
 * @return RaptorActionReturnSmarty
 */
function _arSmarty ($ppo, $pathTpl) {
	return new RaptorActionReturnSmarty ($ppo, $pathTpl);
}

/**
 * Retour d'action avec telmplate smarty sans template principale
 * @param RaptorPPO $ppo
 * @param string    $pathTpl Adresse du template smarty
 * @return RaptorActionReturnDirectSmarty
 */
function _arDirectSmarty ($ppo, $pathTpl) {
	return new RaptorActionReturnDirectSmarty ($ppo, $pathTpl);
}

/**
 * Retour d'action avec telmplate smarty sans template principale
 * @return RaptorActionReturnRedirect
 */
function _arRedirect ($url) {
	return new RaptorActionReturnRedirect ($url);
}

/**
 * Retour d'action json
 * @param RaptorPPO $ppo
 * @return RaptorActionJSON
 */
function _arJSON ($ppo) {
	return new RaptorActionReturnJSON ($ppo);
}

/**
 * Renvoie une adresse d'une resource
 * @param string $path
 * @return string
 */
function _resource ($path) {
	return _iOClass ('RaptorResource')->get ($path);
}

/**
 * Cherche une traduction dans la langue actuel
 * @param string $value
 * @param array  $params Paramètre pour remplire les %0, %1, %2... % s'écrira %%
 */
function __($value, $params = array ()) {
	return _iOClass ('RaptorI18N')->get ($value, $params);
}

/**
 * Execute une info
 * @param mixed ...
 */
function _info ($objet, $label = '') {
	_iOClass ('RaptorLog')->info ($objet, $label);
}

/**
 * Execute un log
 * @param mixed $objet
 * @param string $label
 */
function _log ($objet, $label = '') {
	_iOClass ('RaptorLog')->log ($objet, $label);
}

/**
 * Execute un warning
 * @param mixed $objet
 * @param string $label
 */
function _warn ($objet, $label = '') {
	_iOClass ('RaptorLog')->warn ($objet, $label);
}

/**
 * Execute une erreur
 * @param mixed $objet
 * @param string $label
 */
function _error ($objet, $label = '') {
	_iOClass ('RaptorLog')->error ($objet, $label);
}

/**
 * Retourne l'url exacte en fonction de la destination
 * @param string $dest Url ou raccourci pour selectionner un controleur
 * @param array  $params
 * @return string
 */
function _url ($dest, $params = array()) {
	return _iOClass ('RaptorUrl')->get ($dest, $params);
}

/**
 * Effectue une requete
 * @param string $sql
 * @param array  $params
 * @param string $dbname
 * @return (RaptorDAORecord[] | int)
 */
function _query ($sql, $params = array (), $dbname = NULL) {
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
function _dao ($tablename, $jointures = array (), $connectionName = NULL) {
	return RaptorDAO::getInstance ($tablename, $jointures);
}

/**
 * Crée une DAO Search Params et la retourne
 * @param string $kind OR ou AND, si le groupe est régie par un OR ou AND
 * @return RaptorDAOSearchParams
 */
function _daoSP ($kind = RaptorDAO::KIND_AND) {
	return new RaptorDAOSearchParams ($kind);
}

/**
 * Retourne le cotnext courrant
 * @return string
 */
function _currentContext () {
	return _ioClass('RaptorContext')->getCurrent ();
}

/**
 * Renvoie un objet stdClass spécifique pour un insert
 * @param string $tablename
 * @param string $connectionName Nom de la connexion
 * @return stdClass
 */
function _record ($tablename, $connectionName = NULL) {
	return RaptorDAO::getInstance ($tablename, array (), $connectionName)->getRecord ();
}

/**
 * Retourne la valeur d'une variable en session
 *
 * @param string $var          Nom de la variable
 * @param string $namespace    Namespace dans lequel on veut lire la variable
 * @param mixed  $defaultValue Valeur par défaut si la variable n'existe pas
 * @return mixed
 */
function _sessionGet ($var, $defaultValue = NULL, $namespace = RaptorSession::DEFAULT_NAMESPACE) {
	return RaptorSession::get ($var, $defaultValue, $namespace);
}

/**
 * Définition d'une variable dans la session
 *
 * @param string $var       Nom de la variable
 * @param mixed  $value     Valeur de la variable
 * @param string $namespace Namespace dans lequel on veut placer la variable
 */
function _sessionSet ($var, $value, $namespace = RaptorSession::DEFAULT_NAMESPACE) {
	return RaptorSession::set ($var, $value, $namespace);
}
