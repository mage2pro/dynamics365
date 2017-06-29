<?php
namespace Dfe\Dynamics365\Settings\General;
// 2017-04-23
/** @method static OAuth s() */
final class OAuth extends \Df\Config\Settings {
	/**
	 * 2017-04-23
	 * @used-by \Dfe\Dynamics365\Button::onFormInitialized()
	 * @return string
	 */
	function clientId() {return $this->v();}

	/**
	 * 2017-04-23
	 * @return string
	 */
	function clientPassword() {return $this->p();}

	/**
	 * 2017-06-29
	 * @return string
	 */
	function refreshToken() {return $this->v();}

	/**
	 * 2017-06-29
	 * @param string $v
	 * @param string $scope		E.g.: «default»
	 * @param int $scopeId		E.g.: «0»
	 */
	function refreshTokenSave($v, $scope, $scopeId) {df_cfg_save(
		"{$this->prefix()}/refreshToken", $v, $scope, $scopeId
	);}

	/**
	 * 2017-06-28 «The root URL of your Dynamics 365 frontend»
	 * @used-by \Dfe\Dynamics365\OAuth::p()
	 * @return string
	 */
	function url() {return $this->v();}

	/**
	 * 2017-04-23
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @used-by refreshTokenSave()
	 * @return string
	 */
	protected function prefix() {return 'df_dynamics365/general/oauth';}
}