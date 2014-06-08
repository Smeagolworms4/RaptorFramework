Picross.Grille = new Class ({
	
	contenerDOM: null,
	metagrille: null,
	image: null,
//	table: null,
//	lignes: [],
//	panel:null,
//	apercu:null,
//	cellSelector:null,
//	validLigne:[],
//	validCollonne:[],
//	instructionLigne:[],
//	instructionColonne:[],
	num: null,
//	
	/**
	 * Constructeur
	 * @param MetaGrille metaGrille
	 * @param {}         image
	 * @param int        num
	 */
	initialize: function (metaGrille, contenerDOM, image, num) {
		this.image       = image;
		this.metaGrille  = metaGrille;
		this.contenerDOM = contenerDOM;
		this.num         = num;
		
		this.createDOMElement();
	},
//	
//	/**
//	 * Renvoie le numero de la grille
//	 * @return int
//	 */
//	getNum: function () {
//		return this.num;
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
//	 * Retourne de la metagrille
//	 * @return MetaGrille
//	 */
//	getMetaGrille: function () {
//		return this.metaGrille;
//	},
//	
//	/**
//	 * Cree l'objet table dans la dom
//	 */
//	createDOMElement: function () {
//		
//		var thisObject = this;
//		
//		this.table = new Element ('table', {'class': 'table_picross'});
//		
//		for (var i = 0; i < this.getHeight(); i++){
//			this.addLigne(i);
//		}
//		
//		this.createDOMInstruction();
//		
//		window.addEvent ('mouseup', function (e) {
//			
//			var sGrille = thisObject.getMetaGrille ().getGrilleSelected ();
//			if (sGrille && sGrille.getNum () == thisObject.getNum ()) {
//				
//				$$('.selector_picross_selected').each (function (el) {
//					el.removeClass ('selector_picross_selected');
//					var cellulePicross = el.cellulePicross;
//					var color = cellulePicross.getLigne ().getGrille ().getPanel ().getSelected ();
//					if (color == 'cancel') {
//						cellulePicross.setColor(null);
//					} else{
//						cellulePicross.setColor(color);
//					}
//					
//					thisObject.instructionHInfo (cellulePicross.getLigne ().getNum ());
//					thisObject.instructionVInfo (cellulePicross.getNum ());
//				});
//				
//				thisObject.cellSelector = null;
//				
//				if (thisObject.isGood ()) {
//					thisObject.reveal ();
//				}
//				thisObject.getMetaGrille().fireEvent ('change');
//			}
//		});
//		
//		this.table.inject (this.contenerDOM);
//		
//		this.panel = new Picross.Panel(this);
//	},
//	
//	/**
//	 * Cree les elements html d'information de la grille
//	 */
//	createDOMInstruction: function (){
//		
//		var thisObject = this;
//		
//		var createNumInst = function (th, color, number) {
//			
//			// SI
//		    // 0.3*(decimal[rouge]) + 0.59*(decimal[vert]) + 0.11*(decimal[bleu])
//			// EST INFERIEUR OU EGAL A 128
//			// couleur_de_texte = #FFFFFF;
//			// SINON
//			// couleur_de_texte = #000000;
//			
//			if (color != thisObject.getBackgroundColor()) {
//				
//				var r = parseInt(color.substr (1,2), 16);
//				var v = parseInt(color.substr (3,2), 16);
//				var b = parseInt(color.substr (5,2), 16);
//				
//				var blanc = (0.3*r + 0.59*v + 011*b) < 128;
//				
//				var span = new Element ('span', {
//					'html': number,
//					'class':'number_picross',
//					'style':'color:'+((blanc) ? '#FFF': '#000')
//				});
//				span.setStyle('background-color', color);
//				span.inject (th);
//			}
//		};
//		
//		// Insertion horizontale
//		for (var i = 0; i < this.getHeight(); i++) {
//			var th = new Element ('th', {'class': 'instruction_picross horizontal'});
//			
//			var color = null;
//			var nbColor = 0;
//			for (var j = 0; j < this.getWidth(); j++) {
//				
//				if (color === null) {
//					color = this.getCellule(j, i).getPixel ();
//				}
//				if (color == this.getCellule(j, i).getPixel ()) {
//					nbColor++;
//				} else {
//					var instruction = { 'nb':nbColor, 'color':color };
//					if (!this.instructionLigne[i]) { this.instructionLigne[i] = []; }
//					this.instructionLigne[i].push (instruction);
//					createNumInst (th, color, nbColor);
//					color = this.getCellule(j, i).getPixel ();
//					nbColor = 1;
//				}
//			}
//			var instruction = { 'nb':nbColor, 'color':color };
//			if (!this.instructionLigne[i]) { this.instructionLigne[i] = []; }
//			this.instructionLigne[i].push (instruction);
//			createNumInst (th, color, nbColor);
//
//			var span = new Element ('span', {
//				'class':'valid_picross'
//			});
//			this.validLigne.push (span);
//			span.inject (th);
//			
//			th.inject (this.getLigne(i).getDOMElement(), 'top');
//		}
//		
//		// Insertion verticale
//		var tr = new Element ('tr');
//		var tdEmpty = new Element ('td', {'class':'instruction_picross empty'});
//		this.apercu = new Picross.Apercu (this, tdEmpty);
//		tdEmpty.inject (tr);
//		
//		for (var i = 0; i < this.getWidth(); i++) {
//			var th = new Element ('th', {'class': 'instruction_picross vertical'});
//			
//			var color = null;
//			var nbColor = 0;
//			for (var j = 0; j < this.getHeight(); j++) {
//				if (color === null) {
//					color = this.getCellule(i, j).getPixel ();
//				}
//				if (color == this.getCellule(i, j).getPixel ()) {
//					nbColor++;
//				} else {
//					var instruction = { 'nb':nbColor, 'color':color };
//					if (!this.instructionColonne[i]) { this.instructionColonne[i] = []; }
//					this.instructionColonne[i].push (instruction);
//					createNumInst (th, color, nbColor);
//					color = this.getCellule(i, j).getPixel ();
//					nbColor = 1;
//				}
//				
//			}
//			var instruction = { 'nb':nbColor, 'color':color };
//			if (!this.instructionColonne[i]) { this.instructionColonne[i] = []; }
//			this.instructionColonne[i].push (instruction);
//			createNumInst (th, color, nbColor);
//			
//			var span = new Element ('span', {
//				'class':'valid_picross'
//			});
//			this.validCollonne.push (span);
//			span.inject (th);
//			
//			th.inject (tr);
//		}
//		
//		tr.inject (this.getDOMElement (), 'top');
//	},
//	
//	/**
//	 * Renvoi la liste des couleur
//	 * @return []
//	 */
//	getListColors: function () {
//		return this.image.pixels.unique();
//	},
//	
//	/**
//	 * Ajoute une ligne
//	 * @param int numLigne
//	 */
//	addLigne: function (numLigne){
//		var pixels = [];
//		for (var i = 0; i < this.getWidth(); i++) {
//			pixels.push (this.image.pixels[i+this.lignes.length*this.getWidth()]);
//		}
//		
//		var ligne = new Picross.Ligne(this, pixels, numLigne);
//		this.lignes.push (ligne);
//	},
//	
//	/**
//	 * Revele la grille
//	 */
//	reveal: function () {
//		this.lignes.each (function (ligne) {
//			ligne.reveal();
//		});
//		this.getDOMElement ().getElements ('.valid_picross').each (function (el) {
//			el.removeClass ('error');
//			el.addClass ('valid');
//		});
//	},
//	
//	/**
//	 * Renvoie une ligne par sa positon
//	 * @param int y Position
//	 * @return Picross.Ligne
//	 */
//	getLigne: function (y) {
//		return this.lignes[y];
//	},
//	
//	/**
//	 * Renvoie une cellule par ses coordonnees
//	 * @param int x Position x
//	 * @param int y Position y
//	 * @return Picross.Cellule
//	 */
//	getCellule: function (x, y) {
//		return this.getLigne (y).getCellule (x);
//	},
//	
//	/**
//	 * Renvoie la couleur de fond
//	 * @return string
//	 */
//	getBackgroundColor: function (){
//		return this.image['backgroundcolor'];
//	},
//	
//	/**
//	 * Renvoie la largeur de la grille
//	 * @return int
//	 */
//	getWidth: function (){
//		return this.image.width;
//	},
//	
//	/**
//	 * Renvoie la hauteur de la grille
//	 * @return int
//	 */
//	getHeight: function (){
//		return this.image.height;
//	},
//	
//	/**
//	 * Return le panel de la grille
//	 * @return Picross.Panel
//	 */
//	getPanel: function () {
//		return this.panel;
//	},
//	
//	/**
//	 * renvoie si la grille est bonne
//	 * @return bool
//	 */
//	isGood: function () {
//		var good = true;
//		for (var i = 0; i < this.getWidth(); i++) {
//			for (var j = 0; j < this.getHeight(); j++) {
//				var c = this.getCellule(i, j);
//				if (!c.isGood()) {
//					good = false;
//					break;
//				}
//			}
//		}
//		
//		return good;
//	},
//	
//	/**
//	 * Retourne l'objet d'apercu
//	 * @return Picross.Apercu
//	 */
//	getApercu: function () {
//		return this.apercu;
//	},
//	
//	/**
//	 * Affiche si la ligne est bonne ou pas
//	 * @param int num
//	 */
//	instructionHInfo: function (num) {
//		
//		var instructionPt = this.instructionLigne[num];
//		
//		var thisObject = this;
//		var j = 0;
//		var instruction = [];
//		var list = [];
//		var totalInst = 0;
//		var totalColor = 0;
//		
//		instructionPt.each (function (el) {
//			if (el.color != thisObject.getBackgroundColor()) {
//				instruction.push (el);
//				totalInst = totalInst + el.nb;
//			}
//		});
//		
//		
//		for (var i = 0; i < this.getWidth (); i++) {
//			var c = this.getCellule (i, num);
//			
//			if (c.getCurrentColor () == null || c.getCurrentColor () == this.getBackgroundColor()) {
//				if (list[j]) {
//					j++;
//				}
//				continue;
//			}
//			if (list[j] && list[j].color != c.getCurrentColor ()) {
//				j++;
//			}
//			if (!list[j]) {
//				list[j] = {'nb':0, 'color':c.getCurrentColor ()};
//			}
//			list[j].nb++;
//			
//		}
//		
//		var trouver = true;
//		var i = 0;
//		for (i; i < instruction.length; i++) {
//			if (
//				!list[i] || 
//				instruction[i].color != list[i].color ||
//				instruction[i].nb != list[i].nb
//			) {
//				trouver = false;
//			}
//		}
//		if (list[i]) {
//			trouver = false;
//		}
//		for (var i = 0; i < list.length; i++) {
//			totalColor = totalColor + list[i].nb;
//		}
//		
//		this.validLigne[num].removeClass ('error');
//		this.validLigne[num].removeClass ('valid');
//		
//		if (trouver) {
//			this.validLigne[num].addClass ('valid');
//		} else if (totalColor > totalInst) {
//			this.validLigne[num].addClass ('error');
//		}
//		
//	},
//	
//	/**
//	 * Affiche si la colonne est bonne ou pas
//	 * @param int num
//	 */
//	instructionVInfo: function (num) {
//		
//		var instructionPt = this.instructionColonne[num];
//		
//		var thisObject = this;
//		var j = 0;
//		var instruction = [];
//		var list = [];
//		var totalInst = 0;
//		var totalColor = 0;
//		
//		instructionPt.each (function (el) {
//			if (el.color != thisObject.getBackgroundColor()) {
//				instruction.push (el);
//				totalInst = totalInst + el.nb;
//			}
//		});
//		
//		
//		for (var i = 0; i < this.getHeight (); i++) {
//			var c = this.getCellule (num, i);
//			
//			if (c.getCurrentColor () == null || c.getCurrentColor () == this.getBackgroundColor()) {
//				if (list[j]) {
//					j++;
//				}
//				continue;
//			}
//			if (list[j] && list[j].color != c.getCurrentColor ()) {
//				j++;
//			}
//			if (!list[j]) {
//				list[j] = {'nb':0, 'color':c.getCurrentColor ()};
//			}
//			list[j].nb++;
//			
//		}
//		
//		var trouver = true;
//		var i = 0;
//		for (i; i < instruction.length; i++) {
//			if (
//				!list[i] || 
//				instruction[i].color != list[i].color ||
//				instruction[i].nb != list[i].nb
//			) {
//				trouver = false;
//			}
//		}
//		if (list[i]) {
//			trouver = false;
//		}
//		for (var i = 0; i < list.length; i++) {
//			totalColor = totalColor + list[i].nb;
//		}
//		
//		this.validCollonne[num].removeClass ('error');
//		this.validCollonne[num].removeClass ('valid');
//		
//		if (trouver) {
//			this.validCollonne[num].addClass ('valid');
//		} else if (totalColor > totalInst) {
//			this.validCollonne[num].addClass ('error');
//		}
//	}
	
});
