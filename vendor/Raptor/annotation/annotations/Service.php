<?php

namespace Raptor\annotation\annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Service {
	
	public $name;
	
	public function __construct ($params) {
		$this->name = $params["value"];
	}
}
