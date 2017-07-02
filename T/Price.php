<?php
namespace Dfe\Dynamics365\T;
use \Dfe\Dynamics365\Settings\Products as S;
// 2017-07-02
final class Price extends TestCase {
	/** @test 2017-07-02 */
	function t00() {}

	/** 2017-07-02 */
	function priceList() {echo S::s()->priceList();}

	/** 2017-07-02 */
	function GetDefaultPriceLevel() {echo $this->p();}
}