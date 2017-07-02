<?php
namespace Dfe\Dynamics365\T;
use \Dfe\Dynamics365\Settings\Products as S;
// 2017-07-02
final class Products extends TestCase {
	/** 2017-07-02 */
	function t00() {}

	/** @test 2017-07-02 */
	function t01() {echo S::s()->priceList();}
}