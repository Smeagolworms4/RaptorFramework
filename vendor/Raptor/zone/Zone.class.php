<?php

namespace Raptor;

/**
 * Class de gestio des zone de template
 *
 */
class Zone {

	private $_url  = NULL;
	
	/**
	 * Constructeur
	 * @param string $url
	 */
	public function __construct ($url) {
		$this->_url  = $url;
	}
	
	/**
	 * Renvoie le HTML correspondant
	 * @return string
	 */
	public function getHTML () {
		$id = uniqid ('raptorzone_');
		$url = str_replace('\'', '\\\'', $this->_url);
		return '
			<div id="'.$id.'" ></div>
			<script type="text/javascript">
			//<!--
				new Raptor.Zone (\''.$id.'\', \''.$url.'\');
			//-->
			</script>
		';
	}
}
