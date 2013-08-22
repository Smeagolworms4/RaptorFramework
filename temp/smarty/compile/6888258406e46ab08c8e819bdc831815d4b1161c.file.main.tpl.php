<?php /* Smarty version Smarty-3.1.12, created on 2013-07-15 03:15:10
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:193823074351e34d1e7211b6-70407770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6888258406e46ab08c8e819bdc831815d4b1161c' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/main.tpl',
      1 => 1373742630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193823074351e34d1e7211b6-70407770',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ppo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51e34d1e73dd12_15176071',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e34d1e73dd12_15176071')) {function content_51e34d1e73dd12_15176071($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr">
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo $_smarty_tpl->tpl_vars['ppo']->value->TITLE_PAGE;?>
<?php if ($_smarty_tpl->tpl_vars['ppo']->value->SUB_TITLE_PAGE){?> - <?php echo $_smarty_tpl->tpl_vars['ppo']->value->SUB_TITLE_PAGE;?>
<?php }?></title>
		
		<?php echo $_smarty_tpl->tpl_vars['ppo']->value->HEAD;?>

		
	</head>
	<body>
		<h1><?php echo $_smarty_tpl->tpl_vars['ppo']->value->TITLE_PAGE;?>
</h1>
		
		<?php echo $_smarty_tpl->tpl_vars['ppo']->value->MAIN;?>

	</body>
</html><?php }} ?>