<script type="text/javascript">
	//<!--
	// {literal}
	
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
	
	// {/literal}
	//-->
</script>

<table>
	<tr>
		{foreach from=$ppo->images key=key item=image}
			
			{math equation="x % 3" x=$key assign=modulo }
			{if $modulo == 0}
				</tr><tr> 
			{/if}
			
			<td style="border:1px solid #AAA; white-space: nowrap; " >
				<div style="margin-bottom: 10px;" >
					<div style="display: inline-block; position: relative;" >
						<div id="decoupe_{$image->id}" class="decoupe" style="position:absolute; top:0; left:0;" ></div>
						<img id="img_{$image->id}" src="{raptorurl dest='picross|buildimage|getimage' i=$image->link}" width="{$image->width*$ppo->MULTIPLICATEUR}px" height="{$image->height*$ppo->MULTIPLICATEUR}px" alt="{$image->link}" />
					</div>
				</div>
				<div style="display: inline-block;" >
					<form id="conv_{$image->id}" action="{raptorurl dest='picross|buildimage|build'}" method="post" >
						{$image->link}<br />
						<input type="hidden" name="link" value="{$image->link}" />
						
						background : <div id="bgview_{$image->id}" style="width:20px; height:15px;" ></div>
						<br />
						<div id="result_{$image->id}" ></div>
						
						
						x : <input id="nx_{$image->id}" type="text" value="{$image->width}" name="g_width" class="g_width" size="3" maxlength="3" /><br />
						y : <input id="ny_{$image->id}" type="text" value="{$image->height}" name="g_height" class="g_height" size="3" maxlength="3" /><br />
						<input type="button" value="convertir" onclick="convertir('{$image->id}')" />
					</form>
				</div>
				
				<script type="text/javascript">
					//<!--
					// {literal}
					
					var decoupe = $('decoupe_{/literal}{$image->id}{literal}');
					var nx      = $('nx_{/literal}{$image->id}{literal}');
					var ny      = $('ny_{/literal}{$image->id}{literal}');
					var width   = {/literal}{$image->width * $ppo->MULTIPLICATEUR}{literal};
					var height  = {/literal}{$image->height * $ppo->MULTIPLICATEUR}{literal};
					
					decoupe.setStyles ({
						'width'  : width+'px',
						'height' : height+'px'
					});
					
					var redim = function () {
						var nx      = parseInt ($('nx_{/literal}{$image->id}{literal}').value, 10);
						var ny      = parseInt ($('ny_{/literal}{$image->id}{literal}').value, 10);
						var width   = {/literal}{$image->width}{literal};
						var height  = {/literal}{$image->height}{literal};
						var decoupe = $('decoupe_{/literal}{$image->id}{literal}');
						var multiplicateur ={/literal}{$ppo->MULTIPLICATEUR}{literal};
						var bgview   = $('bgview_{/literal}{$image->id}{literal}');
						
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
									'style':'width:15px; height:15px; border:1px solid #000; background-color:{/literal}{$image->pixels[0]}{literal};'
								});
								
								tdBg.inject (trBg);
								var input = new Element ('input', {
									'type':'hidden',
									'name':'backgroundcolor['+(j+i*nb_x)+']',
									'value':'{/literal}{$image->pixels[0]}{literal}'
								});
								input.inject (tdBg);
								
								(function (tdBg, input) {
									td.addEvent ('click', function (e) {
										
										var image = {/literal}{$image|json_encode}{literal};
										var x = e.page.x - this.getParent ().getParent ().getPosition ().x;
										var y = e.page.y - this.getParent ().getParent ().getPosition ().y;
										var multiplicateur = {/literal}{$ppo->MULTIPLICATEUR}{literal};
										var bgview   = $('bgview_{/literal}{$image->id}{literal}');
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


					// {/literal}
					//-->
				</script>
				
			</td>
			
		{/foreach}
	</tr>
</table>