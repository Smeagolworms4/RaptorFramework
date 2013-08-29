<?php
/**
 * Classe qui contient un certain nombre de fonction pour faciliter la génération de PHP
 */
class RaptorPHPGenerator {
	/**
	 * Dernier contenu retourné par getPHPTags
	 *
	 * @var string
	 */
	private $_content = null;

	/**
	 * Constructeur
	 * @param string $varName nom de la variable à générer
	 * @param mixed  $vars    contenu de la variable à générer
	 * @param bool   $entetePHP
	 */
	public function __construct ($varName, $vars = null, $entetePHP = true) {
		$this->_content = '';
		if ($entetePHP) {
			$this->_content = "<?php\n";
		}
		$this->_content .= '$'.$varName.' = '.var_export ($vars, true).';';
	}
	
	/**
	 * Renvoie la valeur du contenu généré
	 * @return string
	 */
	public function getContent () {
		return $this->_content;
	}
	
}