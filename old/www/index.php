<?php 
	require_once ('../core/common/path.php');
	require_once ('../core/common/autoload.php');
	require_once ('../core/common/shortcuts.php');
	require_once ('../core/common/config.php');
	
	$coord = new RaptorController ();
	$coord->process ();