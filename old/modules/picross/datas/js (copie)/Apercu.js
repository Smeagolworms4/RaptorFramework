Picross.Apercu = new Class ({

	grille: null,
	grilleApercu: null,
	listTdApercu: [],
	
	DOMContener: null,
	
	/**
	 * Constructeur
	 * @param Grille grille
	 */
	initialize: function (grille, DOMContener) {
		this.grille = grille;
		this.DOMContener = DOMContener;
		this.createDOMElement();
	},
	
	/**
	 * Cree l'objet table dans la dom
	 */
	createDOMElement: function () {
		this.grilleApercu = new Element ('table', {
			'class':'apercu_picross'
		});
		for (var i = 0; i < this.getGrille().getHeight(); i++) {
			var tr = new Element ('tr');
			for (var j = 0; j < this.getGrille().getWidth(); j++) {
				var td = new Element ('td');
				td.setStyle ('background-color', this.getGrille ().getBackgroundColor ());
				if (!this.listTdApercu[j]) {
					this.listTdApercu[j] = [];
				}
				this.listTdApercu[j][i] = td;
				td.inject (tr);
			}
			tr.inject (this.grilleApercu);
		}
		
		this.grilleApercu.inject (this.DOMContener);
	},
	
	/**
	 * Renvoie le td ciblé
	 * @param int x
	 * @param int y
	 * @return DOM
	 */
	getDOMTd: function (x, y) {
		return this.listTdApercu[x][y];
	},
	
	/**
	 * Renvoie la grille selectionné
	 * @return Picross.Grille
	 */
	getGrille: function () {
		return this.grille;
	}
});
