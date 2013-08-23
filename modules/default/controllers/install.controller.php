<?php
/**
 * Page par default
 **/
class InstallActionController extends RaptorActionController {
	
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
		return _arDirectSmarty ($ppo, 'install/step1.tpl');
	}
	
	/**
	 * Etape 2
	 * @return RaptorActionReturn
	 */
	public function processStep2 () {
		$ppo = new RaptorPPO ();
		$ppo->installOk = _iOClass('RaptorInstall')->install ();
		return _arDirectSmarty ($ppo, 'install/step2.tpl');
	}
		
}
