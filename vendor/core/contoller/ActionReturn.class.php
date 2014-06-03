<?php

namespace Raptor;

/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
abstract class ActionReturn {
	
	/**
	 * @var PPO
	 */
	private $_ppo;
	
	/**
	 * @var array
	 */
	private $_options;
	
	/**
	 * @var mixed
	 */
	private $_param;
	
	/**
	 * Constructeur
	 * @param PPO $ppo
	 * @param mixed     $param
	 * @param array     $options
	 */
	public function __construct ($ppo = null, $param = null, $options = array() ) {
		$this->_ppo = $ppo;
		$this->_param = $param;
		$this->_options = $options;
	}
	
	/**
	 * Renvoie l'option
	 * @return array
	 */
	protected function _getOptions () {
		return $this->_options;
	}
	
	/**
	 * Renvoie le premier paramètre
	 * @return mixed
	 */
	protected function _getParam () {
		return $this->_param;
	}
	
	/**
	 * Renvoie le'objet PPO
	 * @return PPO
	 */
	protected function _getPPO () {
		return $this->_ppo;
	}
	
	/**
	 * Assigne une variable à l'objet PPO
	 * @param string $name
	 * @param mixed $value
	 */
	public function assignPPOVar ($name, $value) {
		$this->_ppo->$name = $value;
	}
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		return '';
	}
	
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function __toString () {
		return $this->fetch ();
	}
	
}