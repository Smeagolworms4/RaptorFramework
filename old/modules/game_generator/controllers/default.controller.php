<?php

/**
 * Picross
 **/
class DefaultActionController extends ActionController {
	
	/**
	 * Page initial du framework
	 * @return RaptorActionReturn
	 */
	public function processDefault () {
		
		RaptorRequest::assert ('m');
		$m = _request ('m');
		
		
		
		//$dyn
		
		return _arNone();
	}
}