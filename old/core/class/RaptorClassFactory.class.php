<?php 
/**
 * Factory permettant de creer n'importe quel Objet
 */
class RaptorClassFactory {
	
	private static $_instances = array ();
	
	/**
	 * Crée une nouvelle instance de l'objet
	 * @param string $className
	 * @param mixed  ...
	 * @return mixed
	 */
	public static function get () {
		$argv = func_get_args ();
		$className = null;
		$params = array ();
		foreach ($argv as $arg) {
			if ($className === null) {
				$className = $arg;
				continue;
			}
			$params[] = $arg;
		}
		
		// Les 9 premiers switchCase sont la pour des questions de performance un eval etant lourd
		switch (count ($argv)) {
			case 1: self::$_instances[$className] = new $className (); break;
			case 2: self::$_instances[$className] = new $className ($argv[1]); break;
			case 3: self::$_instances[$className] = new $className ($argv[1], $argv[2]); break;
			case 4: self::$_instances[$className] = new $className ($argv[1], $argv[2], $argv[3]); break;
			case 5: self::$_instances[$className] = new $className ($argv[1], $argv[2], $argv[3], $argv[4]); break;
			case 6: self::$_instances[$className] = new $className ($argv[1], $argv[2], $argv[3], $argv[4], $argv[5]); break;
			case 7: self::$_instances[$className] = new $className ($argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6]); break;
			case 8: self::$_instances[$className] = new $className ($argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7]); break;
			case 9: self::$_instances[$className] = new $className ($argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8]); break;
			default:
				$script = 'self::$_instances[$className] = new $className (';
				for ($i = 1; $i < count ($argv); $i++) {
					if ($i != 1) {
						$script .= ', ';
					}
					$script .= '$argv['.$i.']';
				}
				$script .= ');';
				eval ($script);
				break;
		}
		return self::$_instances[$className];
	}
	
	/**
	 * Crée ou récupère la dernière instance de l'objet
	 * @param string $className
	 * @param mixed  ...
	 * @return mixed
	 */
	public static function iOGet () {
		$argv = func_get_args ();
		if (isset (self::$_instances[$argv[0]])) {
			return self::$_instances[$argv[0]];
		}
		return call_user_func_array('self::get', func_get_args ());
	}
}