<?php
/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class RaptorActionReturnJSON extends RaptorActionReturn {
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		$ppo     = $this->_getPPO ();
		$tpl     = new RaptorTpl ($ppo);
		return $tpl->json ();
	}
	
}