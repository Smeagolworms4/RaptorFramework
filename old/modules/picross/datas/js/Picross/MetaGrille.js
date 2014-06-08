Picross.MetaGrille = new Class ({

	contenerDOM: null,
	metaImage: null,
	
	/**
	 * Constructeur
	 * @param DOM contenerDOM
	 * @param {}  metaImage
	 */
	initialize: function (contenerDOM, metaImage) {
		this.contenerDOM = contenerDOM;
		this.metaImage = metaImage;
	},
	
	/**
	 * Affiche la metagrille
	 */
	display: function () {
		
		var _this = this;
		var table = new Element ('table', {
			'class': 'metaimage_picross'
		});
		
		this.metaImage.images.each (function (ligne) {
			
			var tr = new Element ('tr');
			ligne.each (function (images) {
				
				var td = new Element ('td');
				var tableG = new Element ('table', {
					'class': 'picross'
				});
				
				var i = 0;
				var trG = null;
				images.each (function (pixel) {
					if ((i % _this.metaImage.g_width) == 0) {
						trG = new Element ('tr');
						trG.inject (tableG);
					}
					var tdG = new Element ('td');
					tdG.setStyles ({
						'background-color' : pixel
					});

					tdG.inject (trG);
					i++;
				});
				
				tableG.inject (td);
				td.inject (tr);
			});
			tr.inject (table);
		});
		
		table.inject (this.contenerDOM);
	}
});

