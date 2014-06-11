<?php

namespace Raptor\cache;

trait TraitCachedClass {
	
	public static function __set_state ($values) {
		
		$obj = new self();
		foreach ($values as $key=>$value) {
			$obj->$key = $value;
		}
		return $obj;
	}
}