<?php

namespace Raptor;

/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class ActionReturnJSON extends RaptorActionReturn {
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		$ppo     = $this->_getPPO ();
		$tpl     = new Tpl ($ppo);
		header('Content-type: application/json');
		return $tpl->json ();
	}
	
}