<?php
/**
 * Page par default
 **/
class InstallActionController extends ActionController {
	
	public function beforeAction($actionName) {
		
		$config = _ioClass ('RaptorConfig');
		
		if (!in_array($_SERVER['REMOTE_ADDR'], $config->arInstallIp)) {
			throw new RaptorException (__('L\'ip '.$_SERVER['REMOTE_ADDR'].' n\'est pas autorisé pour l\'instalaltion'));
		}
		
		
		if ($config->MODE != Config::MODE_DEV) {
			throw new RaptorException (__('Le framework doit être en mode DEV pour l\'installation'));
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
		
		if (file_exists(Config::$WORKSPACE_CONFIG_FILE)) {
			return _arRedirect(_url ('||step3'));
		}
		
		$ppo = new PPO ();
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
		
		file_put_contents(Config::$WORKSPACE_CONFIG_FILE, $config_file);
		
		return $this->processStep3();
	}

	/**
	 * Etape 3
	 * @return RaptorActionReturn
	 */
	protected function processStep3 () {
		
 		$ppo = new PPO ();
 		$installer = new RaptorInstall ();
 		$ppo->installOk = $installer->install ();
		return _arSmarty ($ppo, 'install/step3.tpl');
	}
	
		
}
