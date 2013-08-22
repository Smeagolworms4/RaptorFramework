<?php /* Smarty version Smarty-3.1.12, created on 2013-07-15 03:21:18
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/dao.tpl" */ ?>
<?php /*%%SmartyHeaderCode:153137743951e34e8ea860d9-79182989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7de68fd6383b08f7865a1246699509a80c0802e3' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/dao.tpl',
      1 => 1355858676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153137743951e34e8ea860d9-79182989',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ppo' => 0,
    'join' => 0,
    'key' => 0,
    'champs' => 0,
    'name' => 0,
    'value' => 0,
    'listeChamps' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51e34e8eb405b1_39592453',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e34e8eb405b1_39592453')) {function content_51e34e8eb405b1_39592453($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../libs/Smarty/plugins/modifier.replace.php';
?>class <?php echo $_smarty_tpl->tpl_vars['ppo']->value->classname;?>
 extends RaptorDAO {
	
	protected $_connectionName = NULL;
	protected $_tablename      = '<?php echo $_smarty_tpl->tpl_vars['ppo']->value->tablename;?>
';
	protected $_from           = 'FROM `<?php echo $_smarty_tpl->tpl_vars['ppo']->value->tablename;?>
` AS t0 ';
	
	protected $_joins          = '<?php  $_smarty_tpl->tpl_vars['join'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['join']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->joinParse; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['join']->key => $_smarty_tpl->tpl_vars['join']->value){
$_smarty_tpl->tpl_vars['join']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['join']->key;
?><?php echo $_smarty_tpl->tpl_vars['join']->value[1];?>
 JOIN <?php echo $_smarty_tpl->tpl_vars['join']->value[0];?>
 AS t<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
 ON <?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['join']->value[2],'%','t');?>
 <?php } ?>';
	
	protected $_alias = array(
		'%0'=>'<?php echo $_smarty_tpl->tpl_vars['ppo']->value->tablename;?>
',
		<?php  $_smarty_tpl->tpl_vars['join'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['join']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->joinParse; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['join']->key => $_smarty_tpl->tpl_vars['join']->value){
$_smarty_tpl->tpl_vars['join']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['join']->key;
?>
			'%<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
'=>'<?php echo $_smarty_tpl->tpl_vars['join']->value[0];?>
',
		<?php } ?>
	);
	
	
	/**
	 * Liste des clefs primaires
	 * @var mixed
	 */
	protected $_primarys = array(
		<?php  $_smarty_tpl->tpl_vars['champs'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['champs']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->listeChamps; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['champs']->key => $_smarty_tpl->tpl_vars['champs']->value){
$_smarty_tpl->tpl_vars['champs']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['champs']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['champs']->value->key=='primary'){?>
				'<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
',
			<?php }?>
		<?php } ?>
	);
	
	protected $_listeChamps    = array (
		<?php  $_smarty_tpl->tpl_vars['champs'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['champs']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->listeChamps; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['champs']->key => $_smarty_tpl->tpl_vars['champs']->value){
$_smarty_tpl->tpl_vars['champs']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['champs']->key;
?>
			'<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
'=> array (
				'type'        => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->type;?>
',
				'key'         => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->key;?>
',
				'length'      => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->length;?>
',
				'notnull'     => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->notnull;?>
',
				'default'     => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->default;?>
',
				'multiselect' => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->multiselect;?>
',
				'extra'       => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->extra;?>
',
				'values'=> array (
					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['champs']->value->values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
						 '<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
',
					<?php } ?>
				)
			),
		<?php } ?>
	);
	
	protected $_listeChampsJointure = array (
		<?php  $_smarty_tpl->tpl_vars['listeChamps'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['listeChamps']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->listeChampsJointure; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['listeChamps']->key => $_smarty_tpl->tpl_vars['listeChamps']->value){
$_smarty_tpl->tpl_vars['listeChamps']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['listeChamps']->key;
?>
			'<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'=>  array (
				<?php  $_smarty_tpl->tpl_vars['champs'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['champs']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['listeChamps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['champs']->key => $_smarty_tpl->tpl_vars['champs']->value){
$_smarty_tpl->tpl_vars['champs']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['champs']->key;
?>
					'<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
'=> array (
						'type'        => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->type;?>
',
						'key'         => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->key;?>
',
						'length'      => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->length;?>
',
						'notnull'     => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->notnull;?>
',
						'default'     => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->default;?>
',
						'multiselect' => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->multiselect;?>
',
						'extra'       => '<?php echo $_smarty_tpl->tpl_vars['champs']->value->extra;?>
',
						'values'=> array (
							<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['champs']->value->values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
								 '<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
',
							<?php } ?>
						)
					),
				<?php } ?>
			),
		<?php } ?>
	);
	
	public function __construct ($connectionName) {
		$this->_connectionName = $connectionName;
	}
	
	
}
<?php }} ?>