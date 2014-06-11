<?php

namespace Raptor\common;
use Raptor\shortcut\RaptorShortcut as R;
use Raptor\io\Directory;

class Autoloader {
	
	public static $libsPath = array (
		"../",
		"annotations/lib/",
		"lexer/lib/",
	);
	
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
	public static function autoloadRaptor ($class, $forceBuild = false) {
		
		var_dump("class : ".$class);
		
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
				
				require_once RAPTOR_PATH.'io/Directory.php';
				$paths = Directory::glob_recursive(RAPTOR_PATH."*.php");
				
				foreach ($paths as $path) {
					if (!is_dir ($path)) {
						self::$files["Raptor\\".str_replace('.php', '', str_replace("/", "\\", str_replace(RAPTOR_PATH, '', $path)))] = $path;
					}
				}
				var_dump (self::$files);
				exit ();
				
				// Génère le contenu fichier php de cache
				$content = '<?php $autoload = '.var_export (self::$files, true).';';
				
				// Génère les repertoire et le fichier
				if (!file_exists(TEMP_CACHE_PATH.'autoload')) {
					mkdir (TEMP_CACHE_PATH.'autoload', 0777, true);
				}
				file_put_contents($file, $content);
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
		
		$context = R::currentContext ();
		
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
					
					$classesDir = _ioClass ('RaptorModule')->getPath ($context).CLASSES_DIR.'/';
					
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
					if (!file_exists(TEMP_CACHE_PATH.'autoload/modules')) {
						mkdir (TEMP_CACHE_PATH.'autoload/modules', 0777, true);
					}
					file_put_contents($file, $content);
				}
			}
		}
		if (isset (self::$filesModule[$context]) && isset (self::$filesModule[$context][$class])) {
				
			if (file_exists(self::$filesModule[$context][$class])) {
				include_once (self::$filesModule[$context][$class]);
			}
				
			return;
		}
	}
	
	/**
	 * Fonction autoload des libs
	 * @param string $class
	 * @param bool   $forceBuild
	 */
	public static function autoloadLibs ($class, $forceBuild = false) {
		
		require_once __DIR__.'/Path.php';
		
		foreach (self::$libsPath as $path) {
			
			$filename = Path::LIBS_PATH.$path."/".str_replace ("\\", "/", $class.".php");
			
// 			var_dump($filename);
			
			if (file_exists($filename)) {
// 				var_dump("find");
				require_once ($filename);
				break;
			}	
		}
		
	}
	
}

// spl_autoload_register(array ('Raptor\\common\\Autoloader', 'autoloadRaptor'));
spl_autoload_register(array ('Raptor\\common\\Autoloader', 'autoloadLibs'));
// spl_autoload_register(array ('Raptor\\common\\Autoloader', 'autoloadModule'));
