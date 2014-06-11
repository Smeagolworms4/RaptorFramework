<?php

namespace Raptor\common;

define ('ROOT_PATH', realpath (__DIR__.'/../../../').'/');
define ('VENDOR_PATH', ROOT_PATH.'vendor/');

define ('LIBS_PATH', VENDOR_PATH.'libs/');
define ('RAPTOR_PATH', VENDOR_PATH.'Raptor/');
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

class Path {
	
	const ROOT_PATH   = ROOT_PATH;
	const VENDOR_PATH = VENDOR_PATH;
	
	const LIBS_PATH              = LIBS_PATH;
	const RAPTOR_PATH            = RAPTOR_PATH;
	const MODULES_PATH           = MODULES_PATH;
	const VARS_PATH              = VARS_PATH;
	const WWW_PATH               = WWW_PATH;
	const WORKSPACE_PATH         = WORKSPACE_PATH;
	const WORKSPACE_THEMES_PATH  = WORKSPACE_THEMES_PATH;
	const WORKSPACE_MODULES_PATH = WORKSPACE_MODULES_PATH;
	
	const TEMP_PATH        = TEMP_PATH;
	const TEMP_CACHE_PATH  = TEMP_CACHE_PATH;
	const TEMP_SMARTY_PATH = TEMP_SMARTY_PATH;
	
	const SMARTY_PLUGINS_PATH = SMARTY_PLUGINS_PATH;
	
	
	const CONTROLLER_DIR = CONTROLLER_DIR;
	const TEMPPLATE_DIR  = TEMPPLATE_DIR;
	const DATAS_DIR      = DATAS_DIR;
	const WWW_DIR        = WWW_DIR;
	const CLASSES_DIR    = CLASSES_DIR;
	
}
