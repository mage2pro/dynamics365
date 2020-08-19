<?php
namespace Dfe\Dynamics365\Source;
use Dfe\Dynamics365\API\Facade as F;
use Dfe\Dynamics365\Settings\General\OAuth as S;
# 2017-07-02
final class PriceList extends \Df\Config\Source\API {
	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Source\API::fetch()
	 * @used-by \Df\Config\Source\API::map()
	 * @return array(string => string)
	 */
	protected function fetch() {return array_column(F::pricelevels(), 'name', 'pricelevelid');}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Source\API::isRequirementMet()
	 * @used-by \Df\Config\Source\API::map()
	 * @return bool
	 */
	protected function isRequirementMet() {return S::s()->authenticatedB();}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Source\API::requirement()
	 * @used-by \Df\Config\Source\API::map()
	 * @return string
	 */
	protected function requirement() {return 'Setup the «General» → «OAuth 2.0» section first.';}
}