<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\API\R as R;
use Dfe\Dynamics365\Settings\Products as S;
// 2017-07-02
final class Price extends TestCase {
	/** 2017-07-02 */
	function t00() {}
	
	/** 2017-07-01 */
	function pricelevels() {$this->p();}

	/** @test 2017-07-01 */
	function productpricelevels() {$this->o(R::productpricelevels(S::s()->priceList()));}

	/** 2017-07-02 */
	function priceList() {echo S::s()->priceList();}

	/** 2017-07-02 */
	function GetDefaultPriceLevel() {echo $this->p();}
}