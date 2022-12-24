<?php
namespace Dfe\Dynamics365\API;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\API\Client\JSON as J;
use Dfe\Dynamics365\API\Client\XML as X;
# 2017-06-30
final class Facade {
	/**
	 * 2017-06-30
	 * 2017-07-01 «account EntityType»: https://msdn.microsoft.com/en-us/library/mt607894.aspx
	 * «Business that represents a customer or potential customer.
	 * The company that is billed in business transactions.»
	 * @return array(string => mixed)
	 */
	static function accounts():array {return self::p(__FUNCTION__);}

	/**
	 * 2017-07-02
	 * 1) «Retrieves the default price level (price list) for the current user
	 * based on the user’s territory relationship with the price level.»
	 * https://msdn.microsoft.com/en-us/library/mt608119.aspx
	 * 2) «To invoke a bound function,
	 * append the full name of the function to the URL
	 * and include any named parameters within the parentheses following the function name.
	 * The full function name includes the namespace Microsoft.Dynamics.CRM.
	 * Functions that aren’t bound must not use the full name.»
	 * 3) «A bound function must be invoked using a URI to set the first parameter value.
	 * You can’t set it as a named parameter value.»
	 * 4)
	 * <Function Name="GetDefaultPriceLevel" IsBound="true" IsComposable="true">
	 *		<Parameter Name="entityset" Type="Collection(mscrm.pricelevel)" Nullable="false"/>
	 *		<Parameter Name="EntityName" Type="Edm.String" Nullable="false" Unicode="false"/>
	 *		<ReturnType Type="Collection(mscrm.pricelevel)" Nullable="false"/>
 	 * </Function>
	 * «CSDL metadata document»: https://msdn.microsoft.com/en-us/library/mt607990.aspx#bkmk_csd
	 * @return array(string => mixed)
	 */
	static function GetDefaultPriceLevel():array {
		# 2017-07-03 @todo I do not understand how to call the GetDefaultPriceLevel() function.
		df_should_not_be_here();
		return self::p(
			"pricelevels(90427858-7a77-e511-80d4-00155d2a68d1)/Microsoft.Dynamics.CRM.GetDefaultPriceLevel(EntityName='test')"
		);
	}

	/**
	 * 2017-07-02 «CSDL metadata document»: https://msdn.microsoft.com/en-us/library/mt607990.aspx#bkmk_csdl
	 */
	static function metadata():string {return (new X('$' . __FUNCTION__))->p();}

	/**
	 * 2017-07-01 «pricelevel EntityType»: https://msdn.microsoft.com/en-us/library/mt607683.aspx
	 * «Entity that defines pricing levels.
	 * Display Name: `Price List`
	 * Primary Key: `pricelevelid`
	 * Primary Name `Attribute: name`»
	 * @used-by \Dfe\Dynamics365\Source\PriceList::fetch()
	 * @return array(string => mixed)
	 */
	static function pricelevels():array {return self::p(__FUNCTION__);}

	/**
	 * 2017-07-01 «productpricelevel EntityType»: https://msdn.microsoft.com/en-us/library/mt592996.aspx
	 * «Information about how to price a product in the specified price level,
	 * including pricing method, rounding option, and discount type based on a specified product unit.»
	 * @return array(string => mixed)
	 */
	static function productpricelevels(string $priceLevelId = ''):array {return self::p(__FUNCTION__, df_clean([
		'$filter' => !$priceLevelId ? null : "_pricelevelid_value eq $priceLevelId"
	]));}

	/**
	 * 2017-07-01 «product EntityType»: https://msdn.microsoft.com/en-us/library/mt607876.aspx
	 * «Information about products and their pricing information.»
	 * @return array(string => mixed)
	 */
	static function products():array {return self::p(__FUNCTION__);}

	/**
	 * 2017-06-30
	 * @return array(string => mixed)
	 */
	static function service():array {return self::p('');}

	/**
	 * 2017-06-30
	 * @used-by self::accounts()
	 * @used-by self::service()
	 * @param array(string => mixed) $p [optional]
	 * @return array(string => mixed)
	 * @throws DFE
	 */
	static function p(string $path, array $p = [], string $method = '') {return (new J($path, $p, $method))->p()['value'];}
}