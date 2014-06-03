<?php

namespace Raptor;

/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class ActionReturnDirectSmarty extends RaptorActionReturn {
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		$pathTpl = $this->_getParam ();
		$ppo     = $this->_getPPO ();
		$tpl     = new Tpl ($ppo);
		return $tpl->smarty($pathTpl);
	}
	
}