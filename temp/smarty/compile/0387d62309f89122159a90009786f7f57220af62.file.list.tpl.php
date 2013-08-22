<?php /* Smarty version Smarty-3.1.12, created on 2013-07-21 05:41:37
         compiled from "/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/picross/templates/buildimage/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:190007650551eb58715cdc49-70736561%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0387d62309f89122159a90009786f7f57220af62' => 
    array (
      0 => '/home/smeagol/Works/Programmation/dahosen/svn/Picross/modules/picross/templates/buildimage/list.tpl',
      1 => 1373798896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '190007650551eb58715cdc49-70736561',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ppo' => 0,
    'key' => 0,
    'modulo' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51eb58716d5516_53604083',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51eb58716d5516_53604083')) {function content_51eb58716d5516_53604083($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../libs/Smarty/plugins/function.math.php';
if (!is_callable('smarty_function_raptorurl')) include '/home/smeagol/Works/Programmation/dahosen/svn/Picross/core/common/../../smarty_plugins/function.raptorurl.php';
?><script type="text/javascript">
	//<!--
	// 
	
	var convertir = function (id) {
		var form = $('conv_'+id);
		var data = {};
		form.getElements('input, select, textarea').each (function (el) {
			data[el.name] = el.value;
		});
		
		var request = new Request.HTML({
			'url':form.action,
			'update':$('result_'+id),
			'data': data
		});
		request.post ();
	};
	
	// 
	//-->
</script>

<table>
	<tr>
		<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ppo']->value->images; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['image']->key;
?>
			
			<?php echo smarty_function_math(array('equation'=>"x % 3",'x'=>$_smarty_tpl->tpl_vars['key']->value,'assign'=>'modulo'),$_smarty_tpl);?>

			<?php if ($_smarty_tpl->tpl_vars['modulo']->value==0){?>
				</tr><tr> 
			<?php }?>
			
			<td style="border:1px solid #AAA; white-space: nowrap; " >
				<div style="margin-bottom: 10px;" >
					<div style="display: inline-block; position: relative;" >
						<div id="decoupe_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" class="decoupe" style="position:absolute; top:0; left:0;" ></div>
						<img id="img_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" src="<?php echo smarty_function_raptorurl(array('dest'=>'picross|buildimage|getimage','i'=>$_smarty_tpl->tpl_vars['image']->value->link),$_smarty_tpl);?>
" width="<?php echo $_smarty_tpl->tpl_vars['image']->value->width*$_smarty_tpl->tpl_vars['ppo']->value->MULTIPLICATEUR;?>
px" height="<?php echo $_smarty_tpl->tpl_vars['image']->value->height*$_smarty_tpl->tpl_vars['ppo']->value->MULTIPLICATEUR;?>
px" alt="<?php echo $_smarty_tpl->tpl_vars['image']->value->link;?>
" />
					</div>
				</div>
				<div style="display: inline-block;" >
					<form id="conv_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" action="<?php echo smarty_function_raptorurl(array('dest'=>'picross|buildimage|build'),$_smarty_tpl);?>
" method="post" >
						<?php echo $_smarty_tpl->tpl_vars['image']->value->link;?>
<br />
						<input type="hidden" name="link" value="<?php echo $_smarty_tpl->tpl_vars['image']->value->link;?>
" />
						
						background : <div id="bgview_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" style="width:20px; height:15px;" ></div>
						<br />
						<div id="result_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" ></div>
						
						
						x : <input id="nx_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" type="text" value="<?php echo $_smarty_tpl->tpl_vars['image']->value->width;?>
" name="g_width" class="g_width" size="3" maxlength="3" /><br />
						y : <input id="ny_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
" type="text" value="<?php echo $_smarty_tpl->tpl_vars['image']->value->height;?>
" name="g_height" class="g_height" size="3" maxlength="3" /><br />
						<input type="button" value="convertir" onclick="convertir('<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
')" />
					</form>
				</div>
				
				<script type="text/javascript">
					//<!--
					// 
					
					var decoupe = $('decoupe_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
');
					var nx      = $('nx_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
');
					var ny      = $('ny_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
');
					var width   = <?php echo $_smarty_tpl->tpl_vars['image']->value->width*$_smarty_tpl->tpl_vars['ppo']->value->MULTIPLICATEUR;?>
;
					var height  = <?php echo $_smarty_tpl->tpl_vars['image']->value->height*$_smarty_tpl->tpl_vars['ppo']->value->MULTIPLICATEUR;?>
;
					
					decoupe.setStyles ({
						'width'  : width+'px',
						'height' : height+'px'
					});
					
					var redim = function () {
						var nx      = parseInt ($('nx_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
').value, 10);
						var ny      = parseInt ($('ny_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
').value, 10);
						var width   = <?php echo $_smarty_tpl->tpl_vars['image']->value->width;?>
;
						var height  = <?php echo $_smarty_tpl->tpl_vars['image']->value->height;?>
;
						var decoupe = $('decoupe_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
');
						var multiplicateur =<?php echo $_smarty_tpl->tpl_vars['ppo']->value->MULTIPLICATEUR;?>
;
						var bgview   = $('bgview_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
');
						
						if (nb_x < 1) { nb_x = 1; }
						if (nb_y < 1) { nb_y = 1; }
						
						var nb_x = Math.ceil(width/nx);
						var nb_y = Math.ceil(height/ny);
	
						decoupe.innerHTML = '';
						bgview.innerHTML = '';
						
						decoupe.setStyles ({
							'width':(nx*multiplicateur*nb_x)+'px',
							'height':(ny*multiplicateur*nb_y)+'px'
						});
						decoupe.getParent().setStyles ({
							'min-width':(nx*multiplicateur*nb_x)+'px',
							'min-height':(ny*multiplicateur*nb_y)+'px'
						});
						bgview.setStyles ({
							'width':(22*nb_x)+'px',
							'height':(17*nb_y)+'px'
						});
						
						var table = new Element ('table',  {
							'cellpadding':'0',
							'cellspacing':'0',
							'border':'0',
							'style':'border-collapse:collapse'
						});
						table.inject (decoupe);
						
						var tableBg = new Element ('table');
						tableBg.inject (bgview);
						
						for (var i = 0; i < nb_y; i++) {
							var tr = new Element ('tr');
							tr.inject (table);
	
							var trBg = new Element ('tr');
							trBg.inject (tableBg);
							
							for (var j = 0; j < nb_x; j++) {
								var td = new Element ('td', {
									'style':'width:'+(nx*multiplicateur-1)+'px; height:'+(ny*multiplicateur-1)+'px; border:1px solid #000;'
								});
								td.inject (tr);
								
								var tdBg = new Element ('td', {
									'style':'width:15px; height:15px; border:1px solid #000; background-color:<?php echo $_smarty_tpl->tpl_vars['image']->value->pixels[0];?>
;'
								});
								
								tdBg.inject (trBg);
								var input = new Element ('input', {
									'type':'hidden',
									'name':'backgroundcolor['+(j+i*nb_x)+']',
									'value':'<?php echo $_smarty_tpl->tpl_vars['image']->value->pixels[0];?>
'
								});
								input.inject (tdBg);
								
								(function (tdBg, input) {
									td.addEvent ('click', function (e) {
										
										var image = <?php echo json_encode($_smarty_tpl->tpl_vars['image']->value);?>
;
										var x = e.page.x - this.getParent ().getParent ().getPosition ().x;
										var y = e.page.y - this.getParent ().getParent ().getPosition ().y;
										var multiplicateur = <?php echo $_smarty_tpl->tpl_vars['ppo']->value->MULTIPLICATEUR;?>
;
										var bgview   = $('bgview_<?php echo $_smarty_tpl->tpl_vars['image']->value->id;?>
');
										var ligne    = (parseInt(x/multiplicateur, 10));
										var collonne = (parseInt(y/multiplicateur, 10));
										
										var color = image.pixels [ligne + collonne*image.width];
										
										tdBg.setStyle('background-color', color);
										input.value = color;
										
									});
								}) (tdBg, input);
							}
						}
					};
	
					redim ();
					nx.addEvent ('keyup', redim);
					ny.addEvent ('keyup', redim);


					// 
					//-->
				</script>
				
			</td>
			
		<?php } ?>
	</tr>
</table><?php }} ?>