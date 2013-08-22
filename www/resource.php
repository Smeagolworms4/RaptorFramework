<?php 
	require_once ('../core/common/path.php');
	require_once ('../core/common/autoload.php');
	require_once ('../core/common/shortcuts.php');
	require_once ('../core/common/config.php');
	
	$path = (isset($_GET['p'])) ? $_GET['p'] : NULL;
	
	$coord = new RaptorResource ();
	$coord->process ($path);