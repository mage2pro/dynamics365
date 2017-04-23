<?php
namespace Dfe\Dynamics365\Settings;
// 2017-04-23
/** @method static General s() */
final class General extends \Df\Config\Settings {
	/**
	 * 2017-04-23
	 * @return string
	 */
	function apiKey() {return $this->p();}

	/**
	 * 2017-04-23
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_dynamics365/general';}
}