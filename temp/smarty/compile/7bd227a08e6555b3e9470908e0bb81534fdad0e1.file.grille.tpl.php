<?php /* Smarty version Smarty-3.1.12, created on 2013-08-05 02:53:11
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/picross/templates/default/grille.tpl" */ ?>
<?php /*%%SmartyHeaderCode:41604268851e34c447265a7-83297114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7bd227a08e6555b3e9470908e0bb81534fdad0e1' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/picross/templates/default/grille.tpl',
      1 => 1375663982,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41604268851e34c447265a7-83297114',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51e34c447513a9_39072330',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51e34c447513a9_39072330')) {function content_51e34c447513a9_39072330($_smarty_tpl) {?><?php if (!is_callable('smarty_function_raptorresource')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../smarty_plugins/function.raptorresource.php';
?><div id="metagrille" ></div>
<div id="debug" ></div>
<div id="debug2" ></div>

<script type="text/javascript">
//<!--
// 
	
	var GET = Raptor.extractUrlParams();
	var metagrille = null;
	
	var request = new Request.JSON({
		url:'<?php echo smarty_function_raptorresource(array('path'=>"picross|datas/'+GET['i']+'.json"),$_smarty_tpl);?>
',
		onSuccess: function (image) {
			metagrille = new Picross.MetaGrille ($('metagrille'), image);
			
			metagrille.display ();
			
		}
	});
	
	request.get();
	
	alert ("ddddd");
	
// 
//-->
</script>
<?php }} ?>