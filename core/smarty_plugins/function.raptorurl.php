<?php
/**
* Plugin smarty type fonction
* Purpose: génération du chemin d'une URL
*
* Input: dest   = controller|action
* Input: assign = varName
*/
function smarty_function_raptorurl($params, &$me) {
	$assign = isset ($params['assign']) ? $params['assign'] : null;
	$dest = $params['dest'];
	
	if ($assign) {
		unset ($params['assign']);
	}
	unset ($params['dest']);
	
	$return = _url ($dest, $params);
	
	if ($assign !== null) {
		$me->assign($assign, $return);
		return '';
	} else {
		return $return;
	}
}