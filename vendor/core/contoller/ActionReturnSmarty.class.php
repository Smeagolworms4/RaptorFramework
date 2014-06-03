<?php

namespace Raptor;

/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class ActionReturnSmarty extends RaptorActionReturn {
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		
		$config  = _ioClass ('Config');
		$ppoMAIN = new PPO ();
		$tplMAIN = new Tpl ($ppoMAIN);
		
		$pathTpl       = $this->_getParam ();
		$ppo           = $this->_getPPO ();
		$tpl           = new Tpl ($ppo);
		
		$ppoMAIN->TITLE_PAGE     = (isset ($ppo->TITLE_PAGE)     ? $ppo->TITLE_PAGE     : $config->titlePage);
		$ppoMAIN->SUB_TITLE_PAGE = (isset ($ppo->SUB_TITLE_PAGE) ? $ppo->SUB_TITLE_PAGE : '');
		
		$ppoMAIN->MAIN = $tpl->smarty($pathTpl);
		$ppoMAIN->HEAD = _ioClass ('RaptorHTMLHeader')->getHTMLHead ();
		
		$pathTplMain = (isset ($ppo->MAIN_TEMPLATE) ? $ppo->MAIN_TEMPLATE : 'default|main.tpl');
		
		return $tplMAIN->smarty($pathTplMain);
	}
	
}