var Serializer = new Class ({
	
	classType: null,
	
	/**
	 * Constructeur
	 * @param strig className
	 * @param mixed obj
	 */
	initialize: function (classType) {
		this.classType = classType;
	},
	
	/**
	 * Serialise un object
	 * @param obj
	 * @returns string
	 */
	serialize: function (obj) {
		
		var isDOM = function (obj) {
			if (!obj) {
				return false;
			}
			return $(obj) == obj;
		};

		var stockRecurssion = [];
		var stockRecurssionPtr = [];
		var stockPtr = 0;
		var stock = function (obj) {
			
			switch (typeof (obj)) {
				
				
				case 'function': 
					break;
				case 'undefined':
				case 'boolean':
				case 'string':
				case 'number':
					 stockPtr++;
					return obj;
				
				case 'object': 
					
					if (obj && !isDOM(obj)) {
						
						var numPtr = stockPtr++;
						var datas = {};
						
						trouver = false;
						for (var j = 0; j < stockRecurssion.length; j++) {
							if (stockRecurssion[j] == obj) {
								trouver = stockRecurssionPtr[j];
								break;
							}
						}
						
						if (trouver !== false) {
							datas = '{{{Serializer RECURSION:'+trouver+'}}}';
						} else {
							stockRecurssion.push (obj);
							stockRecurssionPtr.push (numPtr);
							for (var i in obj) {
								
								var data = stock (obj[i]);
								if (data !== null && data !== undefined) {
									datas[i] = data;
								}
							}
						}
						return datas;
					}
					break;
				
				default:
					console.log ('typeof : ' + typeof (obj));
			}
			
			return null;
			
			if (!obj) {
				return obj;
			}
		};
		
		return JSON.encode(stock (obj));
	},
	
	/**
	 * Deserialise un object
	 * @param string
	 * @param {} params parametres pour le reveille
	 * @returns obj
	 */
	unserialize: function (datas, params) {
		
		var json = JSON.decode(datas);
		var objCompile = [];
		var numObj = 0;
		var compile = function (json) {
			
			objCompile[numObj++] = json;
			
			switch (typeof (json)) {
				
				case 'function': 
				case 'undefined':
				case 'boolean':
				case 'number':
					return json;
				case 'string':
					
					if (json.substr (0, '{{{Serializer RECURSION:'.length) == '{{{Serializer RECURSION:') {
						var num = json.substr ('{{{Serializer RECURSION:'.length);
						num = num.substr (0, num.indexOf ('}}}'));
						
						return objCompile[num];
						
					}
					
					return json;
					
				case 'object': 
					var datas = {};
					objCompile[numObj-1] = datas;
					for (var i in json) {
						datas[i] = compile (json[i]);
					}
					return datas;
			}
			
			return json;
		};
		json = compile (json);
		
		if (this.classType.wakeUp) {
			return this.classType.wakeUp (json, params);
		}
		return null;
	}
	
});

var Storage = new Class ({
	
	/**
	 * Constructeur
	 * @param string namespace Espace d'enregistrement
	 */
	initialize: function (namespace) {
		this.namespace = namespace || '';
	},
	
	/**
	 * Sauvegarde la meta grille
	 */
	saveGrille: function (metagrille) {
		
		if (sessionStorage) {
			var serializer = new Serializer (MetaGrille);
			sessionStorage[this.namespace+'_metagrille'] = serializer.serialize (metagrille);
		}
	},
	
	/**
	 * Restore la meta grille
	 * @param {} params parametres pour le reveille
	 * @return mixed
	 */
	restoreGrille: function (params) {
		
		if (sessionStorage && sessionStorage[this.namespace+'_metagrille']) {
			var serializer = new Serializer (MetaGrille);
			return  serializer.unserialize (sessionStorage[this.namespace+'_metagrille'], params);
		}
		return null;
	}
	
	
});

