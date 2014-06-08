<?php

/**
 * Picross
 **/
class AuroundController extends RaptorAuroundController {
	
	/**
	 * Méthode appelé avant le controller
	 * @param string $controlerName
	 * @param string $actionName
	 */
	public function beforeController ($controlerName, $actionName) {
		
		RaptorPPO::addInitVars ('TITLE_PAGE', 'Picross');
		
	}
	
	
}