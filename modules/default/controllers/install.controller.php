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
		var_dump ('fff');
		return _arDirectSmarty ($ppo, 'default|install/default.tpl');
	}
		
}
