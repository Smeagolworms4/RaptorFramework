<?php
/**
 * Paramètre de recherche sur les DAO
 */
class RaptorDAOSearchParams {
	
	private $_paramRoot = null;
	private $_pile      = array();
	private $_target    = 0;
	private $_kind      = NULL;
	private $_values    = array();
	private $_orders    = array();
	private $_groupby   = array();
	
	/**
	 * Constructer
	 *
	 * @param string $kind OR ou AND, si le groupe est régie par un OR ou AND
	 */
	public function __construct ($kind = RaptorDAO::KIND_AND) {
		$this->_paramRoot = new RaptorDAOSearchParamsGroup ($kind = RaptorDAO::KIND_AND, $this, true);
		$this->_pile[0]   = $this->_paramRoot;
		$this->_kind      = $kind;
	}
	
	/**
	 * Ajoute une condition
	 *
	 * @param string $field     Nom du champ de la dao sur lequel on effectue la condition (%X pour atteindre une jointure) 
	 * @param string $condition Condition à appliquer (
	 *                          	RaptorDAO:COND_EGAL, RaptorDAO:COND_SUP, RaptorDAO:COND_INF, RaptorDAO:COND_NOT, 
	 *                          	RaptorDAO:COND_SUPE, RaptorDAO:COND_INFE, RaptorDAO:COND_LIKE
	 *                          )
	 * @param mixed $value      Valeur de recherche (inutile de quotter les chaines) Peut être un tableau
	 * @param string $kind      Type de condition, AND ou OR
	 * @return RaptorDAOSearchParams
	 */
	public function addCondition ($field, $condition, $value, $kind = NULL) {
		
		if ($kind === NULL) {
			$kind = $this->_kind;
		}
		
		if (is_array($value)) {
			$this->startGroup ($kind);
			foreach ($value as $val) {
				$this->addCondition ($field, $condition, $val, RaptorDAO::KIND_OR);
			}
			$this->endGroup();
		} else {
			$this->_pile[$this->_target]->addCondition (new RaptorDAOSearchParamsCondition ($field, $condition, $value, $kind, $this));
		}
		
		return $this;
	}
	
	/**
	 * Démarre un groupe de condition
	 *
	 * @param string $kind Type de groupe que l'on souhaite démarrer, AND ou OR
	 * @return RaptorDAOSearchParams
	 */
	public function startGroup ($kind = NULL) {
		
		if ($kind === NULL) {
			$kind = $this->_kind;
		}
		
		$group = new RaptorDAOSearchParamsGroup ($kind, $this);
		$this->_pile[$this->_target]->addCondition ($group);
		$this->_target++;
		$this->_pile[$this->_target]= $group;
		return $this;
	}
	
	/**
	 * Ferme un groupe de condition
	 * @return RaptorDAOSearchParams
	 */
	public function endGroup () {
		if ($this->_target = 0) {
			$this->_target--;
		}
		return $this;
	}
	

	/**
	 * Définition des tris sur les champs
	 *     $mySearchParams->orderBy ('monChamp', 'monChamp2' => 'DESC'));
	 *     $mySearchParams->orderBy (array ('monChamp' => 'ASC'), array ('monChamp2' => 'DESC'));
	 * @param mixed ... Tableau qui contient la liste des champs par lesquels on souhaite trier
	 * @return RaptorDAOSearchParams
	 */
	public function orderBy () {
		$args = func_get_args ();
		foreach ($args as $arg) {
			if (is_array ($arg)) {
				foreach ($arg as $champ=>$ordre) {
					$ordre = strtoupper($ordre);
					switch ($ordre) {
						case RaptorDAO::ORDRE_ASC:
						case RaptorDAO::ORDRE_DESC:
							break;
						default:
							throw new RaptorDAOException(__('L\'odre ne peut être que \'DESC\' ou \'ASC\' mais \'%0\' n\'est pas supporté', array ($ordre)));
					}
					if (strpos ($champ, '.') === false) {
						$champ = '%0.'.$champ;
					}
					$champ = str_replace ('%', 't', $champ);
					$champ = explode ('.', $champ);
					$champ = $champ[0].'.`'.$champ[1].'`';
					$this->_orders[] = array ($champ=>$ordre);
				}
			} else {
				if (strpos ($arg, '.') === false) {
					$arg = '%0.'.$arg;
				}
				$arg = str_replace ('%', 't', $arg);
				$arg = explode ('.', $arg);
				$arg = $arg[0].'.`'.$arg[1].'`';
				$this->_orders[] = array ($arg=>RaptorDAO::ORDRE_ASC);
			}
		}
		return $this;
	}
	
	/**
	 * Ajoute un groupage par champs
	 * @param string ...
	 * @return RaptorDAOSearchParams
	 */
	public function groupBy () {
		$args = func_get_args ();
		foreach ($args as $arg) {
			if (strpos ($arg, '.') === false) {
				$arg = '%0.'.$arg;
			}
			$arg = str_replace ('%', 't', $arg);
			$arg = explode ('.', $arg);
			$arg = $arg[0].'.`'.$arg[1].'`';
			$this->_groupby[] = $arg;
		}
		return $this;
	}
	
	/**
	 * Renvoie la chaine WHERE d'une requete SQL
	 * @return string
	 */
	public function getWhere () {
		$this->_values = array();
		$where = $this->_pile[0]->getWhere ();
		

		if ($this->_groupby) {
			$where .= 'GROUP BY ';
			foreach ($this->_groupby as $key=>$champ) {
				if ($key) {
					$where .= ',';
				}
				$where .= $champ.' ';
			}
		}
		
		if ($this->_orders) {
			$where .= 'ORDER BY ';
			foreach ($this->_orders as $key=>$ordre) {
				if ($key) {
					$where .= ',';
				}
				foreach ($ordre as $champ=>$o) {
					$where .= $champ.' '.$o.' ';
				}
			}
		}
		return $where;
	}
	
