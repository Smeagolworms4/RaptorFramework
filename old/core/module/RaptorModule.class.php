<?php
/**
 * Class le module courrant
 *
 */
class RaptorModule {
	
	/**
	 * Extraie le module d'une chaine
	 * @param string $str
	 * @throws RaptorDBException
	 * @return array()
	 */
	public function extractModuleInString ($str) {
		
		$module = NULL;
		$explode = explode ('|', $str);
		if (isset ($explode[1])) {
			$module = $explode[0];
			$str = $explode[1];
		}
		if (!$module) {
			$module = _currentContext ();
			if (!$module) {
				throw new RaptorException (__('Il n\'y a aucun context courrant. Aucun module chargé.'));
			}
		}
		
		
		return array ($module, $str);
	}
	
	public function getList () {
		
	}
	
}