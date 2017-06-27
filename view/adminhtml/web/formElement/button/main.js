// 2017-06-27
define(['jquery', 'domReady!'], function($) {return (
	/**
	 * 2017-06-27
	 * @param {Object} config
	 * @param {String} config.id
	 */
	function(config) {$(document.getElementById(config.id)).click(function() {
		window.location = 'https://login.microsoftonline.com/common/oauth2/authorize?';
	});}
);});