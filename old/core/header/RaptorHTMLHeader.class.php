<?php 

/**
 * Class permettant de gérer le header de la page actuel
 *
 */
class RaptorHTMLHeader {
	
	
	/**
	 * Initialisation
	 * @var array
	 */
	private static $_isInit = false;
	
	
	/**
	 * Initialise les variables request
	 */
	private static function _initialise () {
		if (!self::$_isInit) {
			self::$_isInit = true;
			$page = self::_getCurrentPage ();
			RaptorSession::delete('CSSHTMLHeader_'.$page, 'RaptorCore');
		}
	}
	
	/**
	 * Renvoie une chaine avec la page courrante
	 * @param string $contoller
	 * @param string $action
	 * @return string
	 */
	private static function _getCurrentPage ($contoller = NULL, $action = NULL) {
		return (($contoller) ? $contoller : RaptorController::getController ()).'_'.(($action) ? $action : RaptorController::getAction ());
	}
	
	public static function getHTMLHead () {
		self::_initialise ();
		
		$content = '
			<link href="'._url('||concat', array('t'=>'css', 'c'=>RaptorController::getController (), 'a'=>RaptorController::getAction ())).'" rel="stylesheet" type="text/css" />
			<script src="'._url('||concat', array('t'=>'js', 'c'=>RaptorController::getController (), 'a'=>RaptorController::getAction ())).'"  type="text/javascript"></script>
		';
		
		return $content;
	}
	
	/**
	 * Ajoute un lien vers un fichier Javascript. N'ajoutera pas deux fois un même lien
	 * @param string $src le chemin vers le javascript (tel qu'il apparaitra)
	 */
	public static function addJSLink ($src){
		self::_initialise ();
		
		$page = self::_getCurrentPage ();
		if ($page == 'default_concat') {
			return;
		}
		$list = _sessionGet('JSHTMLHeader_'.$page, array (), 'RaptorCore');
		
		if (!in_array($src, $list)) {
			
			$path = _ioClass ('RaptorModule')->extractModuleInString($src);
			$module = $path[0];
			$src = $path[1];

			$file = MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$src;
			if (!file_exists($file)) {
				throw new RaptorException(__('Le fichier \'%0\' est introuvable.', array($file)));
			}
			$list[] = $module.'|'.$src;
		}
		_sessionSet('JSHTMLHeader_'.$page, $list, 'RaptorCore');
		
	}
	
	/**
	 * Ajoute un lien vers un fichier CSS. N'ajoutera pas deux fois le même lien
	 * @param string $src le chemin vers le fichier CSS (tel qu'il apparaitra)
	 */
	public static function addCSSLink ($src){
		self::_initialise ();
		
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
				throw new RaptorException(__('Le fichier \'%0\' est introuvable.', array($file)));
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
	public static function getConcatFile ($type, $controller, $action) {
		self::_initialise ();
		
		$content = '';
		$page = self::_getCurrentPage ($controller, $action);
		$list = array ();
		if ($type == 'js') {
			$list = _sessionGet('JSHTMLHeader_'.$page, array (), 'RaptorCore');
			RaptorSession::delete('JSHTMLHeader_'.$page, 'RaptorCore');
		} else {
			$list = _sessionGet('CSSHTMLHeader_'.$page, array (), 'RaptorCore');
			RaptorSession::delete('CSSHTMLHeader_'.$page, 'RaptorCore');
		}
		
		foreach ($list as $filename) {
			
			$path = _ioClass ('RaptorModule')->extractModuleInString($filename);
			$module = $path[0];
			$filename = $path[1];
			
			$file = MODULES_PATH.$module.'/'.DATAS_DIR.'/'.$filename;
			ob_start ();
			if (!file_exists($file)) {
				throw new RaptorException(__('Le fichier \'%0\' est introuvable.', array($file)));
			}
			require_once ($file);
			$content .= ob_get_contents()."\n";
			ob_end_clean ();
		}
		return $content;
	}
	
}
