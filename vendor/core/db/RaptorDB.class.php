<?php
/**
 * Class PHP permettant de gérer les connexions à la base de donnée
 */
abstract class RaptorDB {
	
	/**
	 * Liste des connexions
	 * @var array
	 */
	private static $_connexions = array();
	
	/**
	 * Test la validité d'une connection
	 * @param string $connectionName
	 * @return bool
	 */
	public static function testConnection ($connectionName = NULL) {
		
		if ($connectionName === NULL) {
			$config = _ioClass ('RaptorConfig');
			$connectionName = $config->defaultConnection;
		}
		
		if (isset (self::$_connexions[$connectionName])) {
			return true;
		}
		
		$config = _ioClass ('RaptorConfig');
		if (!isset ($config->arConnection [$connectionName])) {
			return false;
		}
		$params = $config->arConnection [$connectionName];
		
		switch ($params['driver']) {
			case 'pdo_mysql':
				return RaptorDB_PDOMySQL::testConnectionByInfos (
					$params['host'],
					$params['database'],
					$params['user'],
					$params['password']
				);
			default:
				return false;
		}
		
		return false;
	}
	
	/**
	 * Constructeur
	 * @param string $host
	 * @param string $database
	 * @param string $user
	 * @param string $password
	 */
	public static function testConnectionByInfos ($host, $database, $user, $password) {
		return true;
	}
	
	/**
	 * Renvoie une connection par sont nom
	 * @param string $connectionName
	 * @return RaptorDB
	 */
	public static function getConnection ($connectionName = NULL) {
		
		if ($connectionName === NULL) {
			$config = _ioClass ('RaptorConfig');
			$connectionName = $config->defaultConnection;
		}
		
		if (!isset (self::$_connexions[$connectionName])) {
			
			$config = _ioClass ('RaptorConfig');
			
			if (!isset ($config->arConnection [$connectionName])) {
				throw new RaptorDBException (__('Les paramètres de connection à la base de données n\'existe pas'));
			}
			$params = $config->arConnection [$connectionName];
			
			switch ($params['driver']) {
				
				case 'pdo_mysql':
					self::$_connexions[$connectionName] = new RaptorDB_PDOMySQL (
						$params['host'],
						$params['database'],
						$params['user'],
						$params['password']
					);
					break;
				default:
					throw new RaptorDBException (__('Le driver de base de donnée \'%0\' n\'existe pas', array ($params['driver'])));
			}
			
			
		}
		
		return self::$_connexions[$connectionName];
	}
	
	/**
	 * Constructeur
	 * @param string $host
	 * @param string $database
	 * @param string $user
	 * @param string $password
	 */
	protected function __construct ($host, $database, $user, $password) { }
	
	/**
	 * Test si on ests ur un select ou un show
	 * @param string $sql
	 */
	public function isSelect ($sql) {
		
		return (
			stripos (trim (strtoupper ($sql)), 'SELECT')   === 0 || 
			stripos (trim (strtoupper ($sql)), 'SHOW')     === 0 || 
			stripos (trim (strtoupper ($sql)), 'DESCRIBE') === 0 
		);
	}
	
	/**
	 * Effectue une requete en base
	 * @param string $sql
	 * @param array  $params
	 * @return (RaptorDAORecord[] | int)
	 */
	public function query ($sql, $params = array ()) { return NULL; }
	
	/**
	 * Retourne la liste des tables connues de la base
	 * @return array Liste des noms de table
	 */
	public function getTableList () {return array (); }
	
	/**
	 * Renvoie la liste des champs pour une table
	 * @param string $tableName Le nom de la table
	 * @return array $tableau[NomDuChamp] = {type, length, lengthVar, notnull, primary}
	 */
	public function getFieldList ($tableName) {return array (); }
	
	/**
	 * Demarre une transaction sur la connection donnée
	 */
	public function begin () {}
	
	/**
	 * Valide une transaction en cours sur la connection
	 */
	public function commit () {}
	
	/**
	 * Annule une transcation sur la connection
	 */
	public function rollback () {}
	
	/**
	 * Dernier identifiant affecté
	 * @return int
	 */
	public function lastId (){ return 1;}
	
	/**
	 * Renvoie un objet stdClass pour fabriquer des enregistrements
	 */
	public function getRecord () {
		
	}
}