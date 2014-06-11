<?php

namespace Raptor\cache;

use Doctrine\Common\Annotations\AnnotationReader;

class CacheLoader {
	
	/**
	 * @var string
	 */
	private static $_cachePath = NULL;
	
	/**
	 * @var array
	 */
	private static $_propertiesClass = NULL;
	
	/**
	 * @var boolean
	 */
	private static $_propertiesClassHasChange = false;
	
	/**
	 * @var string
	 */
	private $_className;
	
	/**
	 * @var string
	 */
	private $_key;
	
	/**
	 * @var Object
	 */
	private $_instance;
	
	/**
	 * @param Kernel $kernel
	 */
	public static function init () {
		if (self::$_propertiesClass === NULL) {
			self::$_cachePath = TEMP_CACHE_PATH;
			if (!file_exists(self::$_cachePath)) {
				mkdir(self::$_cachePath, 0777, true);
			}
			self::$_propertiesClass = self::read(__FILE__, array());
		}
	}
		
	/**
	 * Renvoie la liste de propiété d'un class
	 * 
	 * @return multitype:
	 */
	private function _getCachedProperties () {
		
		$list = array ();
		
		if (!isset (self::$_propertiesClass[$this->_getClassName()])) {
			
			$reflectionClass = new \ReflectionClass($this->_getClassName());
			
			foreach ($reflectionClass->getProperties() as $property) {
				
				if ($property->isStatic() == $this->_isStatic()) {
					$reader = new AnnotationReader();
					$aCache = $reader->getPropertyAnnotation($property, __NAMESPACE__."\\annotation\\Cache");
					if ($aCache) {
						$list[] = $property->getName();
					}
				}
			}
			
			self::$_propertiesClass[$this->_getClassName()] = $list;
			self::$_propertiesClassHasChange = true;
		}
		
		return self::$_propertiesClass[$this->_getClassName()];
	}
	
	/**
	 * Ecrit un fichier de cache
	 * @param string $file
	 * @param mixed $datas
	 * @throws \Exception
	 */
	private static function write ($file, $datas) {
		if (self::$_cachePath) {
			
			$fileCache = self::$_cachePath.md5($file).".php";
			if (file_exists(self::$_cachePath) && is_dir(self::$_cachePath)) {
				@file_put_contents($fileCache, '<?php '."\n".'$datas = '.var_export($datas, true).";\n");
			}
		} else {
			throw new \Exception("Can't write cache, ".__CLASS__." isn't init.");
		}
	}
	
	/**
	 * Ecrit un fichier de cache
	 * @param string $file
	 * @param mixed $default
	 * @throws \Exception
	 * @return mixed
	 */
	private static function read ($file, $default = NULL) {
		if (self::$_cachePath) {
			
			$fileCache = self::$_cachePath.md5($file).".php";
			$datas = NULL;
			if (file_exists($fileCache)) {
				require_once $fileCache;
			}
			
			return ($datas) ? $datas : $default;
			
		}
		
		throw new \Exception("Can't read cache, ".__CLASS__." isn't init.");
		
	}
	
	/**
	 * Constructeur
	 *
	 * @param string $className  Le paramettre $className doit être __CLASS__
	 * @param Object $instance   Le paramettre $instance doit être $this ou nien ne aps être précisé pour les statics
	 * @param string $key        Clef d'enregistrement du fichier cache
	 */
	public function __construct ($instance = NULL, $key = '') {
		
		self::init();
		
		$traces = debug_backtrace();
		$this->_className = $traces[1]['class'];
		$this->_instance  = $instance;
		$this->_key       = $key;
		$this->load();
	}
	
	/**
	 * Destructeur
	 */
	public function __destruct() {
		if (self::$_propertiesClassHasChange) {
			self::$_propertiesClassHasChange = false;
			self::write (__FILE__, self::$_propertiesClass);
		}
	}

	/**
	 * @return string
	 */
	protected function _getClassName () {
		return $this->_className;
	}
	
	/**
	 * @return string
	 */
	protected function _getInstance () {
		return $this->_instance;
	}
	
	/**
	 * @return boolean
	 */
	protected function _isStatic () {
		return !$this->_instance;
	}
	
	/**
	 * Clef pour l'enregistrement de fichier 
	 * @return string
	 */
	private function _getFileKey () {
		return $this->_getClassName ().'|'.$this->_key.($this->_isStatic () ? "|Static" : "");
	}
	
	public function save () {
		$datas = array ();
		foreach ($this->_getCachedProperties () as $property) {
			
			$reflectionP = new \ReflectionProperty($this->_getClassName(), $property);
			// Change la visibilité
			$reflectionP->setAccessible(true);
			
			if ($this->_isStatic()) {
				$datas[$property] = $reflectionP->getValue();
			} else {
				$datas[$property] = $reflectionP->getValue($this->_getInstance());
			}
		}
		self::write($this->_getFileKey (), $datas);
	}
	
	public function load () {
		$datas = self::read($this->_getFileKey ());
		if ($datas) {
			foreach ($this->_getCachedProperties () as $property) {
				
				$reflectionP = new \ReflectionProperty($this->_getClassName(), $property);
				// Change la visibilité
				$reflectionP->setAccessible(true);
				
				if ($this->_isStatic()) {
					$reflectionP->setValue($datas[$property]);
				} else {
					$reflectionP->setValue($this->_getInstance(), $datas[$property]);
				}
			}
		}
	}
}