var MetaGrille = new Class ({

	contenerDOM: null,
	metaimage: null,
	table: null,
	divGrilleCurrent: null,
	grilleSelected: null,
	grilles: [],
	listeners: [],
	
	/**
	 * Constructeur
	 * @param DOM contenerDOM
	 * @param {}  metaimage
	 */
	initialize: function (contenerDOM, metaimage) {
		this.contenerDOM = contenerDOM;
		this.metaimage = metaimage;
		
		this.createDOMElement();
	},
	
	/**
	 * ajoute un l'événement à l'objet
	 * @param string   name Nom de l'événement
	 * @param function fc   Callback
	 */
	addEvent: function (name, fc) {
		if (!this.listeners[name]) {
			this.listeners[name] = [];
		}
		this.listeners[name].push (fc);
	},
	
	/**
	 * Effectue un l'événement
	 * @param name Nom de l'événement
	 */
	fireEvent: function (name) {
		if (this.listeners[name]) {
			for (var i = 0; i < this.listeners[name].length; i++) {
				var listener = this.listeners[name][i];
				if (listener && typeOf (listener) == 'function') {
					listener();
				}
			}
		}
	},
	
	/**
	 * Renvoie l'objet DOM conteneur
	 * @return DOM
	 */
	getDOMElement: function () {
		return this.table;
	},
	
	/**
	 * Renvoie l'objet DOM
	 * @return DOM
	 */
	getDOMContener: function () {
		return this.contenerDOM;
	},
	
	/**
	 * Renvoie la grille urilisé
	 * @return Grille
	 */
	getGrilleSelected: function () {
		return this.grilleSelected;
	},
	
	/**
	 * Renvoie la grille
	 * @param int num Numero de grille
	 * @return Grille
	 */
	getGrille: function (num) {
		return this.grilles[num];
	},
	
	/**
	 * Renvoie le nombre de grilles
	 * @return int
	 */
	getSize: function (num) {
		return this.grilles.length;
	},
	
	/**
	 * Renvoie true si on est en mode grille
	 * @return bool
	 */
	isModeGrille: function () {
		return this.grilleSelected === null;
	},
	
	/**
	 * Revien en mode Groupe
	 */
	modeGroupe: function () {
		if (!this.isModeGrille ()) {
			this.grilleSelected.getDOMElement ().inject (this.grilleSelected.getDOMContener ());
			this.grilleSelected.getPanel ().getDOMElement ().inject (this.grilleSelected.getDOMContener ());
		}
		this.grilleSelected = null;
		this.getDOMContener ().removeClass ('selected_grille_picross');
	},
	
	/**
	 * Cree l'objet table dans la dom
	 */
	createDOMElement: function () {
		
		this.divGrilleCurrent = new Element ('div');
		this.divGrilleCurrent.inject (this.contenerDOM);
		
		this.table = new Element ('table', {
			'class': 'metaimage_picross'
		});
		
		var g_width = parseInt (this.metaimage.g_width, 10);
		var g_height = parseInt (this.metaimage.g_height, 10);
		var width = parseInt (this.metaimage.width, 10);
		var height = parseInt (this.metaimage.height, 10);
		var nb_x = parseInt (Math.ceil(width/g_width), 10);
		var nb_y = parseInt (Math.ceil(height/g_height), 10);
		var thisObject = this;
		
		var image = [];
		var numPix = 0;
		
		for (var i = 0; i < height; i++) {
			for (var j = 0; j < width; j++) {
				if (!image[i]) {
					image[i] = [];
				}
				image[i][j] = this.metaimage.pixels[numPix];
				numPix++;
				
			}
		}
		
		var imagePicross = [];
		var numIP = 0;

		for (var j = 0; j < nb_y; j++) {
			for (var i = 0; i < nb_x; i++) {
				
				var img = [];
				for (var jj = 0; jj < g_height; jj++) {
					for (var ii = 0; ii < g_width; ii++) {
					
						var y = (ii + (i * g_width));
						var x = (jj + (j * g_height));
						
						if (!image[x] || !image[x][y]) {
							if (!image[x]) {
								image[x] = [];
							}
							image[x][y] = this.metaimage.backgroundcolor[numIP];
						}
						img.push (image[x][y]);
					}
				}
				imagePicross.push (img);
				numIP++;
			}
		}
		
		numIP = 0;
		for (var j = 0; j < nb_y; j++) {
			var tr = new Element ('tr');
			for (var i = 0; i < nb_x; i++) {
				var td = new Element ('td');
				
				var image = {};
				
				image.backgroundcolor = this.metaimage.backgroundcolor[numIP];
				image.width = parseInt (g_width, 10);
				image.height = parseInt (g_height, 10);
				image.pixels = imagePicross[numIP];
				
				var grille = new Grille (this, td, image, this.grilles.length);
				this.grilles.push(grille);
				
				(function (td, grille) {
					td.addEvent ('click', function () {
						grille.getDOMElement ().inject (thisObject.divGrilleCurrent);
						grille.getPanel ().getDOMElement ().inject (thisObject.divGrilleCurrent);
						
						thisObject.getDOMContener ().addClass ('selected_grille_picross');
						
						thisObject.grilleSelected = grille;
					});
				})(td, grille);
				
				td.inject (tr);
				
				numIP++;
			}
			tr.inject (this.table);
		}
		
		this.table.inject (this.contenerDOM);
	}
});

