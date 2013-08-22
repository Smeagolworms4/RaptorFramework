<?php
/**
* Plugin smarty type fonction
* Purpose: génération d'une zone
* 
* Input: dest = controller|actio
*/
function smarty_function_raptorzone($params, &$me) {
	$dest = $params['dest'];
	unset ($params['dest']);
	
	$url = _url ($dest, $params);
	$zone = new RaptorZone ($url);
	
	return $zone->getHTML ();
}