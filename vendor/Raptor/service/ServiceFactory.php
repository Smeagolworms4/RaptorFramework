<?php

namespace Raptor\service;

use Raptor\cache\annotation\Cache;
use Raptor\cache\CacheLoader;
use Raptor\io\Directory;
use Raptor\annotation\AnnotationReader;
use Raptor\annotation\annotations\Service;
// use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Factory permettant de creer n'importe quel Objet
 */
class ServiceFactory {

	private static $_instances = array ();
	
	/**
	 * @var array
	 * @Cache
	 */
	private static $_services = array ();
	
	/**
	 * Renvoie la class d'un fichier PHP
	 * @param string $src
	 * @return string
	 */
	private static function _getClassName($src) {
		
		if (!preg_match('/\bnamespace\s+([^;]+);/s', $src, $match)) {
			throw new \Exception (sprintf('Namespace could not be determined for file "%s".', $filename));
		}
		$namespace = $match[1];
	
		if (!preg_match('/\bclass\s+([^\s]+)\s+(?:extends|implements|{)/s', $src, $match)) {
			throw new \Exception(sprintf('Could not extract class name from file "%s".', $filename));
		}
	
		return $namespace.'\\'.$match[1];
	}
	
	private static function _getServices () {
		
		$cache = new CacheLoader();
		
		if (!self::$_services) {
			
			$phpFiles = Directory::glob_recursive(ROOT_PATH."*.php");
			
			foreach ($phpFiles as $filename) {
				$src = file_get_contents($filename);
				if (strpos ($src, "use Raptor\\annotation\\annotations\\Service") !== false) {
					
					$className = self::_getClassName($src);
					$aService  = NULL;
					
					if (class_exists($className)) {
						$reader = new AnnotationReader();
						/* @var $aService Service */
						$aService = $reader->getClassAnnotation (new \ReflectionClass($className), "Raptor\\annotation\\annotations\\Service");
						if ($aService) {
							self::$_services[$aService->name] = $className;
						}
					}
				}
			}
			
			$cache->save();
		}
		
		return self::$_services;
	}
	
	/**
	 * Crée une nouvelle instance de l'objet
	 * @param string $service
	 * @return mixed
	 */
	public static function get ($service) {
		
		$services = self::_getServices ();
		if (!isset ($services[$service])) {
			throw new \Exception ("Service ".$service." not exist");
		}
		
		$className = $services[$service];
		self::$_instances[$service] = new $className ();
		
		return self::$_instances[$service];
	}
	
	/**
	 * Crée ou récupère la dernière instance de l'objet
	 * @param string $service
	 * @return mixed
	 */
	public static function iOGet ($service) {
		if (isset (self::$_instances[$service])) {
			return self::$_instances[$service];
		}
		return self::get ($service);
	}
}