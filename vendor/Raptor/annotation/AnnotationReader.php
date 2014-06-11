<?php

namespace Raptor\annotation;

class AnnotationReader {
	
	private $_currentRClass = null;
	
	private function _getUseClass () {
		
		//TODO Cache static
		
		$content = file_get_contents ($this->_currentRClass ->getFileName());
		$list = array ();
		
		preg_match_all("/\n\s*use\s+[\\\\0-9a-z]+(\s+as\s+[a-z0-9]+)?\s*;/i", $content, $match);
		
		if ($match) {
			foreach ($match[0] as $str) {
				$str = preg_replace("/\s*use\s+/", "", $str);
				$str = preg_replace("/\s*;\s*/", "", $str);
				$str = explode ("as", $str);

				$class = trim ($str[0]);
				$explodeClass = explode ("\\", $class);
				$key = isset($str[1]) ? trim ($str[1]) : array_pop($explodeClass);
				
				$list[$key] = $class;
			}
		}
		
		return $list;
	}
	
	private function _getAnnotations ($classDoc) {
		
		$annotations = array ();
		
		while ($classDoc) {
			
			if ($this->_isStartAnnotation ($classDoc)) {
				$annotation = $this->_readAnnotation ($classDoc);
				if ($annotation) {
					$annotations[] = $annotation;
				}
			} else {
				$this->_readOne ($classDoc);
			}
		}
		
		return $annotations;
	}
	
	/**
	 * Lit une annotation
	 * @param unknown $classDoc
	 */
	private function _readAnnotation (&$classDoc) {
		if ($this->_readOne ($classDoc) == "@") {
			
			$className = $this->_readWord($classDoc, array ("\\"));
			if ($className) {
				$useClass = $this->_getUseClass ();
				$this->_readEmpty ($classDoc);
				
				if (isset ($useClass [$className])) {
					$className = $useClass [$className];
				}
				
				var_dump ('rrr : '.$className);
				if (class_exists($className)) {
					var_dump ('cool coolcool cool');
				} else {
					var_dump ('bad');
				}
	// 			class_exists($class);
			}
			
		}
		return NULL;
	}
	
	/**
	 * Lit un mot
	 * @param unknown $classDoc
	 */
	private function _readWord (&$classDoc, $addCar = array ()) {
		$read = "";
		
		while (
			($classDoc[0] >= "a" && $classDoc[0] <= "z") ||
			($classDoc[0] >= "A" && $classDoc[0] <= "Z") ||
			($classDoc[0] >= "0" && $classDoc[0] <= "9") ||
			in_array($classDoc[0], $addCar)
		) {
			$read .= $this->_readOne($classDoc);
		}
		
		return ($read) ? $read : NULL;
	}
	
	
	/**
	 * supprime les espaces blancs
	 * @param string $classDoc
	 * @return string
	 */
	private function _readEmpty (&$classDoc) {
		do {
			trim ($classDoc);
			$end = true;
			if ($classDoc[0] == "*") {
				$end = false;
				$classDoc = substr($classDoc, 1);
			}
		} while (!$end);
	}
	
	/**
	 * Lit un caractere
	 * @param string $classDoc
	 * @return string
	 */
	private function _readOne (&$classDoc) {
		$char = $classDoc[0];
		$this->_readEmpty ($classDoc);
		$classDoc = substr ($classDoc, 1);
		return $char;
	}
	
	/**
	 * Test si on commence une annotation
	 * @param string $classDoc
	 * @return bool
	 */
	private function _isStartAnnotation ($classDoc) {
		$result = preg_match("/@[\\a-z0-9]*/i", $classDoc, $match);
		if ($match && $match[0]) {
			return strpos($classDoc, $match[0]) === 0;
		}
		return false;
	}
	
	
	public function getClassAnnotations (\ReflectionClass $rClass) {
		
		$this->_currentRClass = $rClass;
		
		$classDoc = trim ($rClass->getDocComment());
		$annotations = $this->_getAnnotations ($classDoc);
		
		var_dump ("ANNOS", $annotations);
		
		
		
// 		$string = "(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))";
// 		$table = "({\s*})";
		
// 		$obj = "$string|$table";
		
		
// 		$classDoc = preg_replace ("/\n\s*\*\s*/", "\n", $classDoc);
		
// 		$classDoc = preg_replace ("/\s*\*\s*@/", "\n", $classDoc);
// 		preg_match_all ("/\(\s*$obj/i", $classDoc, $matches);
// 		preg_match_all ("/\(\s*\w*\"/", $classDoc, $matches);
		
		
		exit ();
		
		
	}
	
	
}
