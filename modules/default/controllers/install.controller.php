<?php
/**
 * Page par default
 **/
class InstallActionController extends RaptorActionController {
	
	public function beforeAction($actionName) {
		if (_ioClass ('RaptorConfig')->MODE != RaptorConfig::MODE_DEV) {
			throw RaptorException (__('Le framework doit être en mode DEV pour l\'installation'));
		}
	}
	
	/**
	 * @return RaptorActionReturn 
	 */
	protected function processDefault () {
		return _arRedirect(_url ('||step1'));
	}
	
	/**
	 * Etape 1
	 * @return RaptorActionReturn
	 */
	protected function processStep1 () {
		
		if (file_exists(RaptorConfig::$WORKSPACE_CONFIG_FILE)) {
			return _arRedirect(_url ('||step2'));
		}
		
		$ppo = new RaptorPPO ();
		$tpl = new RaptorTpl($ppo);
		
		$ppo->configFile = "<?php\n\n".$tpl->smarty('install/config.php.tpl');
		
		return _arSmarty ($ppo, 'install/step1.tpl');
	}
	
	/**
	 * Etape 2
	 * @return RaptorActionReturn
	 */
	protected function processStep2 () {
		
		exit ();
		
		$ppo = new RaptorPPO ();
		$ppo->installOk = _iOClass('RaptorInstall')->install ();
		return _arSmarty ($ppo, 'install/step2.tpl');
	}
		
}