	/**
	 * Ajoute une value pour les requete WHERE
	 * @param mixed $value
	 */
	public function addLinkValue ($value) {
		$x = ':x'.count ($this->_values);
		$this->_values[$x] = $value;
		return $x;
	}
	
	/**
	 * Renvoie les values d'une requete WHERE
	 * @return array
	 */
	public function getValues () {
		return $this->_values;
	}
	
}

/**
 * Element de condition groupe des paramètres de recherche sur les DAO
 */
abstract class RaptorDAOSearchParamsElement {
	
	/**
	 * @var string
	 */
	protected $_kind  = NULL;
	/**
	 * @var RaptorDAOSearchParams
	 */
	protected $_daoSP = NULL;
	
	/**
	 * Constructeur
	 * @param RaptorDAOSearchParams $daoSP
	 */
	public function __construct ($daoSP) {
		$this->_daoSP = $daoSP;
	}
	
	/**
	 * Renvoie la chaine WHERE d'une requete SQL
	 * @return string
	 */
	public function getWhere () {
		return '';
	}
	
}

/**
 * Condition des paramètres de recherche sur les DAO
 */
class RaptorDAOSearchParamsCondition extends  RaptorDAOSearchParamsElement {

	private $_field     = NULL;
	private $_condition = NULL;
	private $_value     = NULL;
	
	/**
	 * Constructeur
	 * @param string                $field     Nom du champ de la dao sur lequel on effectue la condition (%X pour atteindre une jointure) 
	 * @param string                $condition Condition à appliquer (
	 *                                         	RaptorDAO:COND_EGAL, RaptorDAO:COND_SUP, RaptorDAO:COND_INF, RaptorDAO:COND_NOT, 
	 *                                         	RaptorDAO:COND_SUPE, RaptorDAO:COND_INFE, RaptorDAO:COND_LIKE
	 *                                         )
	 * @param mixed                 $value     Valeur de recherche (inutile de quotter les chaines)
	 * @param string                $kind      Type de condition, AND ou OR
	 * @param RaptorDAOSearchParams $daoSP
	 */
	public function __construct ($field, $condition, $value, $kind, $daoSP) {
		
		parent::__construct($daoSP); 
		
		//On supporte la condition "!=" pour "<>"
		if ($condition == '<>') {
			$condition = '!=';
		}
		$condition = strtoupper ($condition);
		$kind = strtoupper ($kind);
		
		switch ($condition) {
			case RaptorDAO::COND_EGAL:
			case RaptorDAO::COND_INF:
			case RaptorDAO::COND_SUP:
			case RaptorDAO::COND_INFE:
			case RaptorDAO::COND_SUPE:
			case RaptorDAO::COND_NOT:
			case RaptorDAO::COND_LIKE:
				break;
			default:
				throw new RaptorDAOException(__('La condition \'%0\' n\'est pas supporté', array ($condition)));
		}
		switch ($kind) {
			case RaptorDAO::KIND_AND:
			case RaptorDAO::KIND_OR:
				break;
			default:
				throw new RaptorDAOException(__('Le kind \'%0\' n\'est pas supporté', array ($kind)));
		}
		
		if (strpos ($field, '.') === false) {
			$field = '%0.'.$field;
		}
		$field = str_replace ('%', 't', $field);
		
		$this->_field     = $field;
		$this->_condition = $condition;
		$this->_value     = $value;
		$this->_kind      = $kind;
	}
	
	/**
	 * Renvoie la chaine WHERE d'une requete SQL
	 * @return string
	 */
	public function getWhere () {
		
		$explode = explode ('.', $this->_field);
		
		return ' '.$this->_kind.' `'.$explode[0].'`.`'.$explode[1].'` '.$this->_condition.' '.($this->_daoSP->addLinkValue($this->_value));
	}
}

/**
 * Groupe des paramètres de recherche sur les DAO
 */
class RaptorDAOSearchParamsGroup extends  RaptorDAOSearchParamsElement {
	

	private $_racine     = false;
	private $_conditions = array();
	
	/**
	 * Constructer
	 *
	 * @param string                $kind      Type de condition, AND ou OR
	 * @param bool                  $racine Est l'element racine
	 * @param RaptorDAOSearchParams $daoSP
	 */
	public function __construct ($kind, $daoSP, $racine = false) {
		
		parent::__construct($daoSP);
		
		$kind = strtoupper ($kind);
		switch ($kind) {
			case RaptorDAO::KIND_AND:
			case RaptorDAO::KIND_OR:
				break;
			default:
				throw new RaptorDAOException(__('Le kind \'%0\' n\'est pas supporté', array ($kind)));
		}
		$this->_racine = $racine;
		$this->_kind   = $kind;
	}
	
	/**
	 * Ajoute une condition
	 *
	 * @param RaptorDAOSearchParamsCondition $condition
	 */
	public function addCondition (RaptorDAOSearchParamsElement $condition) {
		
		if (count ($this->_conditions) == 0) {
			$condition->_kind = RaptorDAO::KIND_AND;
		}
		
		$this->_conditions[] = $condition;
	}
	
	/**
	 * Renvoie la chaine WHERE d'une requete SQL
	 * @return string
	 */
	public function getWhere () {
		$sql = ' 1';
		foreach ($this->_conditions as $cond) {
			$sql .= $cond->getWhere ();
		}
		if (!$this->_racine) {
			$sql = ' '.$this->_kind.' ('.$sql.') ';
		}
		return $sql;
	}
	
}