<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>PICROSS</title>
		
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/mootools-core-1.4.5-full-nocompat.js"></script>
		<script type="text/javascript" src="js/mootools-more-1.4.0.1.js"></script>
		<script type="text/javascript" src="js/picross.js"></script>
			
	</head>
	<body>
		<div id="metagrille" ></div>
		
		<br />
		<a href="index.php" onclick="return retour ();" ><input type="button" value="Retour" /></a>
		
		<script type="text/javascript">
			//<!--
			
			<?php 
				$file = ((isset ($_GET['i'])) ? $_GET['i'] : 'apple').'.json';
			?>
			var metagrille = null;
			var request = new Request.JSON({
				url:'datas/<?php echo $file; ?>',
				onSuccess: function (image) {
					
					var storage = new Storage ('<?php echo $file; ?>');
					
					metagrille = storage.restoreGrille ([$('metagrille'), image]);
					if (!metagrille) {
						metagrille = new MetaGrille ($('metagrille'), image);
					}
					
					metagrille.addEvent ('change', function () {
						// Enregiste la grille à chaque changement
						storage.saveGrille (metagrille);
					});
					
					console.log (metagrille);
				}
				
			});
			
			request.get();
			
			var retour = function () {
				if (!metagrille.isModeGrille ()) {
					metagrille.modeGroupe();
					return false;
				}
				return true;
			};
			//-->
		</script>
		
		
	</body>
</html>