/**
 * Reveille l'objet depuis une serialisation
 * @param datas liste des valeur
 * @param {} params parametres pour le reveille
 * @returns
 */
MetaGrille.wakeUp = function (datas, params) {
	
	var metagrille = new MetaGrille (params[0], params[1]);
	
	for (var numGrille =  0; numGrille < metagrille.getSize (); numGrille++) {
		var grille = metagrille.getGrille (numGrille);
		
		for (var i = 0; i < grille.getHeight (); i++) {
			for (var j = 0; j < grille.getWidth (); j++) {
				var c = grille.getCellule (j, i);
				
				if (
					datas.grilles[numGrille].lignes[i] && 
					datas.grilles[numGrille].lignes[i].cellules[j] &&
					datas.grilles[numGrille].lignes[i].cellules[j].currentColor
				) {
					c.setColor (datas.grilles[numGrille].lignes[i].cellules[j].currentColor);
				}
				
			}
		}
		
	}
	
	return metagrille;
};

var Grille = new Class ({
	
	contenerDOM: null,
	metagrille: null,
	image: null,
	table: null,
	lignes: [],
	panel:null,
	apercu:null,
	cellSelector:null,
	validLigne:[],
	validCollonne:[],
	instructionLigne:[],
	instructionColonne:[],
	num: null,
	
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
	
	/**
	 * Renvoie le numero de la grille
	 * @return int
	 */
	getNum: function () {
		return this.num;
	},
	
	/**
	 * Renvoie l'objet DOM conteneur
	 * @return DOM
	 */
	getDOMElement: function () {
		return this.table;
	},
	
	/**
	 * Renvoie l'objet DOM
	 * @return DOM
	 */
	getDOMContener: function () {
		return this.contenerDOM;
	},
	
	/**
	 * Retourne de la metagrille
	 * @return MetaGrille
	 */
	getMetaGrille: function () {
		return this.metaGrille;
	},
	
	/**
	 * Cree l'objet table dans la dom
	 */
	createDOMElement: function () {
		
		var thisObject = this;
		
		this.table = new Element ('table', {'class': 'table_picross'});
		
		for (var i = 0; i < this.getHeight(); i++){
			this.addLigne(i);
		}
		
		this.createDOMInstruction();
		
		window.addEvent ('mouseup', function (e) {
			
			var sGrille = thisObject.getMetaGrille ().getGrilleSelected ();
			if (sGrille && sGrille.getNum () == thisObject.getNum ()) {
				
				$$('.selector_picross_selected').each (function (el) {
					el.removeClass ('selector_picross_selected');
					var cellulePicross = el.cellulePicross;
					var color = cellulePicross.getLigne ().getGrille ().getPanel ().getSelected ();
					if (color == 'cancel') {
						cellulePicross.setColor(null);
					} else{
						cellulePicross.setColor(color);
					}
					
					thisObject.instructionHInfo (cellulePicross.getLigne ().getNum ());
					thisObject.instructionVInfo (cellulePicross.getNum ());
				});
				
				thisObject.cellSelector = null;
				
				if (thisObject.isGood ()) {
					thisObject.reveal ();
				}
				thisObject.getMetaGrille().fireEvent ('change');
			}
		});
		
		this.table.inject (this.contenerDOM);
		
		this.panel = new Panel(this);
	},
	
	/**
	 * Cree les elements html d'information de la grille
	 */
	createDOMInstruction: function (){
		
		var thisObject = this;
		
		var createNumInst = function (th, color, number) {
			
			// SI
		    // 0.3*(decimal[rouge]) + 0.59*(decimal[vert]) + 0.11*(decimal[bleu])
			// EST INFERIEUR OU EGAL A 128
			// couleur_de_texte = #FFFFFF;
			// SINON
			// couleur_de_texte = #000000;
			
			if (color != thisObject.getBackgroundColor()) {
				
				var r = parseInt(color.substr (1,2), 16);
				var v = parseInt(color.substr (3,2), 16);
				var b = parseInt(color.substr (5,2), 16);
				
				var blanc = (0.3*r + 0.59*v + 011*b) < 128;
				
				var span = new Element ('span', {
					'html': number,
					'class':'number_picross',
					'style':'color:'+((blanc) ? '#FFF': '#000')
				});
				span.setStyle('background-color', color);
				span.inject (th);
			}
		};
		
		// Insertion horizontale
		for (var i = 0; i < this.getHeight(); i++) {
			var th = new Element ('th', {'class': 'instruction_picross horizontal'});
			
			var color = null;
			var nbColor = 0;
			for (var j = 0; j < this.getWidth(); j++) {
				
				if (color === null) {
					color = this.getCellule(j, i).getPixel ();
				}
				if (color == this.getCellule(j, i).getPixel ()) {
					nbColor++;
				} else {
					var instruction = { 'nb':nbColor, 'color':color };
					if (!this.instructionLigne[i]) { this.instructionLigne[i] = []; }
					this.instructionLigne[i].push (instruction);
					createNumInst (th, color, nbColor);
					color = this.getCellule(j, i).getPixel ();
					nbColor = 1;
				}
			}
			var instruction = { 'nb':nbColor, 'color':color };
			if (!this.instructionLigne[i]) { this.instructionLigne[i] = []; }
			this.instructionLigne[i].push (instruction);
			createNumInst (th, color, nbColor);

			var span = new Element ('span', {
				'class':'valid_picross'
			});
			this.validLigne.push (span);
			span.inject (th);
			
			th.inject (this.getLigne(i).getDOMElement(), 'top');
		}
		
		// Insertion verticale
		var tr = new Element ('tr');
		var tdEmpty = new Element ('td', {'class':'instruction_picross empty'});
		this.apercu = new Apercu (this, tdEmpty);
		tdEmpty.inject (tr);
		
		for (var i = 0; i < this.getWidth(); i++) {
			var th = new Element ('th', {'class': 'instruction_picross vertical'});
			
			var color = null;
			var nbColor = 0;
			for (var j = 0; j < this.getHeight(); j++) {
				if (color === null) {
					color = this.getCellule(i, j).getPixel ();
				}
				if (color == this.getCellule(i, j).getPixel ()) {
					nbColor++;
				} else {
					var instruction = { 'nb':nbColor, 'color':color };
					if (!this.instructionColonne[i]) { this.instructionColonne[i] = []; }
					this.instructionColonne[i].push (instruction);
					createNumInst (th, color, nbColor);
					color = this.getCellule(i, j).getPixel ();
					nbColor = 1;
				}
				
			}
			var instruction = { 'nb':nbColor, 'color':color };
			if (!this.instructionColonne[i]) { this.instructionColonne[i] = []; }
			this.instructionColonne[i].push (instruction);
			createNumInst (th, color, nbColor);
			
			var span = new Element ('span', {
				'class':'valid_picross'
			});
			this.validCollonne.push (span);
			span.inject (th);
			
			th.inject (tr);
		}
		
		tr.inject (this.getDOMElement (), 'top');
	},
	
	/**
	 * Renvoi la liste des couleur
	 * @return []
	 */
	getListColors: function () {
		return this.image.pixels.unique();
	},
	
	/**
	 * Ajoute une ligne
	 * @param int numLigne
	 */
	addLigne: function (numLigne){
		var pixels = [];
		for (var i = 0; i < this.getWidth(); i++) {
			pixels.push (this.image.pixels[i+this.lignes.length*this.getWidth()]);
		}
		
		var ligne = new Ligne(this, pixels, numLigne);
		this.lignes.push (ligne);
	},
	
	/**
	 * Revele la grille
	 */
	reveal: function () {
		this.lignes.each (function (ligne) {
			ligne.reveal();
		});
		this.getDOMElement ().getElements ('.valid_picross').each (function (el) {
			el.removeClass ('error');
			el.addClass ('valid');
		});
	},
	
	/**
	 * Renvoie une ligne par sa positon
	 * @param int y Position
	 * @return Ligne
	 */
	getLigne: function (y) {
		return this.lignes[y];
	},
	
	/**
	 * Renvoie une cellule par ses coordonnees
	 * @param int x Position x
	 * @param int y Position y
	 * @return Cellule
	 */
	getCellule: function (x, y) {
		return this.getLigne (y).getCellule (x);
	},
	
	/**
	 * Renvoie la couleur de fond
	 * @return string
	 */
	getBackgroundColor: function (){
		return this.image['backgroundcolor'];
	},
	
	/**
	 * Renvoie la largeur de la grille
	 * @return int
	 */
	getWidth: function (){
		return this.image.width;
	},
	
	/**
	 * Renvoie la hauteur de la grille
	 * @return int
	 */
	getHeight: function (){
		return this.image.height;
	},
	
	/**
	 * Return le panel de la grille
	 * @return Panel
	 */
	getPanel: function () {
		return this.panel;
	},
	
	/**
	 * renvoie si la grille est bonne
	 * @return bool
	 */
	isGood: function () {
		var good = true;
		for (var i = 0; i < this.getWidth(); i++) {
			for (var j = 0; j < this.getHeight(); j++) {
				var c = this.getCellule(i, j);
				if (!c.isGood()) {
					good = false;
					break;
				}
			}
		}
		
		return good;
	},
	
	/**
	 * Retourne l'objet d'apercu
	 * @return Apercu
	 */
	getApercu: function () {
		return this.apercu;
	},
	
	/**
	 * Affiche si la ligne est bonne ou pas
	 * @param int num
	 */
	instructionHInfo: function (num) {
		
		var instructionPt = this.instructionLigne[num];
		
		var thisObject = this;
		var j = 0;
		var instruction = [];
		var list = [];
		var totalInst = 0;
		var totalColor = 0;
		
		instructionPt.each (function (el) {
			if (el.color != thisObject.getBackgroundColor()) {
				instruction.push (el);
				totalInst = totalInst + el.nb;
			}
		});
		
		
		for (var i = 0; i < this.getWidth (); i++) {
			var c = this.getCellule (i, num);
			
			if (c.getCurrentColor () == null || c.getCurrentColor () == this.getBackgroundColor()) {
				if (list[j]) {
					j++;
				}
				continue;
			}
			if (list[j] && list[j].color != c.getCurrentColor ()) {
				j++;
			}
			if (!list[j]) {
				list[j] = {'nb':0, 'color':c.getCurrentColor ()};
			}
			list[j].nb++;
			
		}
		
		var trouver = true;
		var i = 0;
		for (i; i < instruction.length; i++) {
			if (
				!list[i] || 
				instruction[i].color != list[i].color ||
				instruction[i].nb != list[i].nb
			) {
				trouver = false;
			}
		}
		if (list[i]) {
			trouver = false;
		}
		for (var i = 0; i < list.length; i++) {
			totalColor = totalColor + list[i].nb;
		}
		
		this.validLigne[num].removeClass ('error');
		this.validLigne[num].removeClass ('valid');
		
		if (trouver) {
			this.validLigne[num].addClass ('valid');
		} else if (totalColor > totalInst) {
			this.validLigne[num].addClass ('error');
		}
		
	},
	
	/**
	 * Affiche si la colonne est bonne ou pas
	 * @param int num
	 */
	instructionVInfo: function (num) {
		
		var instructionPt = this.instructionColonne[num];
		
		var thisObject = this;
		var j = 0;
		var instruction = [];
		var list = [];
		var totalInst = 0;
		var totalColor = 0;
		
		instructionPt.each (function (el) {
			if (el.color != thisObject.getBackgroundColor()) {
				instruction.push (el);
				totalInst = totalInst + el.nb;
			}
		});
		
		
		for (var i = 0; i < this.getHeight (); i++) {
			var c = this.getCellule (num, i);
			
			if (c.getCurrentColor () == null || c.getCurrentColor () == this.getBackgroundColor()) {
				if (list[j]) {
					j++;
				}
				continue;
			}
			if (list[j] && list[j].color != c.getCurrentColor ()) {
				j++;
			}
			if (!list[j]) {
				list[j] = {'nb':0, 'color':c.getCurrentColor ()};
			}
			list[j].nb++;
			
		}
		
		var trouver = true;
		var i = 0;
		for (i; i < instruction.length; i++) {
			if (
				!list[i] || 
				instruction[i].color != list[i].color ||
				instruction[i].nb != list[i].nb
			) {
				trouver = false;
			}
		}
		if (list[i]) {
			trouver = false;
		}
		for (var i = 0; i < list.length; i++) {
			totalColor = totalColor + list[i].nb;
		}
		
		this.validCollonne[num].removeClass ('error');
		this.validCollonne[num].removeClass ('valid');
		
		if (trouver) {
			this.validCollonne[num].addClass ('valid');
		} else if (totalColor > totalInst) {
			this.validCollonne[num].addClass ('error');
		}
	}
	
});

