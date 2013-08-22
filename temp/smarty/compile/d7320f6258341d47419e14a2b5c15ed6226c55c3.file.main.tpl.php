<?php /* Smarty version Smarty-3.1.12, created on 2013-08-03 18:44:54
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/themes/picross/modules/default/templates/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18575795951e34c447552f2-92472263%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7320f6258341d47419e14a2b5c15ed6226c55c3' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/themes/picross/modules/default/templates/main.tpl',
      1 => 1375548284,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18575795951e34c447552f2-92472263',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51e34c44772434_74604775',
  'variables' => 
  array (
    'ppo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e34c44772434_74604775')) {function content_51e34c44772434_74604775($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr">
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
		<meta name="HandheldFriendly" content="true" />
		
		<title><?php echo $_smarty_tpl->tpl_vars['ppo']->value->TITLE_PAGE;?>
<?php if ($_smarty_tpl->tpl_vars['ppo']->value->SUB_TITLE_PAGE){?> - <?php echo $_smarty_tpl->tpl_vars['ppo']->value->SUB_TITLE_PAGE;?>
<?php }?></title>
		
		<?php echo $_smarty_tpl->tpl_vars['ppo']->value->HEAD;?>

		
	</head>
	<body>
		<div id="main" class="main" >
			<div id="main-content" class="main-content" >
				<div id="content" class="content" >
					
					<script type="text/javascript">
					//<!--
					// 
						
						(function () {
							var display = Display.getInstance ();
							display.resizeOnScreen ($('main'));
							window.addEvent ('resize', function () {
								display.resizeOnScreen ($('main'));
								display.adapteZoomContent ($('content'));
							});
							
						}) ();
						
						
					// 
					//-->
					</script>
					
					<?php echo $_smarty_tpl->tpl_vars['ppo']->value->MAIN;?>

					
					
					<script type="text/javascript">
					//<!--
					// 
						
						(function () {
							
							var display = Display.getInstance ();
							display.adapteZoomContent ($('content'));
						}) ();
						
					// 
					//-->
					</script>
					
				</div>
			</div>
		</div>
	</body>
</html><?php }} ?>