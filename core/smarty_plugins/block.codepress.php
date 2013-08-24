<?php
/**
 * Bloc pour l'i18n
 */
function smarty_block_codepress ($pParams, $pContent, &$me, $first) {
	if (is_null ($pContent) && $first === true) {
		return ;
	}
	
	$id   = isset ($pParams['id'])   ? $pParams['id']   : uniqid('codepress_');
	$name = isset ($pParams['name']) ? $pParams['name'] : $id;
	$rows = isset ($pParams['rows']) ? $pParams['rows'] : 75;
	$cols = isset ($pParams['cols']) ? $pParams['cols'] : 30;
	
	RaptorHTMLHeader::addCSSLink ('default|js/libs/codepress/codepress.css');
	RaptorHTMLHeader::addJSLink  ('default|js/libs/codepress/codepress.js');
	
	
	$return = '
		<textarea id="'.$id.'" name="'.$name.'"  rows="'.$rows.'"  cols="'.$cols.'" >'.$pContent.'</textarea>
		<script>
		//<!--
			
		//-->
		</script>
	';
	
	if (isset ($pParams['assign'])){
		$me->assign ($pParams['assign'], $return);
		return;
	}
	return $return;
}