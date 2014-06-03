<?php

namespace Raptor;

/**
 * Class le context courrant
 *
 */
class RaptorContext {
	
	/**
	 * Pile de context
	 * @var array()
	 */
	private $_pileContext = array ();
	
	
	/**
	 * Retourne le context courant
	 * @return string
	 */
	public function getCurrent () {
		return (count ($this->_pileContext)) ? $this->_pileContext[count ($this->_pileContext)-1] : NULL;
	}
	
	/**
	 * Retourne le cotnext courrant
	 * @return string
	 */
	public function currentModulePath () {
		$context = $this->getCurrent();
		if (!$context) {
			throw RaptorException (__('Aucun context courant'));
		}
		return MODULES_PATH.$context.'/';
	}
	
	
	/**
	 * Empile un context
	 * @param string $context
	 */
	public function push ($context) {
		array_push ($this->_pileContext, $context);
	}

	/**
	 * Dépile un context
	 * @param string $context
	 */
	public function pop () {
		array_pop ($this->_pileContext);
	}
}