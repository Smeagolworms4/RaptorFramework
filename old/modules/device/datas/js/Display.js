var Display = new Class ({
	
	/**
	 * Redimentionne le div à la taille de l'écran
	 * @param Element div
	 */
	resizeOnScreen: function (div) {
		div.setStyles ({
			'height': window.innerHeight+'px',
			'width': window.innerWidth+'px'
		});
	},
	
	adapteZoomContent: function (div, originalElementWidth, originalElementHeight) {
		
		var wh = window.innerHeight;
		var ww = window.innerWidth;
//		var dh = originalElementHeight;
//		var dw = originalElementWidth;
		var dh = div.getHeight();
		var dw = div.getWidth();
		var _this = this;
		
		if (wh && ww && dh && dw) {

			var ratioH = (parseFloat(wh, 10) / parseFloat(dh, 10));
			var ratioW = (parseFloat(ww, 10) / parseFloat(dw, 10));
			var ratio = (ratioH < ratioW) ? ratioH : ratioW;
			
			var marginleft = (dw * ratio - dw) / 2;
			var margintop  = (dh * ratio - dh) / 2;
			
			div.setStyles ({
				'margin-left' : marginleft+'px',
				'margin-top' : margintop+'px'
			});
			
			div.setScale(ratio, ratio);
			
		} else {
			setTimeout (function () {
				_this.adapteZoomContent (div)
			}, 200);
		}
		
		
	}
	
});

Display.instance = null;

/**
 * Renvoie l'instance d Display
 */
Display.getInstance = function () {
	if (!Display.instance) {
		Display.instance = new Display();
	}
	return Display.instance;
};