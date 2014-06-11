<?php

namespace Raptor\dao;

/**
 * Class PHP permetant de gérer des objet connecté à la base de donnée
 * 
 */
class DAO {
	
	const INNER = 'INNER';
	const RIGHT = 'RIGHT';
	const LEFT  = 'LEFT';

	const KIND_AND  = 'AND';
	const KIND_OR   = 'OR';

	const COND_EGAL = '=';
	const COND_INF  = '<';
	const COND_SUP  = '>';
	const COND_NOT  = '!=';
	const COND_SUPE = '>=';
	const COND_INFE = '<=';
	const COND_LIKE = 'LIKE';
	
	const ORDRE_ASC  = 'ASC';
	const ORDRE_DESC = 'DESC';
	
	/**
	 * Liste des instances de DAO
	 * @var array
	 */
	private static $_instances = array();
	
	/**
	 * Nom de la connexion
	 * @var string
	 */
	protected $_connectionName = NULL;
	
	/**
	 * Nom de la table principale
	 * @var string
	 */
	protected $_tablename = '';
	
	/**
	 * Texte FROM des requetes
	 * @var string
	 */
	protected $_from = '';
	
	/**
	 * Texte JOIN des requetes
	 * @var string
	 */
	protected $_joins = '';
	
	/**
	 * Liste des champs
	 * @var array
	 */
	protected $_listeChamps = array ();
	
	/**
	 * Liste des champs des jointure
	 * @var array
	 */
	protected $_listeChampsJointure = array ();
	
	/**
	 * Alias de chaque table et jointure associé au requete de la DAO
	 * @var array
	 */
	protected $_alias = array();
	
	/**
	 * Liste des clefs primaires
	 * @var array
	 */
	protected $_primarys = array();
	
	/**
	 * Crée une DAO et la retourne
	 * Attention les jointures se fond grace au tableau passée en 2eme apramètre 
	 * 
	 * @param string $tablename
	 * @param array  $jointures      Peut être egal à array(array ('tableName2', 'condition(%0.id1 = %1.id2)'[, RaptorDAO::INNER])); %0 Etant la table principale %1 la premère jointure
	 * @param string $connectionName Nom de la connexion
	 * @return RaptorDAO
	 */
	public static function getInstance ($tablename, $jointures = array (), $connectionName = NULL) {
		
		if ($connectionName === NULL) {
			$config = _ioService ('Config');
			$connectionName = $config->defaultConnection;
		}
		
		$path = TEMP_CACHE_PATH.'dao/';
		
		// Récupère le nom de table et ses jointures
		$tablename = strtolower($tablename);
		
		$classname = 'DAO_'.$tablename.'_'.$connectionName;
		$JOIN = '';
		$joinParse = array ();
		foreach ($jointures as $jointure) {
			$jname = $jointure[0];
			$jcond = $jointure[1];
			$jsens = isset ($jointure[2]) ? $jointure[2] : RaptorDAO::INNER;
			
			$joinParse[] = array ($jname, $jsens, $jcond);
			
			$JOIN .= 'J'.$jname.'C'.$jsens.$jcond;
			
		}
		$classname .= md5 ($JOIN);
		$file = $path.$classname.'.class.php';
		
		if (!isset (self::$_instances[$classname])) {
			
			// Création du dossier cache si il manque
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			// Test si la DAO existe déjà sinon la crée
			if (!file_exists ($file)) {
				
				$ppo = new PPO ();
				$tpl = new Tpl ($ppo);
				
				
				$db = DB::getConnection ($connectionName);
				$tables = $db->getTableList ();
				
				if (!in_array($tablename, $tables)) {
					throw new DAOException (__('La table \'%0\' n\'existe pas dans la connexion \'%1\'', array ($tablename, $connectionName)));
				}
				
				$ppo->listeChamps = $db->getFieldList ($tablename);
				
				$ppo->listeChampsJointure = array();
				foreach ($joinParse as $key=>$j) {
					if (!in_array($j[0], $tables)) {
						throw new DAOException (__('La table \'%0\' n\'existe pas dans la connexion \'%1\'', array ($j[0], $connectionName)));
					}
					$ppo->listeChampsJointure['%'.($key+1)] = $db->getFieldList ($j[0]);
				}
				
				$ppo->classname = $classname;
				$ppo->tablename = $tablename;
				$ppo->joinParse = $joinParse;
				$contents = "<?php\n".$tpl->smarty ('default|dao.tpl');
				file_put_contents ($file, $contents);
				
			}
			
			require_once ($file);
			
			self::$_instances[$classname] = new $classname ($connectionName);
		}
		
		return self::$_instances[$classname];
	}
	
