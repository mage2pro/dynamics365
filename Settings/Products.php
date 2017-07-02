<?php
namespace Dfe\Dynamics365\Settings;
// 2017-07-02
/** @method static Products s() */
final class Products extends \Df\Config\Settings {
	/**
	 * 2017-07-02
	 * @return string
	 */
	function priceList() {return $this->v();}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_dynamics365/products';}
}