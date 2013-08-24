$config = RaptorConfig::getInstance ();

// {'Vous pouvez choisir entre :'|__}
// RaptorConfig::MODE_DEV
// RaptorConfig::MODE_PROD
$config->MODE = RaptorConfig::MODE_PROD;


$config->homePage = 'default|default|welcome';


$config->dataTablePrefixe = 'raptor_';


$config->arConnection = array (
	'default_connection' => array (
		'driver'   => 'pdo_mysql',
		'host'     => '',
		'database' => '',
		'user'     => '',
		'password' => ''
	)
);

$config->defaultConnection = 'default_connection';