	/**
	 * Cherche le nom de la table en fonction de son alias
	 * @param string $alias % quelqeu chose
	 * @return string
	 */
	public function tableNameByAlias ($alias) {
		
		if (!isset ($this->_alias[$alias])) {
			return NULL;
		}
		
		return $this->_alias[$alias];
	}
	
	/**
	 * TEst si un champs exist
	 * @param string $fieldName
	 * @return bool
	 */
	public function fieldExist ($fieldName) {
		// Si aucune table n'est spécifier alors on remplace par la table principale
		if (strpos ($fieldName, '.') === false) {
			$fieldName = '%0.'.$fieldName;
		}
		
		$infos = explode ('.', $fieldName);
		
		if ($infos[0] == '%0') {
			return isset ($this->_listeChamps[$infos[1]]);
		}
		
		return isset ($this->_listeChampsJointure[$infos[0]]) &&  isset ($this->_listeChampsJointure[$infos[0]][$infos[1]]);
	}
	
	/**
	 * Parse les selecte envoyer en paramètre et génére la liste pour la requete SQL
	 * @param array $listSelect
	 * @return string
	 */
	protected function _parseSelect ($listSelect) {;
		
		if (!is_array($listSelect)) {
			$listSelect = array ($listSelect);
		}
		
		$return = '* ';
		$first = true;
		
		if ($listSelect) {
			
			$return = '';
			
			foreach ($listSelect as $key=>$value) {
				
				$name = $value;
				$as = '';
				if ( ((int)$key) !== $key) {
					$name = $key;
					$as = $value;
				}
				
				// Si aucune table n'est spécifier alors on remplace par la table principale
				if (strpos ($name, '.') === false) {
					$name = '%0.'.$name;
				}
				
				$infos = explode ('.', $name);
				
				if ($this->tableNameByAlias ($infos[0]) === NULL) {
					throw new DAOException (__('L\'alias %0 ne correspond à aucune jointure de la DAO', array ($infos[0])));
				}
				
				if (!$this->fieldExist ($name)) {
					throw new DAOException (__('Le champs \'%0\' n\'existe pas dans la table \'%1\'', array ($infos[1], $this->tableNameByAlias ($infos[0]))));
				}
				
				if (!$first) {
					$return .= ',';
				}
				$first = false;
				$name = str_replace('%', 't', $name);
				$explode = explode ('.', $name);
				$return .= $explode[0].'.`'.$explode[1].'` ';
				if ($as) {
					$return .= 'AS '.$as.' ';
				}
				
			}
		}
		return $return;
	}
	
	/**
	 * Renvoie tous les resultats de la table
	 * @param array $listSelect
	 */
	public function findAll ($listSelect = array ()) {
		
		$select = $this->_parseSelect ($listSelect);
		
		$sql = 'SELECT '.$select.$this->_from.$this->_joins;
		return _query($sql, array(), $this->_connectionName);
	}
	
