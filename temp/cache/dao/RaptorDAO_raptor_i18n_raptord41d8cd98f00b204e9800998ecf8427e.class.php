<?php
class RaptorDAO_raptor_i18n_raptord41d8cd98f00b204e9800998ecf8427e extends RaptorDAO {
	
	protected $_connectionName = NULL;
	protected $_tablename      = 'raptor_i18n';
	protected $_from           = 'FROM `raptor_i18n` AS t0 ';
	
	protected $_joins          = '';
	
	protected $_alias = array(
		'%0'=>'raptor_i18n',
			);
	
	
	/**
	 * Liste des clefs primaires
	 * @var mixed
	 */
	protected $_primarys = array(
									'id',
																	'lang',
												'country',
																);
	
	protected $_listeChamps    = array (
					'id'=> array (
				'type'        => 'string',
				'key'         => 'primary',
				'length'      => '50',
				'notnull'     => '1',
				'default'     => '',
				'multiselect' => '',
				'extra'       => '',
				'values'=> array (
									)
			),
					'text'=> array (
				'type'        => 'string',
				'key'         => '',
				'length'      => '2147483647',
				'notnull'     => '1',
				'default'     => '',
				'multiselect' => '',
				'extra'       => '',
				'values'=> array (
									)
			),
					'lang'=> array (
				'type'        => 'string',
				'key'         => 'primary',
				'length'      => '3',
				'notnull'     => '1',
				'default'     => 'fr',
				'multiselect' => '',
				'extra'       => '',
				'values'=> array (
									)
			),
					'country'=> array (
				'type'        => 'string',
				'key'         => 'primary',
				'length'      => '3',
				'notnull'     => '1',
				'default'     => 'FR',
				'multiselect' => '',
				'extra'       => '',
				'values'=> array (
									)
			),
					'auto_insert'=> array (
				'type'        => 'interger',
				'key'         => '',
				'length'      => '1',
				'notnull'     => '1',
				'default'     => '0',
				'multiselect' => '',
				'extra'       => '',
				'values'=> array (
									)
			),
					'last_use'=> array (
				'type'        => 'interger',
				'key'         => '',
				'length'      => '11',
				'notnull'     => '1',
				'default'     => 'CURRENT_TIMESTAMP',
				'multiselect' => '',
				'extra'       => 'on update CURRENT_TIMESTAMP',
				'values'=> array (
									)
			),
			);
	
	protected $_listeChampsJointure = array (
			);
	
	public function __construct ($connectionName) {
		$this->_connectionName = $connectionName;
	}
	
	
}
