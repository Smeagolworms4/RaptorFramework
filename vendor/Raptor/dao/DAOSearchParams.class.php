<?php

namespace Raptor\dao;

/**
 * Paramètre de recherche sur les DAO
 */
class DAOSearchParams {
	
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
	public function __construct ($kind = DAO::KIND_AND) {
		$this->_paramRoot = new DAOSearchParamsGroup ($kind = DAO::KIND_AND, $this, true);
		$this->_pile[0]   = $this->_paramRoot;
		$this->_kind      = $kind;
	}
	
	/**
	 * Ajoute une condition
	 *
	 * @param string $field     Nom du champ de la dao sur lequel on effectue la condition (%X pour atteindre une jointure) 
	 * @param string $condition Condition à appliquer (
	 *                          	DAO:COND_EGAL, DAO:COND_SUP, DAO:COND_INF, DAO:COND_NOT, 
	 *                          	DAO:COND_SUPE, DAO:COND_INFE, DAO:COND_LIKE
	 *                          )
	 * @param mixed $value      Valeur de recherche (inutile de quotter les chaines) Peut être un tableau
	 * @param string $kind      Type de condition, AND ou OR
	 * @return DAOSearchParams
	 */
	public function addCondition ($field, $condition, $value, $kind = NULL) {
		
		if ($kind === NULL) {
			$kind = $this->_kind;
		}
		
		if (is_array($value)) {
			$this->startGroup ($kind);
			foreach ($value as $val) {
				$this->addCondition ($field, $condition, $val, DAO::KIND_OR);
			}
			$this->endGroup();
		} else {
			$this->_pile[$this->_target]->addCondition (new DAOSearchParamsCondition ($field, $condition, $value, $kind, $this));
		}
		
		return $this;
	}
	
	/**
	 * Démarre un groupe de condition
	 *
	 * @param string $kind Type de groupe que l'on souhaite démarrer, AND ou OR
	 * @return DAOSearchParams
	 */
	public function startGroup ($kind = NULL) {
		
		if ($kind === NULL) {
			$kind = $this->_kind;
		}
		
		$group = new DAOSearchParamsGroup ($kind, $this);
		$this->_pile[$this->_target]->addCondition ($group);
		$this->_target++;
		$this->_pile[$this->_target]= $group;
		return $this;
	}
	
	/**
	 * Ferme un groupe de condition
	 * @return DAOSearchParams
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
	 * @return DAOSearchParams
	 */
	public function orderBy () {
		$args = func_get_args ();
		foreach ($args as $arg) {
			if (is_array ($arg)) {
				foreach ($arg as $champ=>$ordre) {
					$ordre = strtoupper($ordre);
					switch ($ordre) {
						case DAO::ORDRE_ASC:
						case DAO::ORDRE_DESC:
							break;
						default:
							throw new DAOException(__('L\'odre ne peut être que \'DESC\' ou \'ASC\' mais \'%0\' n\'est pas supporté', array ($ordre)));
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
				$this->_orders[] = array ($arg=>DAO::ORDRE_ASC);
			}
		}
		return $this;
	}
	
	/**
	 * Ajoute un groupage par champs
	 * @param string ...
	 * @return DAOSearchParams
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
abstract class DAOSearchParamsElement {
	
	/**
	 * @var string
	 */
	protected $_kind  = NULL;
	/**
	 * @var DAOSearchParams
	 */
	protected $_daoSP = NULL;
	
	/**
	 * Constructeur
	 * @param DAOSearchParams $daoSP
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
class DAOSearchParamsCondition extends  DAOSearchParamsElement {

	private $_field     = NULL;
	private $_condition = NULL;
	private $_value     = NULL;
	
	/**
	 * Constructeur
	 * @param string                $field     Nom du champ de la dao sur lequel on effectue la condition (%X pour atteindre une jointure) 
	 * @param string                $condition Condition à appliquer (
	 *                                         	DAO:COND_EGAL, DAO:COND_SUP, DAO:COND_INF, DAO:COND_NOT, 
	 *                                         	DAO:COND_SUPE, DAO:COND_INFE, DAO:COND_LIKE
	 *                                         )
	 * @param mixed                 $value     Valeur de recherche (inutile de quotter les chaines)
	 * @param string                $kind      Type de condition, AND ou OR
	 * @param DAOSearchParams $daoSP
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
			case DAO::COND_EGAL:
			case DAO::COND_INF:
			case DAO::COND_SUP:
			case DAO::COND_INFE:
			case DAO::COND_SUPE:
			case DAO::COND_NOT:
			case DAO::COND_LIKE:
				break;
			default:
				throw new DAOException(__('La condition \'%0\' n\'est pas supporté', array ($condition)));
		}
		switch ($kind) {
			case DAO::KIND_AND:
			case DAO::KIND_OR:
				break;
			default:
				throw new DAOException(__('Le kind \'%0\' n\'est pas supporté', array ($kind)));
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
class DAOSearchParamsGroup extends  DAOSearchParamsElement {
	

	private $_racine     = false;
	private $_conditions = array();
	
	/**
	 * Constructer
	 *
	 * @param string                $kind      Type de condition, AND ou OR
	 * @param bool                  $racine Est l'element racine
	 * @param DAOSearchParams $daoSP
	 */
	public function __construct ($kind, $daoSP, $racine = false) {
		
		parent::__construct($daoSP);
		
		$kind = strtoupper ($kind);
		switch ($kind) {
			case DAO::KIND_AND:
			case DAO::KIND_OR:
				break;
			default:
				throw new DAOException(__('Le kind \'%0\' n\'est pas supporté', array ($kind)));
		}
		$this->_racine = $racine;
		$this->_kind   = $kind;
	}
	
	/**
	 * Ajoute une condition
	 *
	 * @param DAOSearchParamsCondition $condition
	 */
	public function addCondition (DAOSearchParamsElement $condition) {
		
		if (count ($this->_conditions) == 0) {
			$condition->_kind = DAO::KIND_AND;
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