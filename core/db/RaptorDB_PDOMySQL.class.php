<?php
/**
 * Class PHP permettant de gérer les connexions à la base de donnée mysql
 * Utilise le driver PDO
 */
class RaptorDB_PDOMySQL extends RaptorDB {
	
	/**
	 * Taille maximal d'un int dans mysql
	 * @var string
	 */
	const PDOMySQL_MAX_INT = 2147483647;
	
	/**
	 * L'objet PDO associé à la connexion
	 * @var PDO
	 */
	private $_pdo = null;
	
	private $_cacheListTables = NULL;
	private $_cacheListFields = array();
	
	/**
	 * Constructeur
	 * @param string $host
	 * @param string $database
	 * @param string $user
	 * @param string $password
	 */
	public function __construct ($host, $database, $user, $password) {
		try {
			
			$dsn = 'mysql:dbname='.$database.';host='.$host;
			
			$this->_pdo = new PDO ($dsn, $user, $password);
		}catch (PDOException $e){
			throw new RaptorDBException (__('Connexion à la base de donnée (host = \'%host\', database = \'%database\') impossible', array ('host'=>$host, 'database'=>$database)));
		}
	}
	
	/**
	 * Constructeur
	 * @param string $host
	 * @param string $database
	 * @param string $user
	 * @param string $password
	 */
	public static function testConnectionByInfos ($host, $database, $user, $password) {
		try {
			$dsn = 'mysql:dbname='.$database.';host='.$host;
			$pdo = new PDO ($dsn, $user, $password);
			unset ($pdo);
		}catch (PDOException $e){
			return false;
		}
		return true;
	}
	
	/**
	 * Effectue une requete en base
	 * @param string $sql
	 * @param array  $params
	 * @return mixed
	 */
	public function query ($sql, $params = array ()) {
		
		$config = RaptorConfig::getInstance ();
		$stmt = $this->_pdo->prepare($sql);
		if (!$stmt){
			throw new RaptorDBException (__('Impossible de préparer la requête [%0] - %1 - %2', array (
				$sql,
				serialize ($params),
				implode ('-', $this->_pdo->errorInfo ())
			)));
		}
		
		if (!$stmt->execute ($params)){
			$extras = array ('query_str' => $sql, 'query_params' => $params, 'query_error' => $stmt->errorInfo ());
			$error = $stmt->errorInfo ();
			throw new RaptorDBException (__('Impossible d\'exécuter la requête [%0] : %1', array (
				$sql,
				var_export ($params, true)
			)));
		}
		
		if ($config->MODE == 'DEV') {
			_log ($sql.' : '.var_export($params, true), 'query');
		}
		
		if (!$this->isSelect ($sql)) {
			return $stmt->rowCount ();
		}
		
		@$stmt->setFetchMode(PDO::FETCH_CLASS, 'StdClass');
		return $stmt->fetchAll ();
		
	}
	
	/**
	 * Retourne la liste des tables connues de la base
	 * @return array Liste des noms de table
	 */
	public function getTableList () {
		
		if ($this->_cacheListTables === NULL) {
			
			$liste   = $this->query ('SHOW TABLES');
			$this->_cacheListTables = array();
			
			$fieldName = NULL;
			
			foreach ($liste as $table) {
				if ($fieldName === NULL) {
					$fieldName = array_keys (get_object_vars ($table));
					$fieldName = $fieldName[0];
				}
				$this->_cacheListTables[] = $table->$fieldName;
			}
		}
		return $this->_cacheListTables;
	}
	
	/**
	 * Renvoie la liste des champs pour une table
	 * @param string $tableName Le nom de la table
	 * @return array $tableau[NomDuChamp] = {type, length, values, multiselect, notnull, key, default, extra}
	 */
	public function getFieldList ($tableName) {
		
		if (!isset ($this->_cacheListFields[$tableName])) {
			
			$liste = $this->query ('DESCRIBE `'.$tableName.'`');
			$results = array ();
			
			foreach ($liste as $desc) {
				$field = new stdClass ();
				$field->notnull     = ($desc->Null == 'NO');
				$field->multiselect = false;
				$field->values      = array();
				$field->key         = ($desc->Key == 'PRI') ? 'primary' : (($desc->Key == 'UNI') ? 'uniq' : '');
				$field->type        = $desc->Type;
				$field->default     = $desc->Default;
				$field->extra       = $desc->Extra;
				
				if (($pos = strpos ($desc->Type, '(')) !== false) {
					$field->type = substr ($desc->Type, 0, $pos);
					$field->length = substr ($desc->Type, $pos+1, -1);
				}
				
				switch ($field->type) {
					
					case 'int':
					case 'tinyint':
					case 'smallint':
					case 'mediumint':
					case 'bigint':
						$field->type   = 'interger';
						$field->length = (int)$field->length;
						break;
						
					case 'year':
						$field->type   = 'interger';
						$field->length = 4;
						break;
						
					case 'char':
					case 'varchar':
						$field->type   = 'string';
						$field->length = (int)$field->length;
						break;
						
					case 'text':
					case 'blob':
					case 'longblob':
						$field->type   = 'string';
						$field->length = self::PDOMySQL_MAX_INT;
						break;
						
					case 'time':
						$field->type   = 'string';
						$field->length = 6;
						break;
						
					case 'date':
					case 'datetime':
						$field->type   = 'string';
						$field->length = 14;
						break;
						
					case 'timestamp':
						$field->type   = 'interger';
						$field->length = 11;
						break;
	
					case 'float':
						$field->type   = 'float';
						$field->length = 11;
						break;
						
					case 'decimal':
					case 'double':
						$field->type   = 'float';
						$field->length = 22;
						break;
						
					case 'set':
						$field->type = 'string';
						$explode = explode (',', $field->length);
						$field->length = 0;
						$field->multiselect = true;
						foreach ($explode as $value) {
							$field->values[] = trim ($value, '\'');
							$size = strlen ($field->values[count ($field->values) - 1]);
							$field->length += $size + 1;
						}
						break;
						
					case 'enum':
						$field->type = 'string';
						$explode = explode (',', $field->length);
						$field->length = 0;
						foreach ($explode as $value) {
							$field->values[] = trim ($value, '\'');
							$size = strlen ($field->values[count ($field->values) - 1]);
							if ($field->length < $size) {
								$field->length = $size;
							}
						}
						break;
					
					default:
						throw new RaptorDBException(__('Le type \'%0\' du champs \'%1\' de la table \'%2\' n\'est pas géré', array ($field->type, $desc->Field, $tableName)));
				}
				
				
				$results[$desc->Field] = $field;
			}
			$this->_cacheListFields[$tableName] = $results;
		}
		return $this->_cacheListFields[$tableName];
	}
	
	/**
	* Demarre une transaction sur la connection donnée
	*/
	public function begin (){
		$this->_pdo->beginTransaction ();
	}
	
	/**
	 * Valide une transaction en cours sur la connection
	 */
	public function commit () {
		$this->query ("COMMIT ");
	}
	
	/**
	 * Annule une transcation sur la connection
	 */
	public function rollback () {
		$this->query ("ROLLBACK ");
	}
	
	/**
	 * Dernier identifiant affecté
	 * @return int
	 */
	public function lastId (){
		return $this->_pdo->lastInsertId ();
	}
}