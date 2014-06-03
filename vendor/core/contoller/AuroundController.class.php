<?php

namespace Raptor;


/**
 * Class PHP permettant de gérer les objet returné par une action
 *
 */
class AuroundController  {
	
	/**
	 * Méthode appelé avant le controller
	 * A SURCHARGER
	 * @param string $controlerName
	 * @param string $actionName
	 */
	public function beforeController ($controlerName, $actionName) {	
	}

	/**
	 * Méthode appelé après le controller
	 * A SURCHARGER
	 * @param string $controlerName
	 * @param string $actionName
	 */
	public function afterController ($controlerName, $actionName) {
	}
	
	/**
	 * Capture une exception du controller
	 * A SURCHARGER
	 * @param string             $actionName
	 * @param Exception          $exception
	 * @param RaptorActionReturn $actionReturn Si lexception est levé dans le beforeAction alors $actionReturn = NULL
	 * @return RaptorActionReturn
	 */
	public function catchException ($controlerName, $actionName, $exception, $actionReturn) {
		throw $exception;
	}
}