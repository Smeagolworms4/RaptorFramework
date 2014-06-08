Picross.MetaGrille = new Class ({

	contenerDOM: null,
	metaImage: null,
//	table: null,
//	divGrilleCurrent: null,
//	grilleSelected: null,
//	grilles: [],
//	listeners: [],
//	
	/**
	 * Constructeur
	 * @param DOM contenerDOM
	 * @param {}  metaImage
	 */
	initialize: function (contenerDOM, metaImage) {
		this.contenerDOM = contenerDOM;
		this.metaImage = metaImage;
	},
	
//	
//	/**
//	 * ajoute un l'événement à l'objet
//	 * @param string   name Nom de l'événement
//	 * @param function fc   Callback
//	 */
//	addEvent: function (name, fc) {
//		if (!this.listeners[name]) {
//			this.listeners[name] = [];
//		}
//		this.listeners[name].push (fc);
//	},
//	
//	/**
//	 * Effectue un l'événement
//	 * @param name Nom de l'événement
//	 */
//	fireEvent: function (name) {
//		if (this.listeners[name]) {
//			for (var i = 0; i < this.listeners[name].length; i++) {
//				var listener = this.listeners[name][i];
//				if (listener && typeOf (listener) == 'function') {
//					listener();
//				}
//			}
//		}
//	},
//	
//	/**
//	 * Renvoie l'objet DOM conteneur
//	 * @return DOM
//	 */
//	getDOMElement: function () {
//		return this.table;
//	},
//	
//	/**
//	 * Renvoie l'objet DOM
//	 * @return DOM
//	 */
//	getDOMContener: function () {
//		return this.contenerDOM;
//	},
//	
//	/**
//	 * Renvoie la grille urilisé
//	 * @return Picross.Grille
//	 */
//	getGrilleSelected: function () {
//		return this.grilleSelected;
//	},
//	
//	/**
//	 * Renvoie la grille
//	 * @param int num Numero de grille
//	 * @return Picross.Grille
//	 */
//	getGrille: function (num) {
//		return this.grilles[num];
//	},
//	
	/**
	 * Renvoie le nombre de grilles
	 * @return int
	 */
	getSize: function (num) {
		return this.grilles.length;
	},
//	
//	/**
//	 * Renvoie true si on est en mode grille
//	 * @return bool
//	 */
//	isModeGrille: function () {
//		return this.grilleSelected !== null;
//	},
//	
//	/**
//	 * Revien en mode Groupe
//	 */
//	modeGroupe: function () {
//		if (!this.isModeGrille ()) {
//			this.grilleSelected.getDOMElement ().inject (this.grilleSelected.getDOMContener ());
//			this.grilleSelected.getPanel ().getDOMElement ().inject (this.grilleSelected.getDOMContener ());
//		}
//		this.grilleSelected = null;
//		this.getDOMContener ().removeClass ('selected_grille_picross');
//	},
//	
//	/**
//	 * Cree l'objet table dans la dom
//	 */
//	createDOMElement: function () {
//		
//		this.divGrilleCurrent = new Element ('div');
//		this.divGrilleCurrent.inject (this.contenerDOM);
//		
//		this.table = new Element ('table', {
//			'class': 'metaimage_picross'
//		});
//		
//		var g_width = parseInt (this.metaimage.g_width, 10);
//		var g_height = parseInt (this.metaimage.g_height, 10);
//		var width = parseInt (this.metaimage.width, 10);
//		var height = parseInt (this.metaimage.height, 10);
//		var nb_x = parseInt (Math.ceil(width/g_width), 10);
//		var nb_y = parseInt (Math.ceil(height/g_height), 10);
//		var thisObject = this;
//		
//		var image = [];
//		var numPix = 0;
//		
//		for (var i = 0; i < height; i++) {
//			for (var j = 0; j < width; j++) {
//				if (!image[i]) {
//					image[i] = [];
//				}
//				image[i][j] = this.metaimage.pixels[numPix];
//				numPix++;
//				
//			}
//		}
//		
//		var imagePicross = [];
//		var numIP = 0;
//
//		for (var j = 0; j < nb_y; j++) {
//			for (var i = 0; i < nb_x; i++) {
//				
//				var img = [];
//				for (var jj = 0; jj < g_height; jj++) {
//					for (var ii = 0; ii < g_width; ii++) {
//					
//						var y = (ii + (i * g_width));
//						var x = (jj + (j * g_height));
//						
//						if (!image[x] || !image[x][y]) {
//							if (!image[x]) {
//								image[x] = [];
//							}
//							image[x][y] = this.metaimage.backgroundcolor[numIP];
//						}
//						img.push (image[x][y]);
//					}
//				}
//				imagePicross.push (img);
//				numIP++;
//			}
//		}
//		
//		numIP = 0;
//		for (var j = 0; j < nb_y; j++) {
//			var tr = new Element ('tr');
//			for (var i = 0; i < nb_x; i++) {
//				var td = new Element ('td');
//				
//				var image = {};
//				
//				image.backgroundcolor = this.metaimage.backgroundcolor[numIP];
//				image.width = parseInt (g_width, 10);
//				image.height = parseInt (g_height, 10);
//				image.pixels = imagePicross[numIP];
//				
//				var grille = new Picross.Grille (this, td, image, this.grilles.length);
//				this.grilles.push(grille);
//				
//				(function (td, grille) {
//					td.addEvent ('click', function () {
//						grille.getDOMElement ().inject (thisObject.divGrilleCurrent);
//						grille.getPanel ().getDOMElement ().inject (thisObject.divGrilleCurrent);
//						
//						thisObject.getDOMContener ().addClass ('selected_grille_picross');
//						
//						thisObject.grilleSelected = grille;
//					});
//				})(td, grille);
//				
//				td.inject (tr);
//				
//				numIP++;
//			}
//			tr.inject (this.table);
//		}
//		
//		this.table.inject (this.contenerDOM);
//	}
});

