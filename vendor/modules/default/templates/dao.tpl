class {$ppo->classname} extends RaptorDAO {
	
	protected $_connectionName = NULL;
	protected $_tablename      = '{$ppo->tablename}';
	protected $_from           = 'FROM `{$ppo->tablename}` AS t0 ';
	
	protected $_joins          = '{foreach from=$ppo->joinParse key='key' item='join' }{$join[1]} JOIN {$join[0]} AS t{$key+1} ON {$join[2]|replace:'%':'t'} {/foreach}';
	
	protected $_alias = array(
		'%0'=>'{$ppo->tablename}',
		{foreach from=$ppo->joinParse key='key' item='join' }
			'%{$key+1}'=>'{$join[0]}',
		{/foreach}
	);
	
	
	/**
	 * Liste des clefs primaires
	 * @var mixed
	 */
	protected $_primarys = array(
		{foreach from=$ppo->listeChamps key='name' item='champs' }
			{if $champs->key == 'primary'}
				'{$name}',
			{/if}
		{/foreach}
	);
	
	protected $_listeChamps    = array (
		{foreach from=$ppo->listeChamps key='name' item='champs' }
			'{$name}'=> array (
				'type'        => '{$champs->type}',
				'key'         => '{$champs->key}',
				'length'      => '{$champs->length}',
				'notnull'     => '{$champs->notnull}',
				'default'     => '{$champs->default}',
				'multiselect' => '{$champs->multiselect}',
				'extra'       => '{$champs->extra}',
				'values'=> array (
					{foreach from=$champs->values item='value' }
						 '{$value}',
					{/foreach}
				)
			),
		{/foreach}
	);
	
	protected $_listeChampsJointure = array (
		{foreach from=$ppo->listeChampsJointure key='key' item='listeChamps' }
			'{$key}'=>  array (
				{foreach from=$listeChamps key='name' item='champs' }
					'{$name}'=> array (
						'type'        => '{$champs->type}',
						'key'         => '{$champs->key}',
						'length'      => '{$champs->length}',
						'notnull'     => '{$champs->notnull}',
						'default'     => '{$champs->default}',
						'multiselect' => '{$champs->multiselect}',
						'extra'       => '{$champs->extra}',
						'values'=> array (
							{foreach from=$champs->values item='value' }
								 '{$value}',
							{/foreach}
						)
					),
				{/foreach}
			),
		{/foreach}
	);
	
	public function __construct ($connectionName) {
		$this->_connectionName = $connectionName;
	}
	
	
}
