<?php
namespace Dfe\Dynamics365\Source;
// 2017-07-02
final class PriceList extends \Df\Config\Source\API {
	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Source\API::fetch()
	 * @used-by \Df\Config\Source\API::map()
	 * @return array(string => string)
	 */
	protected function fetch() {return ['Test' => 'Test'];}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Source\API::isRequirementMet()
	 * @used-by \Df\Config\Source\API::map()
	 * @return bool
	 */
	protected function isRequirementMet() {return true;}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Df\Config\Source\API::requirementTitle()
	 * @used-by \Df\Config\Source\API::map()
	 * @return string
	 */
	protected function requirementTitle() {return '';}
}