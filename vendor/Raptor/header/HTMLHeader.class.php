<?php 

namespace Raptor\header;


/**
 * Class permettant de gérer le header de la page actuel
 *
 */
class HTMLHeader {

	private $_jsCode = array ();
	private $_jsCodeOnLoad = array ();
	
	/**
	 * Initialise les variables request
	 */
	public function __construct () {
		$page = $this->_getCurrentPage ();
		Session::delete('CSSHTMLHeader_'.$page, 'RaptorCore');
		Session::delete('JSHTMLHeader_'.$page, 'RaptorCore');
	}
	
	/**
	 * Renvoie une chaine avec la page courrante
	 * @param string $contoller
	 * @param string $action
	 * @return string
	 */
	private function _getCurrentPage ($contoller = NULL, $action = NULL) {
		$oController = _ioClass ('RaptorController');
		return (($contoller) ? $contoller : $oController->getController ()).'_'.(($action) ? $action : $oController->getAction ());
	}
	
	public function getHTMLHead () {
		$controller = _ioClass ('RaptorController');
		$content = '
			<link href="'._url('default|default|concat', array('t'=>'css', 'c'=>$controller->getController (), 'a'=>$controller->getAction ())).'" rel="stylesheet" type="text/css" />
			<script src="'._url('default|default|concat', array('t'=>'js', 'c'=>$controller->getController (), 'a'=>$controller->getAction ())).'"  type="text/javascript"></script>
			<script type="text/javascript">
			//<!--
				window.addEvent (\'load\', function (event) {
					'.implode ("\n", $this->_jsCodeOnLoad).'
				});
				'.implode ("\n", $this->_jsCode).'
			//-->
			</script>
		';
		
		return $content;
	}
	
	/**
	 * Ajoute du code JS dans l'entête pour le onload de la page
	 * @param string $code
	 * @param bool   $uniqueInsert
	 */
	public function addJSCodeOnLoad ($code, $uniqueInsert = false) {
		if (!$uniqueInsert || !in_array($code, $this->_jsCodeOnLoad)) {
			$this->_jsCodeOnLoad[] = $code;
		}
	}
	
	/**
	 * Ajoute du code JS dans l'entête
	 * @param string $code
	 * @param bool   $uniqueInsert
	 */
	public function addJSCode ($code, $uniqueInsert = false) {
		if (!$uniqueInsert || !in_array($code, $this->_jsCode)) {
			$this->_jsCode[] = $code;
		}
	}
	
	/**
	 * Ajoute un lien vers un fichier Javascript. N'ajoutera pas deux fois un même lien
	 * @param string $src le chemin vers le javascript (tel qu'il apparaitra)
	 */
	public function addJSLink ($src) {
		
		$page = $this->_getCurrentPage ();
		if ($page == 'default_concat') {
			return;
		}
		$list = _sessionGet('JSHTMLHeader_'.$page, array (), 'RaptorCore');
		
		if (!in_array($src, $list)) {
			
			$path = _ioService ('Module')->extractModuleInString($src);
			$module = $path[0];
			$src = $path[1];
			
			$file = MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$src;
			if (!file_exists($file)) {
				$file = WORKSPACE_MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$src;
				if (!file_exists($file)) {
					throw new Exception(__('Le fichier \'%0\' est introuvable.', array($file)));
				}
			}
			$list[] = $module.'|'.$src;
		}
		_sessionSet('JSHTMLHeader_'.$page, $list, 'RaptorCore');
		
	}
	
	/**
	 * Ajoute un lien vers un fichier CSS. N'ajoutera pas deux fois le même lien
	 * @param string $src le chemin vers le fichier CSS (tel qu'il apparaitra)
	 */
	public function addCSSLink ($src) {
		
		$page = self::_getCurrentPage ();
		if ($page == 'default_concat') {
			return;
		}
		$list = _sessionGet('CSSHTMLHeader_'.$page, array (), 'RaptorCore');
		
		if (!in_array($src, $list)) {
			
			$path = _ioClass ('RaptorModule')->extractModuleInString($src);
			$module = $path[0];
			$src = $path[1];
			
			$file = MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$src;
			if (!file_exists($file)) {
				$file = WORKSPACE_MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$src;
				if (!file_exists($file)) {
					throw new Exception(__('Le fichier \'%0\' est introuvable.', array($file)));
				}
			}
			$list[] = $module.'|'.$src;
		}
		_sessionSet('CSSHTMLHeader_'.$page, $list, 'RaptorCore');
		
	}
	
	/**
	 * Renvoie le contenu de tous les fichiers concaténés
	 * @param string $type
	 * @param string $controller
	 * @param string $action
	 */
	public function getConcatFile ($type, $controller, $action) {
		
		$content = '';
		$page = self::_getCurrentPage ($controller, $action);
		$list = array ();
		if ($type == 'js') {
			_info ($this, 'Création de JS pour la page : '.$controller.'/'.$action);
			$list = _sessionGet('JSHTMLHeader_'.$page, array (), 'RaptorCore');
			Session::delete('JSHTMLHeader_'.$page, 'RaptorCore');
		} else {
			_info ($this, 'Création de CSS pour la page : '.$controller.'/'.$action);
			$list = _sessionGet('CSSHTMLHeader_'.$page, array (), 'RaptorCore');
			Session::delete('CSSHTMLHeader_'.$page, 'RaptorCore');
		}
		
		foreach ($list as $filename) {
			
			$path = _ioClass ('RaptorModule')->extractModuleInString($filename);
			$module = $path[0];
			$filename = $path[1];
			
			$file = MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$filename;
			ob_start ();
			if (!file_exists($file)) {
				throw new Exception(__('Le fichier \'%0\' est introuvable.', array($file)));
			}
			require_once ($file);
			$content .= ob_get_contents()."\n";
			ob_end_clean ();
		}
		return $content;
	}
	
}
