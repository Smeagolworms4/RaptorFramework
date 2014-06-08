<?php
	
	define ('MULTIPLICATEUR', 8);
	
	
	$images = array();
	$names = array();
	$mydir = 'datas/';
	$i = 0;
	if ($dir = @opendir($mydir))  {
		while (($file = readdir($dir)) !== false) {
			if(strpos($file, '.bmp') !== false) {
				
				$names[] = $file;
				
				$image       = new stdClass();
				$image->id   = ++$i;
				$image->link = $file;
				$im = new Imagick(); 
				$im->readImage( 'datas/'.$file );
				$image->pixels = array();
				$image->width  = NULL;
				$image->height = NULL;
				foreach ($im->getPixelIterator() as $row=>$lignePixels ) {
					foreach ( $lignePixels as $column => $pixel ) {
						
						$image->width = $column;
						$image->height = $row;
						
						$p = $pixel->getColor();
						$image->pixels[] = strtoupper (
							'#'. 
							str_pad(dechex($p['r']), 2, '0', STR_PAD_LEFT).
							str_pad(dechex($p['g']), 2, '0', STR_PAD_LEFT).
							str_pad(dechex($p['b']), 2, '0', STR_PAD_LEFT)
						);
					}
				}
				$image->width++;
				$image->height++;
				
				$images[] = $image;
			}
		}
		closedir($dir);
	}
	
	array_multisort ($names, SORT_ASC, $images);
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>PICROSS - Convertion</title>
		
		<script type="text/javascript" src="js/mootools-core-1.4.5-full-nocompat.js"></script>
		<script type="text/javascript" src="js/mootools-more-1.4.0.1.js"></script>
		
		<script type="text/javascript">
			//<!--
			
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
				/*
				var w = form.getElements ('.g_width');
				var h = form.getElements ('.g_height');
				var vw = w[0].value;
				var vh = h[0].value;

				var request = new Request($('conv_'+id), $('result_'+id), {
					onSuccess: function () {
						w[0].value = vw;
						h[0].value = vh;
						console.log ('');
					}
				});
				request.send();
				*/
			};
			//-->
		</script>
		
	</head>
	<body>
		
		<table>
			<tr>
				<?php
				foreach ($images as $key=>$image) {
					if (! ($key % 3)) {
						?></tr><tr><?php 
					}
					?>
					<td style="border:1px solid #AAA; white-space: nowrap; " >
						<div style="margin-bottom: 10px;" >
							<div style="display: inline-block; position: relative;" >
								<div id="decoupe_<?php echo $image->id ?>" class="decoupe" style="position:absolute; top:0; left:0;" ></div>
								<img id="img_<?php echo $image->id ?>" src="datas/<?php echo $image->link; ?>" width="<?php echo ($image->width*MULTIPLICATEUR) ?>px" height="<?php echo ($image->height*MULTIPLICATEUR) ?>px" alt="<?php echo $image->link; ?>" />
							</div>
							<div style="display: inline-block;" >
								<form id="conv_<?php echo $image->id ?>" action="convertisseur.php" method="post" >
									<?php echo $image->link; ?><br />
									<input type="hidden" name="image" value="<?php echo $image->link; ?>" />
									<input type="hidden" name="link" value="datas/<?php echo $image->link; ?>" />
									
									background : <div id="bgview_<?php echo $image->id ?>" style="width:20px; height:15px;" ></div>
									<br />
									<div id="result_<?php echo $image->id ?>" ></div>
									
									
									x : <input id="nx_<?php echo $image->id ?>" type="text" value="<?php echo ($image->width); ?>" name="g_width" class="g_width" size="3" maxlength="3" /><br />
									y : <input id="ny_<?php echo $image->id ?>" type="text" value="<?php echo ($image->height); ?>" name="g_height" class="g_height" size="3" maxlength="3" /><br />
									<input type="button" value="convertir" onclick="convertir('<?php echo $image->id ?>')" />
								</form>
							</div>
							
							<script type="text/javascript">
								//<!--
								var decoupe = $('decoupe_<?php echo $image->id ?>');
								var nx      = $('nx_<?php echo $image->id ?>');
								var ny      = $('ny_<?php echo $image->id ?>');
								var width   = <?php echo ($image->width * MULTIPLICATEUR); ?>;
								var height  = <?php echo ($image->height * MULTIPLICATEUR); ?>;
								
								decoupe.setStyles ({
									'width'  : width+'px',
									'height' : height+'px'
								});
								
								var redim = function () {
									var nx      = parseInt ($('nx_<?php echo $image->id ?>').value, 10);
									var ny      = parseInt ($('ny_<?php echo $image->id ?>').value, 10);
									var width   = <?php echo $image->width; ?>;
									var height  = <?php echo $image->height; ?>;
									var decoupe = $('decoupe_<?php echo $image->id ?>');
									var multiplicateur = <?php echo MULTIPLICATEUR; ?>;
									var bgview   = $('bgview_<?php echo $image->id ?>');
									
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
												'style':'width:'+(nx*multiplicateur)+'px; height:'+(ny*multiplicateur)+'px; border:1px solid #000;'
											});
											td.inject (tr);
											
											var tdBg = new Element ('td', {
												'style':'width:15px; height:15px; border:1px solid #000; background-color:<?php echo $image->pixels[0]; ?>;'
											});
											
											tdBg.inject (trBg);
											var input = new Element ('input', {
												'type':'hidden',
												'name':'backgroundcolor['+(j+i*nb_x)+']',
												'value':'<?php echo $image->pixels[0]; ?>'
											});
											input.inject (tdBg);
											
											(function (tdBg, input) {
												td.addEvent ('click', function (e) {
													
													var image = <?php echo json_encode ($image); ?>;
													var x = e.page.x - this.getParent ().getParent ().getPosition ().x;
													var y = e.page.y - this.getParent ().getParent ().getPosition ().y;
													var multiplicateur = <?php echo MULTIPLICATEUR; ?>;
													var bgview   = $('bgview_<?php echo $image->id ?>');
													var ligne    = (parseInt(x/multiplicateur, 10));
													var collonne = (parseInt(y/multiplicateur, 10));
													
													var color = image.pixels [ligne + collonne*image.width];
													
													//$('bg_<?php echo $image->id ?>').value = color;
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
								
								//-->
							</script>
							
						</div>
					</td>
					<?php 
				}
				?>
			</tr>
		</table>
	</body>
</html>
