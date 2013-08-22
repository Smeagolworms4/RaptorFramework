<?php
/**
 * Page par default
 **/
class InstallActionController extends RaptorActionController {
	
	/**
	 * Page d'accueil
	 * @return RaptorActionReturn 
	 */
	public function processDefault () {
		$ppo = new RaptorPPO ();
		
		$ppo->installOk = _iOClass('RaptorInstall')->install ();
		
		return _arSmarty($ppo, 'default|install/default.tpl');
	}
		
}
