<?php
namespace Dfe\Dynamics365\Test;
use Dfe\Dynamics365\API\Facade as F;
use Dfe\Dynamics365\Settings\Products as S;
# 2017-07-02
final class Price extends TestCase {
	/** 2017-07-02 @test */
	function t00() {}
	
	/** 2017-07-01 */
	function pricelevels() {$this->p();}

	/** 2017-07-01 */
	function productpricelevels() {$this->o(F::productpricelevels(S::s()->priceList()));}

	/** 2017-07-02 @test */
	function priceList() {print_r(S::s()->priceList());}

	/** 2017-07-02 */
	function GetDefaultPriceLevel() {print_r($this->p());}
}