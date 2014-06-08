<?php

/**
 * Picross
 **/
class DefaultActionController extends ActionController {
	
	
	/**
	 * Methode appelé avant l'action
	 * A SURCHARGER
	 * @param string $actionName
	 */
	public function beforeAction ($actionName) {
		
		//Changement du theme
		$config = Config::getInstance();
		$config->theme = 'picross';
		
		RaptorHTMLHeader::addJSLink  ('device|js/Device.js');
		RaptorHTMLHeader::addJSLink  ('device|js/Display.js');
		
 		RaptorHTMLHeader::addCSSLink ('picross|css/style.css.php');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/Picross.js');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/MetaGrille.js');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/Grille.js');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/Ligne.js');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/Cellule.js');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/Panel.js');
		RaptorHTMLHeader::addJSLink  ('picross|js/Picross/Apercu.js');
	}
	
	/**
	 * Page initial du jeu
	 * @return RaptorActionReturn
	 */
	public function processDefault () {
		
		$ppo = new RaptorPPO ();
		
		$ppo->images = array();
		$mydir = _ioClass ('RaptorContext')->currentModulePath ().WWW_DIR.'/datas/';
		$i = 0;
		if ($dir = @opendir($mydir))  {
			while (($file = readdir($dir)) !== false) {
				if(strpos($file, '.json') !== false) {
					$ppo->images[] = substr ($file, 0, strlen($file) - 5);
				}
			}
			closedir($dir);
		}
		sort ($ppo->images);
		
		return _arSmarty ($ppo, 'default/list.tpl');
	}
	
	/**
	 * Jeux choisi
	 * @return RaptorActionReturn
	 */
	public function processGrille () {
		$ppo = new RaptorPPO ();
		return _arSmarty ($ppo, 'default/grille.tpl');
	}
	
	
}