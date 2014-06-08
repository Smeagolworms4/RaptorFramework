<?php
	
	define ('MULTIPLICATEUR', 8);
	
	
	$images = array();
	$mydir = 'datas/';
	$i = 0;
	if ($dir = @opendir($mydir))  {
		while (($file = readdir($dir)) !== false) {
			if(strpos($file, '.json') !== false) {
				
				$images[] = substr ($file, 0, strlen($file) - 5);
			}
		}
		closedir($dir);
	}
	sort ($images);
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>PICROSS - Liste</title>
		
		<script type="text/javascript" src="js/mootools-core-1.4.5-full-nocompat.js"></script>
		<script type="text/javascript" src="js/mootools-more-1.4.0.1.js"></script>
		
	</head>
	<body>
		<ul>
			<?php 
			foreach ($images as $key=>$image) {
				?>
				<li><a href="picross.php?i=<?php echo $image; ?>" ><?php echo $image; ?></a></li>
				<?php 
			}
			?>
		</ul>
	</body>
</html>
