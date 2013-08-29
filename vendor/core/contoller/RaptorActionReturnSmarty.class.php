<?php
/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class RaptorActionReturnSmarty extends RaptorActionReturn {
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		
		$config  = _ioClass ('RaptorConfig');
		$ppoMAIN = new RaptorPPO ();
		$tplMAIN = new RaptorTpl ($ppoMAIN);
		
		$pathTpl       = $this->_getParam ();
		$ppo           = $this->_getPPO ();
		$tpl           = new RaptorTpl ($ppo);
		
		$ppoMAIN->TITLE_PAGE     = (isset ($ppo->TITLE_PAGE)     ? $ppo->TITLE_PAGE     : $config->titlePage);
		$ppoMAIN->SUB_TITLE_PAGE = (isset ($ppo->SUB_TITLE_PAGE) ? $ppo->SUB_TITLE_PAGE : '');
		
		$ppoMAIN->MAIN = $tpl->smarty($pathTpl);
		$ppoMAIN->HEAD = _ioClass ('RaptorHTMLHeader')->getHTMLHead ();
		
		$pathTplMain = (isset ($ppo->MAIN_TEMPLATE) ? $ppo->MAIN_TEMPLATE : 'default|main.tpl');
		
		return $tplMAIN->smarty($pathTplMain);
	}
	
}