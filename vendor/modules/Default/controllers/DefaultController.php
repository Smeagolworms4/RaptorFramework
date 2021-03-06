<?php
namespace modules\Default\controllers;

use Raptor\controller\ActionController;

/**
 * Page par default
 **/
class DefaultController extends ActionController{
	
	/**
	 * Page initial du framework
	 * @return RaptorActionReturn
	 */
	protected function processDefault () {
		$config = _ioClass ('RaptorConfig');
		return _arRedirect(_url ($config->homePage));
	}
	
	
	/**
	 * Page d'accueil
	 * @return RaptorActionReturn
	 */
	protected function processWelcome () {
		$ppo = new PPO ();
		return _arSmarty($ppo, 'default|default/welcome.tpl');
	}
	
	/**
	 * Page 404
	 * @return RaptorActionReturn
	 */
	protected function process404 () {
	
		header("HTTP/1.0 404 Not Found");
	
		$ppo = new PPO ();
		return _arSmarty($ppo, 'default|default/404.tpl');
	}
	
	/**
	 * Renvoie le contenu des fichiers ressource concaténés
	 */
	protected function processConcat () {
		$ppo = new PPO ();
	
		if (_request('t', 'css') == 'css') {
			header('Content-type: text/css');
		} else {
			header('Content-type: application/javascript');
		}
	
		$oController = _ioClass ('RaptorController');
	
		$ppo->MAIN = _ioClass ('RaptorHTMLHeader')->getConcatFile(_request('t', 'css'), _request('c', 'default'), _request('a', 'default'));
		return _arDirectSmarty ($ppo, 'default|empty.tpl');
	}
	
}

?>