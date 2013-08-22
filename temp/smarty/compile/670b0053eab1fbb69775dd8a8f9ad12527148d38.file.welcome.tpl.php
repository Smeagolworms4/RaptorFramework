<?php /* Smarty version Smarty-3.1.12, created on 2013-07-15 04:24:05
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:168375537451e35d4582ed87-12669998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '670b0053eab1fbb69775dd8a8f9ad12527148d38' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/default/templates/welcome.tpl',
      1 => 1373727508,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168375537451e35d4582ed87-12669998',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51e35d45856037_11848969',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e35d45856037_11848969')) {function content_51e35d45856037_11848969($_smarty_tpl) {?><?php if (!is_callable('smarty_block___')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../smarty_plugins/block.__.php';
?><p>
	<?php $_smarty_tpl->smarty->_tag_stack[] = array('__', array()); $_block_repeat=true; echo smarty_block___(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		Welcome to Raptor Framework
	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block___(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

</p><?php }} ?>