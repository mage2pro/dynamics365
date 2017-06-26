// 2017-06-27
define(['jquery', 'Df_Core/ColorPicker', 'domReady!'], function($) {return (
	/**
	 * 2017-06-27
	 * @param {Object} config
	 * @param {String} config.id
	 */
	function(config) {
		/** https://github.com/bgrins/spectrum */
		var $e = $(document.getElementById(config.id));
		$e.click(function() {console.log('Authenticate!');});
	}
);});