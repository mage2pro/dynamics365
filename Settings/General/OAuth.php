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
	 * 2017-04-23
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_dynamics365/general/oauth';}
}