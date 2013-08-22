<?php /* Smarty version Smarty-3.1.12, created on 2013-07-15 18:10:37
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/picross/templates/default/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:157312639051e355439cbae3-58930517%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a63430e518254e956f755e61e3fddc27b9cf0540' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/picross/templates/default/list.tpl',
      1 => 1373903613,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157312639051e355439cbae3-58930517',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51e35543a0a164_39904448',
  'variables' => 
  array (
    'ppo' => 0,
    'key' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e35543a0a164_39904448')) {function content_51e35543a0a164_39904448($_smarty_tpl) {?><?php if (!is_callable('smarty_function_raptorurl')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../smarty_plugins/function.raptorurl.php';
?><ul>
	<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['key']->value] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->images; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars[$_smarty_tpl->tpl_vars['key']->value]->value = $_smarty_tpl->tpl_vars['image']->key;
?>
		<li><a href="<?php echo smarty_function_raptorurl(array('dest'=>'picross||grille','i'=>$_smarty_tpl->tpl_vars['image']->value),$_smarty_tpl);?>
" ><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
</a></li>
	<?php } ?>
</ul><?php }} ?>