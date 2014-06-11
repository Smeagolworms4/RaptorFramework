<?php

namespace Raptor\controller;

/**
 * Class abtraite des controleur
 * 
 */
abstract class ActionController {
	
	/**
	 * test si l'action exist
	 * @param string $actionName
	 * @return bool
	 */
	public function actionExist ($actionName) {
		return method_exists($this, 'process'.$actionName);
	}
	
	/**
	 * Appel si l'action
	 * @param string $actionName
	 * @return RaptorActionReturn
	 */
	public function call ($actionName) {
		return call_user_func (array ($this, 'process'.$actionName ));
	}
	
	/**
	 * Methode appelé avant l'action
	 * A SURCHARGER
	 * @param string $actionName
	 */
	public function beforeAction ($actionName) {
	}
	
	/**
	 * Methode appelé avant l'action
	 * A SURCHARGER
	 * @param string             $actionName
	 * @param RaptorActionReturn $actionReturn
	 */
	public function afterAction ($actionName, $actionReturn) {
	}
	
	/**
	 * Capture une exception du controller
	 * A SURCHARGER
	 * @param string             $actionName
	 * @param Exception          $exception
	 * @param RaptorActionReturn $actionReturn Si lexception est levé dans le beforeAction alors $actionReturn = NULL
	 * @return RaptorActionReturn
	 */
	public function catchException ($actionName, $exception, $actionReturn) {
		throw $exception;
	}
}