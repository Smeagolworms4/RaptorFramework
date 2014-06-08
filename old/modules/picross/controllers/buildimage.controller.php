<?php

/**
 * Picross
 **/
class BuildImageActionController extends ActionController {
	
	
	/**
	 * Page initial du framework
	 * @return RaptorActionReturn
	 */
	public function processDefault () {
		
		$images = array();
		$names = array();
		$mydir = _ioClass ('RaptorContext')->currentModulePath ().DATAS_DIR.'/images/';
		$i = 0;
		
		if ($dir = @opendir($mydir))  {
			while (($file = readdir($dir)) !== false) {
				if(strpos($file, '.bmp') !== false) {
		
					$names[] = $file;
		
					$image       = new stdClass();
					$image->id   = ++$i;
					$image->link = $file;
					$im = new Imagick();
					$im->readImage ($mydir.$file);
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

		$ppo = new RaptorPPO ();
		
		$ppo->MULTIPLICATEUR = 8;
		$ppo->images = $images;
		
		return _arSmarty ($ppo, 'buildimage/list.tpl');
	}
	
	function processGetImage () {
		RaptorRequest::assert ('i');
		
		$i = _request ('i');
		$i =  preg_replace("[^A-Z0-9\ _.\-]", "_", $i);
		

		header('Content-type: image/bmp');
		
		$file = _ioClass ('RaptorContext')->currentModulePath ().DATAS_DIR.'/images/'.$i;
		
		if (file_exists ($file)) {
			echo file_get_contents ($file);
		}
		return _arNone ();
	}
	

	function processBuild () {

		RaptorRequest::assert ('link');
		RaptorRequest::assert ('backgroundcolor');
		RaptorRequest::assert ('g_width');
		RaptorRequest::assert ('g_height');
		
		$link =_request ('link');
		
		$im = new Imagick();
		$im->readImage (_ioClass ('RaptorContext')->currentModulePath ().DATAS_DIR.'/images/'.$link);
		$images = array();
		$width = NULL;
		$height = NULL;
		$g_width = _request ('g_width');
		$g_height = _request ('g_height');
		
		foreach ($im->getPixelIterator() as $row=>$lignePixels ) {
			foreach ( $lignePixels as $column => $pixel ) {
				
				$numLigne = $row / $g_width;
				$numCol = $column / $g_height;
				if (!isset ($images[$numLigne])) {
					$images[$numLigne] = array ();
				}
				if (!isset ($images[$numLigne][$numCol])) {
					$images[$numLigne][$numCol] = array ();
				}
				
				$width = $column;
				$height = $row;
		
				$p = $pixel->getColor();
				$pixelHex = strtoupper (
					'#'.
					str_pad(dechex($p['r']), 2, '0', STR_PAD_LEFT).
					str_pad(dechex($p['g']), 2, '0', STR_PAD_LEFT).
					str_pad(dechex($p['b']), 2, '0', STR_PAD_LEFT)
				);
				$images[$numLigne][$numCol][] = $pixelHex;
			}
		}
		$width++;
		$height++;
		
		$background = _request ('backgroundcolor');
		
		$obj = new stdClass ();
		$obj->width = $width;
		$obj->height = $height;
		$obj->images = $images;
		$obj->backgroundcolor = $background;
		$obj->g_width = $g_width;
		$obj->g_height = $g_height;
		
		
		
		$out = _ioClass ('RaptorContext')->currentModulePath ().WWW_DIR.'/datas/'.substr ($link, 0, strlen($link) - 4).'.json';
		
		file_put_contents ($out, json_encode($obj));
		@chmod ($out, 0777);
		
		$ppo = new RaptorPPO ();
		$ppo->name = $link;
		
		return _arDirectSmarty ($ppo, 'buildimage/build.tpl');
	}
	
}