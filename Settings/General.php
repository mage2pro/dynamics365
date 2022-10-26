<?php
namespace Dfe\Dynamics365\Settings;
# 2017-04-23
/** @method static General s() */
final class General extends \Df\Config\Settings {
	/**
	 * 2017-06-28 «The root URL of your Dynamics 365 frontend»
	 * @used-by \Dfe\Dynamics365\OAuth\App::r()
	 * @used-by \Dfe\Dynamics365\OAuth\App::pCommon()
	 * @return string
	 */
	function url() {return $this->v();}

	/**
	 * 2017-04-23
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return 'df_dynamics365/general';}
}