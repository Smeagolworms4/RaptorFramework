<?php
/**
 * Class permettant de faire l'install du framework
 */
class RaptorInstall {
	
	/**
	 * Lance l'install l'installation
	 * @return bool Installation réussie
	 */
	public function install () {
		$return = true;
		
		if (!$this->_installHtaccess ()) { $return = false; }
		if (!$this->_installDB ())       { $return = false; }
		
		return $return;
	}
	
	/**
	 * Install le fichier .htaccess
	 * @return bool Installation réussie
	 */
	private function _installHtaccess() {
		$ppo = new PPO ();
		$tpl = new RaptorTpl ($ppo);
		$ppo->rootUrl = _iOClass ('RaptorUrl')->getRacineUrl ();
		
		$htContent = $tpl->smarty ('default|install/htaccess.tpl');
		
		file_put_contents (WWW_PATH.'.htaccess', $htContent);

		return true;
	}
	
	
	/**
	 * Install la base de données
	 * @return bool Installation réussie
	 */
	private function _installDB() {
		
		$config = _ioClass ('RaptorConfig');
		$ppo    = new PPO ();
		$tpl    = new RaptorTpl ($ppo);
		$ppo->prefixe = $config->dataTablePrefixe;
		
		$sqlScript = $tpl->smarty ('install/sql.tpl');
		
		_query ($sqlScript);
		
		function deleteItem ($path) {
		
			if (is_dir ($path)) {
				foreach (scandir($path) as $item) {
					if ($item == '.' || $item == '..') {
						continue;
					}
					deleteItem ($path.'/'.$item);
				}
				rmdir($path);
			} else {
				unlink($path);
			}
		}
		
		$d = dir (TEMP_PATH);
		$listPath = array ();
		while (false !== ($entry = $d->read())) {
			if ($entry != '..' && $entry != '.') {
				deleteItem (TEMP_PATH.$entry);
			}
		}
		$d->close();
		
		return true;
	}
	
	
	
}

