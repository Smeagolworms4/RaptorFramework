<?php 
	require_once ('../vendor/Raptor/common/path.php');

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	error_reporting(E_ALL);
	
	function deleteItem ($path) {
		if (is_dir ($path)) {
			foreach (scandir($path) as $item) {
				if ($item == '.' || $item == '..') {
					continue;
				}
				deleteItem ($path.'/'.$item);
			}
			echo '<span style="color: blue;" >rmdir : </span><span style="color: grey;" >'.$path.'</span><br />';
			rmdir($path);
		} else {
			echo '<span style="color: blue;" >unlink : </span><span style="color: grey;" >'.$path.'</span><br />';
			unlink($path);
		}
	}
	
	
	$d = dir (TEMP_PATH);
	if ($d) {
		$listPath = array ();
		while (false !== ($entry = $d->read())) {
			if ($entry != '..' && $entry != '.') {
				deleteItem (TEMP_PATH.$entry);
			}
		}
		$d->close();

		echo '<br /><strong>cleaned : </strong><span style="color: green;" >OK</span>';
	} else {
		echo '<br /><strong>cleaned : </strong><span style="color: red;" >KO</span>';
	}
	