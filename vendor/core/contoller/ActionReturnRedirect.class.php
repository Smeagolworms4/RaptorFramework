<?php

namespace Raptor;

/**
 * Class PHP permettant de gérer les objet returné par une action
 * 
 */
class ActionReturnRedirect extends RaptorActionReturn {
	/**
	 * Renvoie le contenu de l'action
	 * @return string
	 */
	public function fetch () {
		$url = $this->_getPPO (); // A la place de stoquer un ppo on stoque l'adresse de la redirection
		header("Location: ".$url);
		return '';
	}
}