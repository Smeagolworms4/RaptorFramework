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
			return _arRedirect(_url ('||step3'));
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
		
		RaptorRequest::assert('config_file');
		$config_file = _request ('config_file');
		
		if (!file_exists(WORKSPACE_PATH)) {
			mkdir (WORKSPACE_PATH, 0777, true);
		}
		
		file_put_contents(RaptorConfig::$WORKSPACE_CONFIG_FILE, $config_file);
		
		return $this->processStep3();
	}

	/**
	 * Etape 3
	 * @return RaptorActionReturn
	 */
	protected function processStep3 () {
		
 		$ppo = new RaptorPPO ();
// 		$ppo->installOk = _iOClass('RaptorInstall')->install ();
		return _arSmarty ($ppo, 'install/step3.tpl');
	}
	
		
}
