<?php
namespace Dfe\Dynamics365\Settings;
# 2017-07-02
/** @method static Products s() */
final class Products extends \Df\Config\Settings {
	/**
	 * 2017-07-02
	 */
	function priceList():string {return $this->v();}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return 'df_dynamics365/products';}
}