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
		
		
		$step  = _request ('step', 1);
		
		switch ($setp) {
			
			case 1:
				$ppo = new RaptorPPO ();
				return _arDirectSmarty ($ppo, 'install/step1.tpl');
			
			case 2:
				$ppo = new RaptorPPO ();
				$ppo->installOk = _iOClass('RaptorInstall')->install ();
				return _arDirectSmarty ($ppo, 'install/step2.tpl');
			
		}
	}
		
}
