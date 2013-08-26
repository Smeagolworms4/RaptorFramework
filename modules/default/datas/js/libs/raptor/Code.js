/**
 * Class général du frameworks
 * 
 * @author     Damien Duboeuf
 * @version 	1.0
 */
Raptor.Code = new Class ({

	textarea: null,
	code: null,
	
	/**
	 * @param string id
	 * @param string language
	 */
	initialize: function (id, language) {
		
		var _this = this;
		
		this.textarea = $(id+'_textarea');
		this.code = $(id+'_code');
		this.code.innerHTML = hljs.highlight (language, this.textarea.value, true).value;
		
		this.code.setStyle ('display', 'inline-block');
//		this.textarea.setStyle ('visibility', 'hidden');
		
	}
});
