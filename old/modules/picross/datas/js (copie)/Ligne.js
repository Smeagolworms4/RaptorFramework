Picross.Ligne = new Class ({
	
	grille: null,
	tr: null,
	cellules: [],
	pixels: [],
	numLigne: null,
	
	
	/**
	 * Constructeur
	 * @param Picross.Grille grille
	 * @param []     pixels Tableau des couleurs de la ligne
	 */
	initialize: function (grille, pixels, numLigne) {
		this.grille = grille;
		this.pixels = pixels;
		this.numLigne = numLigne;
		
		this.createDOMElement();
		
		
	},
	
	/**
	 * Renvoie le numero de la ligne
	 * @return int
	 */
	getNum: function () {
		return this.numLigne;
	},
	
	/**
	 * Renvoie la taille de la ligne
	 * @return int 
	 */
	getWidth: function (){
		return this.pixels.length;
	},
	
	/**
	 * Renvoie l'objet DOM
	 * @return DOM
	 */
	getDOMElement: function () {
		return this.tr;
	},
	
	/**
	 * Renvoie la grille parente
	 * @return Picross.Grille
	 */
	getParent: function () {
		return this.grille;
	},
	
	/**
	 * Cree l'objet tr dans le table
	 */
	createDOMElement: function () {
		this.tr = new Element ('tr');
		
		for (var i = 0; i < this.getWidth(); i++){
			this.addCellule (i);
		}
		
		this.tr.inject (this.grille.getDOMElement());
	},
	
	/**
	 * Ajoute une cellule
	 * @param int num
	 */
	addCellule: function (num){
		var cellule = new Picross.Cellule(this, this.pixels[this.cellules.length], num);
		this.cellules.push (cellule);
	},
	
	/**
	 * Revèle la ligne
	 */
	reveal: function () {
		this.cellules.each (function (cellule) {
			cellule.reveal();
		});
	},
	
	/**
	 * Renvoie une celule par sa position
	 * @param int x Position
	 * @return Picross.Cellule
	 */
	getCellule: function (x) {
		return this.cellules[x];
	},

	/**
	 * Return la grille de la ligne
	 * @return Picross.Grille
	 */
	getGrille: function () {
		return this.grille;
	}
	
});
