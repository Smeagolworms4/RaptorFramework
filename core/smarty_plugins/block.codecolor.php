<?php
/**
 * Bloc pour l'i18n
 */
function smarty_block_codecolor ($pParams, $pContent, &$me, $first) {
	if (is_null ($pContent) && $first === true) {
		return ;
	}

	$id       = (isset ($pParams['id']))       ? $pParams['id']       : uniqid('codecolor_');
	$name     = (isset ($pParams['name']))     ? $pParams['name']     : $id;
	$rows     = (isset ($pParams['rows']))     ? $pParams['rows']     : '20';
	$cols     = (isset ($pParams['cols']))     ? $pParams['cols']     : '100';
	$language = (isset ($pParams['language'])) ? $pParams['language'] : 'php';
	$class    = (isset ($pParams['class']))    ? $pParams['class']    : '';
	$theme    = (isset ($pParams['theme']))    ? $pParams['theme']    : 'github';
	
	_ioClass ('RaptorHTMLHeader')->addCSSLink ('default|js/libs/highlight.js/styles/'.$theme.'.css');
	_ioClass ('RaptorHTMLHeader')->addJSLink  ('default|js/libs/highlight.js/highlight.pack.js');
	
	$return = '
		<div id="'.$id.'" class="RaptorColor '.$class.'" >
			<div>
				<pre><code id="'.$id.'_code" class="php" style="display: none;" >'.htmlentities ($pContent).'</code></pre>
				<textarea id="'.$id.'_textarea" name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'" >'.$pContent.'</textarea>
			</div>
		</div>
	';
	_ioClass ('RaptorHTMLHeader')->addJSCodeOnLoad ('new Raptor.Code (\''.$id.'\', \''.$language.'\');', true);
	
	if (isset ($pParams['assign'])) {
		$me->assign ($pParams['assign'], $return);
		return;
	}
	return $return;
}