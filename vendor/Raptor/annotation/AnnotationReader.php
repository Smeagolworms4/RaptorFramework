<?php

namespace Raptor\annotation;

use Doctrine\Common\Annotations\AnnotationReader as AnnotationReaderBase;
use Doctrine\Common\Annotations\AnnotationRegistry;

class AnnotationReader extends AnnotationReaderBase {
	
	private static $_isInit = false;
	
	private static function _init () {
		if (!self::$_isInit) {
			self::$_isInit = true;
			
			// Load des modules
			
			AnnotationRegistry::registerAutoloadNamespace("Raptor", array (
				VENDOR_PATH
			));
		}
	}
	
	
	/**
	 * Contructeur
	 */
	public function __construct () {
		self::_init();
		parent::__construct ();
	}
}