	/**
	 * Renvoie les resultats de la table en fonction de la daoSP
	 * @param RaptorDAOSearchParams $daoSP
	 * @param RaptorDAORecord[] $listSelect
	 */
	public function findBy ($daoSP, $listSelect = array ()) {
		
		$select = $this->_parseSelect ($listSelect);
		
		$sql = 'SELECT '.$select.$this->_from.$this->_joins.' WHERE'.$daoSP->getWhere ();
		return _query($sql, $daoSP->getValues (), $this->_connectionName);
	}

	/**
	 * Renvoie le nombre de resultats de la table en fonction de la daoSP
	 * @param RaptorDAOSearchParams $daoSP
	 */
	public function countBy ($daoSP) {
	
		$sql = 'SELECT count(*) AS COUNTVALUES '.$this->_from.$this->_joins.' WHERE'.$daoSP->getWhere ();
		$result = _query($sql, $daoSP->getValues (), $this->_connectionName);
		return $result[0]->COUNTVALUES;
	}

	/**
	 * Supprime un élément de la table en fonction de la daoSP
	 * @param RaptorDAOSearchParams $daoSP
	 */
	public function deleteBy ($daoSP) {
	
		$sql = 'DELETE FROM '.$this->_tablename.' WHERE'.$daoSP->getWhere ();
		return _query($sql, $daoSP->getValues (), $this->_connectionName);
	}
	
	/**
	 * Récupère une ligne dans la base par ca clef primaire
	 * @param array $clefPrimaires
	 * @param array $listSelect
	 * @return stdClass
	 */
	public function get ($clefPrimaires, $listSelect = array ()) {
		
		if (!is_array($clefPrimaires)) {
			$clefPrimaires = array ($clefPrimaires);
		}
		$select = $this->_parseSelect ($listSelect);
		
		$where = 'WHERE 1 ';
		$values = array();
		
		foreach ($this->_primarys as $key => $primary) {
			$where .= 'AND t0.`'.$primary.'`=:'.$key.' ';
			if (!isset ($clefPrimaires[$key])) {
				throw new DAOException (__('Il manque des clef primaire la liste des clef demandé est la suivant \'%0\'', array (var_export($this->_primarys))));
			}
			$values[':'.$key] = $clefPrimaires[$key];
		}
		
		
		$sql = 'SELECT '.$select.$this->_from.$where;
		
		$results = _query($sql, $values, $this->_connectionName);
		if (isset ($results[0])) {
			return $results[0];
		}
		return null;
	}
	
	/**
	 * Récupère une ligne dans la base par ca clef primaire
	 * Efface une ligne dans la base par ca clef primaire
	 * @return int Nombre d'élement affecté
	 */
	public function delete ($clefPrimaires) {
	
		if (!is_array($clefPrimaires)) {
			$clefPrimaires = array ($clefPrimaires);
		}
		
		$where = ' WHERE 1 ';
		$values = array();
	
		foreach ($this->_primarys as $key => $primary) {
			$where .= 'AND '.$primary.'=:'.$key.' ';
			if (!isset ($clefPrimaires[$key])) {
				throw new DAOException (__('Il manque des clef primaire la liste des clef demandé est la suivant \'%0\'', array (var_export($this->_primarys))));
			}
			$values[':'.$key] = $clefPrimaires[$key];
		}
		
		$sql = 'DELETE FROM '.$this->_tablename.$where;
		
		return  _query($sql, $values, $this->_connectionName);
	}
	
	/**
	 * Renvoie un objet stdClass spécifique pour un insert
	 * @return stdClass
	 */
	public function getRecord () {
		$obj = new RaptorDAORecord ();
		
		foreach ($this->_listeChamps as $field=>$value) {
			$obj->$field = NULL;
		}
		
		return $obj;
	}
	
