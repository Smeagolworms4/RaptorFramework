<?php
/**
 * Bloc pour l'i18n
 */
function smarty_block___ ($pParams, $pContent, &$me, $first) {
	if (is_null ($pContent) && $first === true) {
		return ;
	}
	if (isset ($pParams['assign'])){
		$me->assign ($pParams['assign'], __($pContent));
		return;
	}
	return __($pContent);
}