<?php

class RaptorAutoloader {

	/**
	 * Liste des fichiers de class
	 * @var array
	 */
	private static $files = array();
	
	/**
	 * Liste des fichiers de class par module
	 * @var array
	 */
	private static $filesModule = array();
	
	/**
	 * Fonction autoload du core de raptor
	 * @param string $class
	 * @param bool   $forceBuild
	 */
	public static function autoloadCore ($class, $forceBuild = false) {
		
		$file = TEMP_CACHE_PATH.'autoload/autoload.php';
		
		if (!file_exists (TEMP_CACHE_PATH.'autoload')) {
			mkdir (TEMP_CACHE_PATH.'autoload', 0777, true);
		}
		
		if (!self::$files || $forceBuild) { // Si le cache est déjà chargé
			
			if (!$forceBuild && file_exists($file)) {
				$autoload = array ();
				require_once ($file);
				self::$files = $autoload;
				
			} else {
				// Liste les sous dossiers
				$d = dir (CORE_PATH);
				$listPath = array ();
				while (false !== ($entry = $d->read())) {
					if (is_dir (CORE_PATH.$entry) && $entry != '..') {
						$listPath[] = CORE_PATH.$entry;
					}
				}
				$d->close();
				
				// Liste tous les fichiers de chaque sous dossier
				foreach ($listPath as $path) {
					$d = dir ($path);
					while (false !== ($entry = $d->read())) {
						if (!is_dir ($path.$entry) && strpos($entry, '.class.php') !== false) {
							self::$files[str_replace('.class.php', '', $entry)] = $path.'/'.$entry;
						}
					}
					$d->close();
				}
				
				// Génère le contenu fichier php de cache
				$content = '<?php $autoload = '.var_export (self::$files, true).';';
				
				// Génère les repertoire et le fichier
				if (!file_exists(TEMP_CACHE_PATH)) {
					mkdir (TEMP_CACHE_PATH, 0777, true);
				}
				file_put_contents($file, $content);
				exit ();
			}
		}
		if (isset (self::$files[$class])) {
			
			if (file_exists(self::$files[$class])) {
				include_once (self::$files[$class]);
			}
			
			return;
		}
		
	}
	
	/**
	 * Fonction autoload des modules de raptor
	 * @param string $class
	 * @param bool   $forceBuild
	 */
	public static function autoloadModule ($class, $forceBuild = false) {
		
		$context = _currentContext ();
		
		
		if ($context) {
			

			if (!isset (self::$filesModule[$context]) || $forceBuild) { // Si le cache est déjà chargé
				
				$file = TEMP_CACHE_PATH.'autoload/modules/autoload_'.$context.'.php';
				
				if (!$forceBuild && file_exists($file)) {
					$autoload = array ();
					require_once ($file);
					self::$filesModule[$context] = $autoload;
				
				} else {

					if (!file_exists (TEMP_CACHE_PATH.'autoload/modules')) {
						mkdir (TEMP_CACHE_PATH.'autoload/modules', 0777, true);
					}
					
					$classesDir = MODULES_PATH.$context.'/'.CLASSES_DIR.'/';
					
					self::$filesModule[$context] = array ();
					
					if (file_exists ($classesDir)) {
						$d = dir ($classesDir);
						while (false !== ($entry = $d->read())) {
							if (!is_dir ($classesDir.$entry) && strpos($entry, '.class.php') !== false) {
								self::$filesModule[$context][str_replace('.class.php', '', $entry)] = $classesDir.'/'.$entry;
							}
						}
						$d->close();
					}
					// Génère le contenu fichier php de cache
					$content = '<?php $autoload = '.var_export (self::$filesModule[$context], true).';';
					
					// Génère les repertoire et le fichier
					if (!file_exists(TEMP_CACHE_PATH)) {
						mkdir (TEMP_CACHE_PATH, 0777, true);
					}
					file_put_contents($file, $content);
				}
			}
		}
		if (isset (self::$filesModule[$context]) && isset (self::$filesModule[$context][$class])) {
				
			if (file_exists(sself::$filesModule[$context][$class])) {
				include_once (self::$filesModule[$context][$class]);
			}
				
			return;
		}
	}
}

spl_autoload_register(array ('RaptorAutoloader', 'autoloadCore'));
spl_autoload_register(array ('RaptorAutoloader', 'autoloadModule'));