var Ligne = new Class ({
	
	grille: null,
	tr: null,
	cellules: [],
	pixels: [],
	numLigne: null,
	
	
	/**
	 * Constructeur
	 * @param Grille grille
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
	 * @return Grille
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
		var cellule = new Cellule(this, this.pixels[this.cellules.length], num);
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
	 * @return Cellule
	 */
	getCellule: function (x) {
		return this.cellules[x];
	},

	/**
	 * Return la grille de la ligne
	 * @return Grille
	 */
	getGrille: function () {
		return this.grille;
	}
	
});

var Cellule = new Class ({
	
	ligne: null,
	pixel: null,
	td: null,
	currentColor:null,
	numCell:null,
	
	/**
	 * Constructeur
	 * @param Ligne ligne
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
		var thisObject = this;
		this.td = new Element ('td');
		this.selector = new Element ('div', {
			'style':'width:100%; height:100%;',
			'class':'selector_picross'
		});
		this.selector.cellulePicross = this;
		this.selector.inject (this.td);
		var firstTd = null;
		
		
		this.selector.addEvent ('mousedown', function () {
			var cGrille = thisObject.getLigne ().getGrille ();
			var sGrille = thisObject.getLigne ().getGrille ().getMetaGrille ().getGrilleSelected ();
			if (sGrille && sGrille.getNum () == cGrille.getNum ()) {
				$$('.selector_picross').each (function (el) {
					el.removeClass ('selector_picross_selected');
				});
				thisObject.selector.addClass ('selector_picross_selected');
				
				thisObject.getLigne ().getGrille ().cellSelector = thisObject;
			}
			
		});
		
		this.selector.addEvent ('mouseover', function () {
			var cGrille = thisObject.getLigne ().getGrille ();
			var sGrille = thisObject.getLigne ().getGrille ().getMetaGrille ().getGrilleSelected ();
			if (sGrille && sGrille.getNum () == cGrille.getNum ()) {
				var selector = thisObject.getLigne ().getGrille ().cellSelector;
				
				if (selector) {
	
					var x1 = selector.getNum ();
					var y1 = selector.getLigne().getNum ();
					var x2 = thisObject.getNum ();
					var y2 = thisObject.getLigne().getNum ();
					if (x1 > x2) {
						x2 = selector.getNum ();
						x1 = thisObject.getNum ();
					}
					if (y1 > y2) {
						y2 = selector.getLigne().getNum ();
						y1 = thisObject.getLigne().getNum ();
					}
					
					$$('.selector_picross').each (function (el) {
						el.removeClass ('selector_picross_selected');
					});
					for (var i = x1; i <= x2; i++) {
						for (var j = y1; j <= y2; j++) {
							thisObject.getLigne ().getGrille ().getCellule (i, j).selector.addClass ('selector_picross_selected');
						}
					}
				}
			}
		});
		
		
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
	 * @return Ligne
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

var Panel = new Class ({
	
	grille: null,
	div: null,
	selected:null,
	
	/**
	 * Constructeur
	 * @param Grille grille
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
	 * @return Grille
	 */
	getGrille: function () {
		return this.grille;
	}
	
});

var Apercu = new Class ({

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
	 * @return Grille
	 */
	getGrille: function () {
		return this.grille;
	}
});
