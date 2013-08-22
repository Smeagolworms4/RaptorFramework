<?php

$config = RaptorConfig::getInstance ();

$config->MODE = 'DEV';
$config->VERSION = '0.1';


$config->homePage = 'default|default|welcome';

$config->dataTablePrefixe = 'raptor_';

$config->arConnection = array (
	'raptor' => array (
		'driver'   => 'pdo_mysql',
		'host'     => '127.0.0.1',
		'database' => 'raptor',
		'user'     => 'root',
		'password' => ''
	)
);

$config->defaultConnection = 'raptor';
