if (window.Device) {
	
	
} else {
	var DeviceEngine = new Class ({
		
		DEVICE_TYPE_BROWSER : 'browser',
		DEVICE_TYPE_ANDOID : 'android',
		DEVICE_TYPE_IOS : 'ios',
		
		/**
		 * Return type of Device
		 * @return string
		 */
		getType: function () {
			return this.DEVICE_TYPE_BROWSER;
		},
		
		/**
		 * Display string in log
		 * @param string msg
		 */
		log: function (obj) {
			console.log (obj);
		}
		
	});
	var Device = new DeviceEngine ();
	
}
