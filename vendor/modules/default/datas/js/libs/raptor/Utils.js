
/**
 * Change scale on Element
 * @param float scaleX
 * @param float scaleY
 */
Element.prototype.setScale = function (scaleX, scaleY) {

	this.setStyles ({
		'transform' : 'scale('+scaleX+', '+scaleY+')'
	});
	
	this.style.webkitTransform = 'scale('+scaleX+', '+scaleY+')';
};
