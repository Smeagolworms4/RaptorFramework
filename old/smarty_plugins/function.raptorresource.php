<?php
/**
* Plugin smarty type fonction
* Purpose: génération du chemin d'une ressource
*
* Input: path   = le/chemin/de/la/ressource.ext
* Input: assign = varName
*/
function smarty_function_raptorresource($params, &$me) {
	$return = _resource ($params['path']);
	$assign = isset ($params['assign']) ? $params['assign'] : null;
	
	if ($assign !== null) {
		$me->assign($assign, $return);
		return '';
	} else {
		return $return;
	}
}