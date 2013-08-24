<?php
/**
 * Page par default
 **/
class InstallActionController extends RaptorActionController {
	
	
	public function beforeAction($actionName) {
		if (RaptorConfig::getInstance()->MODE != RaptorConfig::MODE_DEV) {
			throw RaptorException (__('Le framework doit être en mode DEV pour l\'installation'));
		}
		if (file_exists(self::$WORKSPACE_CONFIG_FILE)) {
			throw RaptorException (__('Un fichier de configuration personnel existe déjà'));
		}
	}
	
	/**
	 * @return RaptorActionReturn 
	 */
	public function processDefault () {
		return _arRedirect(_url ('||step1'));
	}
	
	/**
	 * Etape 1
	 * @return RaptorActionReturn
	 */
	public function processStep1 () {
		$ppo = new RaptorPPO ();
		$tpl = new RaptorTpl($ppo);
		
		$ppo->configFile = "<?php\n\n".$tpl->smarty('install/config.php.tpl');
		
		return _arSmarty ($ppo, 'install/step1.tpl');
	}
	
	/**
	 * Etape 2
	 * @return RaptorActionReturn
	 */
	public function processStep2 () {
		
		exit ();
		
		$ppo = new RaptorPPO ();
		$ppo->installOk = _iOClass('RaptorInstall')->install ();
		return _arSmarty ($ppo, 'install/step2.tpl');
	}
		
}
