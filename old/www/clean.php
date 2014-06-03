<?php 
	require_once ('../core/common/path.php');
	
	function deleteItem ($path) {
		
		if (is_dir ($path)) {
			foreach (scandir($path) as $item) {
				if ($item == '.' || $item == '..') {
					continue;
				}
				deleteItem ($path.'/'.$item);
			}
			rmdir($path);
		} else {
			unlink($path);
		}
	}
	
	
	$d = dir (TEMP_PATH);
	$listPath = array ();
	while (false !== ($entry = $d->read())) {
		if ($entry != '..' && $entry != '.') {
			deleteItem (TEMP_PATH.$entry);
		}
	}
	$d->close();