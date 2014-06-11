<?php 
	require_once ('../vendor/Raptor/common/path.php');
	require_once ('../vendor/Raptor/common/autoload.php');
	require_once ('../vendor/Raptor/common/config.php');
	
	$path = (isset($_GET['p'])) ? $_GET['p'] : NULL;
	
	$coord = new RaptorResource ();
	$coord->process ($path);