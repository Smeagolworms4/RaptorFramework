Picross.Panel = new Class ({
	
	grille: null,
	div: null,
	selected:null,
	
	/**
	 * Constructeur
	 * @param Picross.Grille grille
	 */
	initialize: function (grille) {
		this.grille = grille;
		this.createDOMElement();
	},
	
	/**
	 * Renvoi l'element DOM
	 * @return DOM
	 */
	getDOMElement: function () {
		return this.div;
	},
	
	/**
	 * Cree l'objet table dans la dom
	 */
	createDOMElement: function () {
		
		var thisObject = this;
		
		this.div = new Element ('div', {
			'class':'panel_picross'
		});

		var colors = this.grille.getListColors();
		var btBG = null;
		var btCancel = null;
		
		colors.push ('cancel');
		
		colors.each (function (color) {
			
			var bt = new Element ('div', {
				'class':'panel_color_picross'
			});
			
			if (color == 'cancel') {
				bt.addClass ('cancel_picross');
				btCancel = bt;
			} else {
				bt.setStyle ('background-color', color);
			}
			
			if (thisObject.grille.getBackgroundColor () == color) {
				bt.addClass ('selected_picross');
				thisObject.selected = color;
				btBG = bt;
			}
			
			bt.inject (thisObject.div, 'top');
			
			bt.addEvent ('click', function () {
				$$('.panel_color_picross').each (function (el) {
					el.removeClass ('selected_picross');
				});
				bt.addClass ('selected_picross');
				thisObject.selected = color;
			});
			
		});
		if (btBG) {
			btBG.inject (btCancel, 'after');
		}
		this.div.inject (this.grille.getDOMContener());
	},
	
	/**
	 * Renvoie la valeur selectionné
	 * @return string
	 */
	getSelected: function () {
		return this.selected;
	},
	
	/**
	 * Renvoie la grille selectionné
	 * @return Picross.Grille
	 */
	getGrille: function () {
		return this.grille;
	}
	
});
