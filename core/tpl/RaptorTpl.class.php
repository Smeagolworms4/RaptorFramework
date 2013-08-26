<?php 
/**
 * Class gérant les template de l'application
 *
 */
class RaptorTpl {
	
	/**
	 * @var RaptorPPO
	 */
	private $_ppo;
	
	/**
	 * Constructeur
	 * @param RaptorPPO $ppo
	 */
	public function __construct (&$ppo) {
		$this->_ppo = $ppo;
	}
	
	/**
	 * Renvoie le rendu d'un template smarty
	 * @param string $pathTpl
	 * @return string
	 */
	public function smarty ($pathTpl) {
		
		require_once (LIBS_PATH.'Smarty/Smarty.class.php');
		
		$smarty = new Smarty();
		
		$compilePath = TEMP_SMARTY_PATH.'compile/';
		$cachePath   = TEMP_SMARTY_PATH.'cache/';
		$configPath  = TEMP_SMARTY_PATH.'config/';
		
		
		if (!file_exists($compilePath)) { mkdir ($compilePath, 0777, true); }
		if (!file_exists($cachePath  )) { mkdir ($cachePath  , 0777, true); }
		if (!file_exists($configPath )) { mkdir ($configPath , 0777, true); }
		
		$path = _ioClass ('RaptorModule')->extractModuleInString($pathTpl);
		$module = $path[0];
		$pathTpl = $path[1];
		
		$dir = $this->getTemplatePath ($module, $pathTpl);
		
		$smarty->setTemplateDir ($dir);
		$smarty->setCompileDir($compilePath);
		$smarty->setConfigDir($cachePath);
		$smarty->setCacheDir($configPath);
		$smarty->setPluginsDir (array (
			LIBS_PATH.'Smarty/plugins',
			SMARTY_PLUGINS_PATH
		));
		
		$smarty->assign('ppo', $this->_ppo);
		
		return $smarty->fetch ($pathTpl);
	}
	
	/**
	 * Covertit la variable PPO en JSON et renvoie le resultat
	 */
	public function json () {
		return json_encode ($this->_ppo);
	}
	
	/**
	 * Renvoie le path du fichier tpl
	 * @param string $module
	 * @param string $fileTpl
	 * @return string
	 */
	public function getTemplatePath ($module, $fileTpl) {
		$path = MODULES_PATH.$module.'/'.TEMPPLATE_DIR.'/';
		$config = _ioClass ('RaptorConfig');
		
		if ($config->theme) {
			$themePath = THEMES_PATH.$config->theme.'/modules/'.$module.'/'.TEMPPLATE_DIR.'/';
			if (file_exists ($themePath.$fileTpl)) {
				$path = $themePath;
			}
		}
		
		if (!file_exists ($path.$fileTpl)) {
			throw new RaptorException (__ ('le template \'%0\'est introuvable.', $path.$fileTpl));
		}
		
		return $path;
	}
	
}