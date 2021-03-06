<?php

namespace Raptor;

/**
 * Class PHP permettant de gérer les url
 * 
 */
class Url {
	
	/**
	 * Retourne l'url exacte en fonction de la destination
	 * @param string $dest Url ou raccourci pour selectionner un controleur
	 * @param array  $params
	 * @return string
	 */
	public function get ($dest, $params = array()) {
		
		$paramsURl = '';
		$first = true;
		foreach ($params as $var=>$param) {
			if (!$first) {
				$paramsURl .= '&amp;';
			}
			$first = false;
			$paramsURl .= $var.'='.$param;
		}
		
		if (strpos ($dest, 'http://') === 0 || strpos ($dest, 'https://') === 0) {
			return $dest.(($paramsURl) ? ((srtpos ($dest, '?') !== false) ? '&' : '?').$paramsURl : '');
		}
		$explode = explode ('|', $dest);
		$nbSlash = count ($explode);
		
		$module    = (                       $explode[0]) ? $explode[0] : (($nbSlash > 0) ? _ioClass ('RaptorController')->getModule ()     : 'default');
		$contoller = (isset ($explode[1]) && $explode[1]) ? $explode[1] : (($nbSlash > 1) ? _ioClass ('RaptorController')->getController () : 'default');
		$action    = (isset ($explode[2]) && $explode[2]) ? $explode[2] : (($nbSlash > 2) ? _ioClass ('RaptorController')->getAction ()     : 'default');
		
		$file   = $this->getScriptFile ();
		$racine = $this->getRacineUrl ();
		
		if ($module === 'default' && $contoller === 'default' && $action === 'default') {
			return $racine.$file.(($paramsURl) ? '?'.$paramsURl : '');
		} else if ($contoller === 'default' && $action === 'default') {
			return $racine.$file.'/'.$module.(($paramsURl) ? '?'.$paramsURl : '');
		} else if ($action === 'default') {
			return $racine.$file.'/'.$module.'/'.$contoller.(($paramsURl) ? '?'.$paramsURl : '');
		} else {
			return $racine.$file.'/'.$module.'/'.$contoller.'/'.$action.(($paramsURl) ? '?'.$paramsURl : '');
		}
		
	}
	
	/**
	 * Renvoie la racine des URL
	 * @return string
	 */
	public function getRacineUrl () {
		$file = substr ($_SERVER['SCRIPT_NAME'], strrpos ($_SERVER['SCRIPT_NAME'], '/') + 1);
		
		$racine    = explode ($file, $_SERVER['REQUEST_URI']);
		$racine = explode ('?', $racine[0]);
		
		return  $racine[0];
		
	}
	
	/**
	 * Renvoie le nomu fichier script
	 * @return string
	 */
	public function getScriptFile () {
		$file = substr ($_SERVER['SCRIPT_NAME'], strrpos ($_SERVER['SCRIPT_NAME'], '/') + 1);
		
		if ($file == '') {
			$config = _ioClass ('RaptorConfig');
			$file = $config->defaultScript;
		}
		return $file;
	}
	
}