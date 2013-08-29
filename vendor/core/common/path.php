<?php

	define ('ROOT_PATH', realpath (__DIR__.'/../../../').'/');
	define ('VENDOR_PATH', ROOT_PATH.'vendor/');
	
	define ('LIBS_PATH', VENDOR_PATH.'libs/');
	define ('CORE_PATH', VENDOR_PATH.'core/');
	define ('MODULES_PATH', VENDOR_PATH.'modules/');
	define ('VARS_PATH', VENDOR_PATH.'vars/');
	define ('WWW_PATH', ROOT_PATH.'www/');
	define ('WORKSPACE_PATH', ROOT_PATH.'workspace/');
	define ('WORKSPACE_THEMES_PATH', WORKSPACE_PATH.'themes/');
	define ('WORKSPACE_MODULES_PATH', WORKSPACE_PATH.'modules/');
	
	define ('TEMP_PATH', ROOT_PATH.'temp/');
	define ('TEMP_CACHE_PATH', TEMP_PATH.'cache/');
	define ('TEMP_SMARTY_PATH', TEMP_PATH.'smarty/');
	
	define ('SMARTY_PLUGINS_PATH', VENDOR_PATH.'smarty_plugins/');
	
	
	define ('CONTROLLER_DIR', 'controllers');
	define ('TEMPPLATE_DIR', 'templates');
	define ('DATAS_DIR', 'datas');
	define ('WWW_DIR', 'www');
	define ('CLASSES_DIR', 'classes');