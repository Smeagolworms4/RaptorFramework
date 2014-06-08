Picross.Cellule = new Class ({
	
	ligne: null,
	pixel: null,
	td: null,
	currentColor:null,
	numCell:null,
	
	/**
	 * Constructeur
	 * @param Picross.Ligne ligne
	 * @param []    pixel
	 * @param int   numCell
	 */
	initialize: function (ligne, pixel, numCell) {
		this.ligne   = ligne;
		this.pixel   = pixel;
		this.numCell = numCell;
		
		this.createDOMElement();
		
	},
	
	/**
	 * Renvoie l'objet DOM
	 * @return DOM
	 */
	getDOMElement: function () {
		return this.td;
	},
	
	/**
	 * Renvoie le numero de la cellule
	 * @return int
	 */
	getNum: function () {
		return this.numCell;
	},

	/**
	 * Renvoie la ligne parente
	 * @return Ligne
	 */
	getParent: function () {
		return this.ligne;
	},

	/**
	 * Renvoie couleur courrante
	 * @return string
	 */
	getCurrentColor: function () {
		return this.currentColor;
	},
	
	/**
	 * Renvoie la couleur du pixel
	 * @return string
	 */
	getPixel: function () {
		return this.pixel;
	},
	
	/**
	 * Crée l'élément DOM
	 */
	createDOMElement: function () {
		var _this = this;
		this.td = new Element ('td');
		this.selector = new Element ('div', {
			'style':'width:100%; height:100%;',
			'class':'selector_picross'
		});
		this.selector.cellulePicross = this;
		this.selector.inject (this.td);
		var firstTd = null;
		
		var actionStart = function (e) {
			
			var grille = _this.getLigne ().getGrille ();
			
			if (grille.getMetaGrille ().isModeGrille ()) {
				
				e.preventDefault ();
				e.stop ();
				e.stopPropagation ();
				
				$('debug').innerHTML = 'start';
			}
//			var cGrille = thisObject.getLigne ().getGrille ();
//			var sGrille = thisObject.getLigne ().getGrille ().getMetaGrille ().getGrilleSelected ();
//			if (sGrille && sGrille.getNum () == cGrille.getNum ()) {
//				$$('.selector_picross').each (function (el) {
//					el.removeClass ('selector_picross_selected');
//				});
//				thisObject.selector.addClass ('selector_picross_selected');
//				
//				thisObject.getLigne ().getGrille ().cellSelector = thisObject;
//			}
		};
		

		var actionMove = function (e) {
			
			var grille = _this.getLigne ().getGrille ();
			
			if (grille.getMetaGrille ().isModeGrille ()) {
				
				e.preventDefault ();
				e.stop ();
				e.stopPropagation ();
				
				$('debug2').innerHTML = 'move';
			}
		};

		var actionEnd = function (e) {

			var grille = _this.getLigne ().getGrille ();
			
			if (grille.getMetaGrille ().isModeGrille ()) {
				
				e.preventDefault ();
				e.stop ();
				e.stopPropagation ();

				$('debug') .innerHTML = 'end';
				$('debug2').innerHTML = 'end';
			}
		};

//		this.selector.addEvent ('mousedown' , function (e) { actionStart (e); });
//		this.selector.addEvent ('mousemove' , function (e) { actionMove  (e); });
//		this.selector.addEvent ('mouseup'  , function (e) { actionEnd   (e); });
//		
		
		if (!window.talala) {
			window.talala = 1;
			this.selector.addEvent ('touchstart' , function (e) { actionStart (e); });
			this.selector.addEvent ('touchmove' , function (e) { actionMove  (e); });
			this.selector.addEvent ('touchend'  , function (e) { actionEnd   (e); });
			
			document.body.addEvent ('touchstart' , function (e) { actionStart (e); });
			document.body.addEvent ('touchmove' , function (e) { actionMove  (e); });
			document.body.addEvent ('touchend'  , function (e) { actionEnd   (e); });
		}
//		
//		this.selector.addEvent ('touchmove', function () { /*actionDown ();*/ });
		
//		this.selector.addEvent ('mouseover', function () {
//			var cGrille = thisObject.getLigne ().getGrille ();
//			var sGrille = thisObject.getLigne ().getGrille ().getMetaGrille ().getGrilleSelected ();
//			if (sGrille && sGrille.getNum () == cGrille.getNum ()) {
//				var selector = thisObject.getLigne ().getGrille ().cellSelector;
//				
//				if (selector) {
//	
//					var x1 = selector.getNum ();
//					var y1 = selector.getLigne().getNum ();
//					var x2 = thisObject.getNum ();
//					var y2 = thisObject.getLigne().getNum ();
//					if (x1 > x2) {
//						x2 = selector.getNum ();
//						x1 = thisObject.getNum ();
//					}
//					if (y1 > y2) {
//						y2 = selector.getLigne().getNum ();
//						y1 = thisObject.getLigne().getNum ();
//					}
//					
//					$$('.selector_picross').each (function (el) {
//						el.removeClass ('selector_picross_selected');
//					});
//					for (var i = x1; i <= x2; i++) {
//						for (var j = y1; j <= y2; j++) {
//							thisObject.getLigne ().getGrille ().getCellule (i, j).selector.addClass ('selector_picross_selected');
//						}
//					}
//				}
//			}
//		});
		
		
		this.selector.onselectstart = new Function ("return false");
		if(window.sidebar){
			this.selector.onmousedown = function () { return false; };
			this.selector.onclick = function () { return true; };
		}
		
		this.td.inject (this.ligne.getDOMElement());
		
	},
	
	/**
	 * affecte une couleur
	 * @param string color
	 */
	setColor: function (color) {
		color = (color !== undefined) ? color : null;
		this.currentColor = color;
		this.getDOMElement().setStyle('background-color', color);
		
		// Affiche la valeur sellectionn dans l'apercu
		var tdApercu = this.getLigne ().getGrille ().getApercu ().getDOMTd (this.getNum (), this.getLigne ().getNum ());
		
		if (color) {
			tdApercu.setStyle ('background-color', color);
		} else {
			tdApercu.setStyle ('background-color', this.getLigne ().getGrille ().getBackgroundColor ());
		}
	},
	
	/**
	 * Révèle la cellule
	 */
	reveal: function (){
		this.setColor(this.pixel);
	},
	
	/**
	 * Return la ligne de la cellule
	 * @return Picross.Ligne
	 */
	getLigne: function () {
		return this.ligne;
	},
	
	/**
	 * renvoie si la pixel sellectioné est bonne
	 * @return bool
	 */
	isGood: function () {
		if (this.pixel == this.getLigne ().getGrille ().getBackgroundColor () && !this.currentColor) {
			return true;
		}
		return this.pixel == this.currentColor;
	},
	
	/**
	 * Test si la cellule est de la couleur du background
	 * @return bool
	 */
	isBackground: function () {
		return this.pixel == this.getLigne().getGrille().getBackgroundColor ();
	}
	
});
