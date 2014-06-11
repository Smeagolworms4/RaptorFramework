<?php
/**
 * Class PHP permettant de récupéré une adresse de resource
 * 
 */
class RaptorResource {
	
	/**
	 * Renvoie l'adresse d'une resource
	 * @param string $path
	 * @return string
	 */
	public function get ($path) {
		
		$racine = _iOClass ('RaptorUrl')->getRacineUrl ();
		
		if (strpos ($path, '|') === false) {
			return $racine.$path;
		} else {
			return $racine.'resource.php/'.$path;
		}
		
	}
	
	/**
	 * Affiche le contenu cible dans www 
	 */
	public function process ($path) {
		
		$explode = explode ('resource.php/', $_SERVER['REQUEST_URI']);
		if (isset ($explode[1])) {
			$path = $explode[1];
			
			$content = '';
			try {
				$path = urldecode ($path);
				$path = _ioClass ('RaptorModule')->extractModuleInString($path);
				$module = $path[0];
				$src = $path[1];
				
				$racine = realpath (MODULES_PATH.$module.'/'.WWW_DIR);
				$src = realpath ($racine.'/'.$src);
				
				if (file_exists ($src) && strpos ($src, $racine) !== false) {
					$mimeType = mime_content_type ($src);
					
					header('Content-type: '.$mimeType);
					echo file_get_contents ($src);
				}
				
			} catch (Exception $e) {
			}
		}
		echo $content;
	}
	
}