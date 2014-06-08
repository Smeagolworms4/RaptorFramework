<?php


$link = (isset ($_POST['link'])) ? $_POST['link'] : 'datas/apple.bmp';

$im = new Imagick(); 
$im->readImage( $link );
$pixels = array();
$width = NULL;
$height = NULL;
foreach ($im->getPixelIterator() as $row=>$lignePixels ) {
	foreach ( $lignePixels as $column => $pixel ) {
		
		$width = $column;
		$height = $row;
		
		$p = $pixel->getColor();
		$pixels[] = strtoupper (
			'#'. 
			str_pad(dechex($p['r']), 2, '0', STR_PAD_LEFT).
			str_pad(dechex($p['g']), 2, '0', STR_PAD_LEFT).
			str_pad(dechex($p['b']), 2, '0', STR_PAD_LEFT)
		);
	}
}
$width++;
$height++;

$background = (isset ($_POST['backgroundcolor'])) ? $_POST['backgroundcolor'] : $pixels[0];

$obj = new stdClass ();
$obj->width = $width;
$obj->height = $height;
$obj->pixels = $pixels;
$obj->backgroundcolor = $background;
$obj->g_width =  (isset ($_POST['g_width'])) ? $_POST['g_width'] : $width;
$obj->g_height =  (isset ($_POST['g_height'])) ? $_POST['g_height'] : $height;

//print_r ( json_encode($obj) );

file_put_contents (substr ($link, 0, strlen($link) - 4).'.json', json_encode($obj));

?>
fichier : <?php echo $link; ?> : <span style="background-color:#0F0;" >Good</span>