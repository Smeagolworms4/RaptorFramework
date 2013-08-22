<?php /* Smarty version Smarty-3.1.12, created on 2013-08-03 15:17:38
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/exception.tpl" */ ?>
<?php /*%%SmartyHeaderCode:209466681251fd02f234ace4-62230552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c383fd074fdbe7065a7a274ec2b28b706e48f12' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/exception.tpl',
      1 => 1355858676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209466681251fd02f234ace4-62230552',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ppo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51fd02f2997a38_73989843',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51fd02f2997a38_73989843')) {function content_51fd02f2997a38_73989843($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier___')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../smarty_plugins/modifier.__.php';
?>
<div>
	<h2><?php echo smarty_modifier___('Erreur');?>
 - <?php echo $_smarty_tpl->tpl_vars['ppo']->value->type;?>
</h2>
	<?php echo $_smarty_tpl->tpl_vars['ppo']->value->message;?>
<?php if ($_smarty_tpl->tpl_vars['ppo']->value->code){?> : <?php echo $_smarty_tpl->tpl_vars['ppo']->value->code;?>
<?php }?>
</div><?php }} ?>