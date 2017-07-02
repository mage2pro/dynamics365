<?php
namespace Dfe\Dynamics365\API;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\API\Client\JSON as J;
use Dfe\Dynamics365\API\Client\XML as X;
// 2017-06-30
final class R {
	/**
	 * 2017-06-30
	 * 2017-07-01 «account EntityType»: https://msdn.microsoft.com/en-us/library/mt607894.aspx
	 * «Business that represents a customer or potential customer.
	 * The company that is billed in business transactions.»
	 * @return array(string => mixed)
	 */
	static function accounts() {return self::p(__FUNCTION__);}

	/**
	 * 2017-07-02 https://msdn.microsoft.com/en-us/library/mt608119.aspx
	 * «Retrieves the default price level (price list) for the current user
	 * based on the user’s territory relationship with the price level.»
	 * @return array(string => mixed)
	 */
	static function GetDefaultPriceLevel() {return self::p(
		"pricelevels/Microsoft.Dynamics.CRM.GetDefaultPriceLevel()"
	);}

	/**
	 * 2017-07-02 «CSDL metadata document»: https://msdn.microsoft.com/en-us/library/mt607990.aspx#bkmk_csdl
	 * @return string
	 */
	static function metadata() {return (new X('$' . __FUNCTION__))->p();}

	/**
	 * 2017-07-01 «pricelevel EntityType»: https://msdn.microsoft.com/en-us/library/mt607683.aspx
	 * «Entity that defines pricing levels.
	 * Display Name: `Price List`
	 * Primary Key: `pricelevelid`
	 * Primary Name `Attribute: name`»
	 * @used-by \Dfe\Dynamics365\Source\PriceList::fetch()
	 * @return array(string => mixed)
	 */
	static function pricelevels() {return self::p(__FUNCTION__);}

	/**
	 * 2017-07-01 «productpricelevel EntityType»: https://msdn.microsoft.com/en-us/library/mt592996.aspx
	 * «Information about how to price a product in the specified price level,
	 * including pricing method, rounding option, and discount type based on a specified product unit.»
	 * @return array(string => mixed)
	 */
	static function productpricelevels() {return self::p(__FUNCTION__);}

	/**
	 * 2017-07-01 «product EntityType»: https://msdn.microsoft.com/en-us/library/mt607876.aspx
	 * «Information about products and their pricing information.»
	 * @return array(string => mixed)
	 */
	static function products() {return self::p(__FUNCTION__);}

	/**
	 * 2017-06-30
	 * @return array(string => mixed)
	 */
	static function service() {return self::p('');}

	/**
	 * 2017-06-30
	 * @used-by accounts()
	 * @used-by service()
	 * @param string $path
	 * @return array(string => mixed)
	 * @throws DFE
	 */
	static function p($path) {return array_map('df_ksort', (new J($path))->p()['value']);}
}