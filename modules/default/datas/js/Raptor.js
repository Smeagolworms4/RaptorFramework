/**
 * Class général du frameworks
 * 
 * @author     Damien Duboeuf
 * @version 	1.0
 */
var Raptor = {
	
//	/**
//	 * Renvoie une URL en focntion de dest
//	 * @param string dest
//	 */
//	getUrl: function (dest) {
//		var url = window.location.href.split ('index.php');
//		dest = dest.split ('|');
//		
//		url = url[0]+'index.php/'+dest[0]+((dest[1] !== undefined) ? '/'+dest[1] : '');
//		
//		return url;
//	}
	
	extractUrlParams: function () {
		var t = location.search.substring(1).split('&');
		var f = [];
		for (var i=0; i<t.length; i++) {
			var x = t[i].split('=');
			f[x[0]]=x[1];
		}
		return f;
	}
};
