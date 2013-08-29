<?php
/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class RaptorActionReturnDirectSmarty extends RaptorActionReturn {
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		$pathTpl = $this->_getParam ();
		$ppo     = $this->_getPPO ();
		$tpl     = new RaptorTpl ($ppo);
		return $tpl->smarty($pathTpl);
	}
	
}