<?php
/**
 * Class le module courrant
 *
 */
class RaptorModule {
	
	private $_moduleList = array ();
	
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
	
	/**
	 * Liste tous les modules
	 */
	public function getList ($forceBuild = false) {
		
		if (empty ($this->moduleList) || $forceBuild) { // Si le cache est déjà chargé
			
			$file = TEMP_CACHE_PATH.'modules.php';
			
			if (!$forceBuild && file_exists($file)) {
			
				$modules = array ();
				require_once ($file);
				$this->moduleList = $modules;
				
			} else {
				
				$d = dir (MODULES_PATH);
				while (false !== ($entry = $d->read())) {
					if (is_dir (MODULES_PATH.$entry) && substr ($entry, 0 ,1) != '.') {
						$this->moduleList[$entry] = MODULES_PATH.$entry.'/';
					}
				}
				$d->close();
				
				$d = dir (WORKSPACE_MODULES_PATH);
				while (false !== ($entry = $d->read())) {
					if (is_dir (WORKSPACE_MODULES_PATH.$entry) && substr ($entry, 0 ,1) != '.') {
						$this->moduleList[$entry] = WORKSPACE_MODULES_PATH.$entry.'/';
					}
				}
				$d->close();
				
				$content = '<?php $modules = '.var_export ($this->moduleList, true).';';
				if (!file_exists(TEMP_CACHE_PATH)) {
					mkdir (TEMP_CACHE_PATH);
				}
				file_put_contents($file, $content);
			}
		}
		return $this->moduleList;
		
	}
	
	/**
	 * Test si un module exist
	 * @apram string $moduleName
	 */
	public function exist ($moduleName) {
		$list = $this->getList ();
		return isset ($list[$moduleName]) ;
	}
	
	/**
	 * Renvoie le path d'un module
	 * @apram string $moduleName
	 */
	public function getPath ($moduleName) {
		$list = $this->getList ();
		return isset ($list[$moduleName]) ? $list[$moduleName] : NULL;
	}
}