	/**
	 * Vérifie la validité de l'enregistrement
	 * @param stdClass $record
	 */
	private function _validRecord (RaptorDAORecord $record) {
		foreach ($this->_listeChamps as $field=>$value) {
			if (
				$record->$field === NULL &&
				$value['notnull'] && 
				(
					$value['extra'] != 'auto_increment' && 
					$value['default'] === NULL && 
					strpos(strtolower ($value['extra']), 'on update') === false
				)
			) {
				throw new DAOException (__('Le champs \'%0\' de la table \'%1\' ne peut pas être NULL', array ($field, $this->_tablename)));
			}
		}
	}
	
	/**
	 * Vérifie la validité de l'enregistrement
	 * @param stdClass $record
	 * @return bool
	 */
	public function check ($record) {
		try {
			$this->_validRecord ($record);
		} catch (DAOException $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 * @param array $fieldInfos
	 * @param mixed $recorded
	 */
	private function _formatField ($fieldInfos, $recorded) {
		// adaptation de la valeur pour le timestamp
		if ($fieldInfos['type'] == 'datetime' && is_numeric ($recorded) && ((string)((int)$recorded)) === ((string)$recorded)  ) {
			$recorded = date ('Y-m-d H:i:s', $recorded);
		}
		
		return $recorded;
	}
	
	/**
	 * Insert un objet en base
	 * @param stdClass $record
	 * @return int Nombre d'élement affecté
	 */
	public function insert (RaptorDAORecord &$record) {
		
		$this->_validRecord ($record);
		
		$sql = 'INSERT INTO `'.$this->_tablename.'` (';
		$VALUE  = '';
		$values = array ();
		
		$i = 0;
		foreach ($this->_listeChamps as $field=>$fieldInfos) {
			
			$recorded = $this->_formatField($fieldInfos, $record->$field);
			
			if ($recorded === NULL && $fieldInfos['notnull'] && strpos(strtolower ($fieldInfos['extra']), 'on update') === false) {
				continue;
			}
			
			if ($i) {
				$sql .= ',';
				$VALUE .= ',';
			}
			
			$sql .= '`'.$field.'`';
			$VALUE .= ':x'.$i;
			
			$values[':x'.$i] = $recorded;
			
			$i++;
		}
		$sql .= ') VALUES ('.$VALUE.')';
		
		$result = _query($sql, $values, $this->_connectionName);
		
		// Affectation de l'autoincrment
		if ($result && count ($this->_primarys) == 1
		) {
			$fieldName = $this->_primarys[0];
			$field = $this->_listeChamps[$fieldName];
			if (strpos ($field['extra'], 'auto_increment') !== false && $record->$fieldName == NULL) {
				$record->$fieldName = DB::getConnection ($this->_connectionName)->lastId ();
			}
		}
		
		return $result;
	}
	
	/**
	 * Insert un objet en base
	 * @param stdClass $record
	 * @return int Nombre d'élement affecté
	 */
	public function update (RaptorDAORecord $record) {
		$this->_validRecord ($record);
		
		$sql = 'UPDATE `'.$this->_tablename.'` SET ';
		$values = array ();
		
		$i = 0;
		$runRequest = false;
		foreach ($this->_listeChamps as $field=>$fieldInfos) {
			
			if ($record->mustUpdate ($field)) {
				
				$runRequest = true;
				$recorded = $this->_formatField($fieldInfos, $record->$field);
				
				if ($recorded === NULL && $value['notnull'] && strpos(strtolower ($fieldInfos['extra']), 'on update') === false) {
					continue;
				}
				
				if ($i) {
					$sql .= ',';
				}
				$sql .= '`'.$field.'`=:x'.$i;
				
				$values[':x'.$i] =  $recorded;
				
				$i++;
				
			}
		}
		
		$WHERE = ' WHERE 1 ';
		
		
		foreach ($this->_primarys as $primary) {
			$WHERE.='AND `'.$primary.'`=:x'.$i.' ';
			$values[':x'.$i] = $record->$primary;
			$i++;
		}
		$sql .= $WHERE;

		return ($runRequest) ? _query($sql, $values, $this->_connectionName) : 0;
	}
	
}
