<?php
namespace Dfe\Dynamics365\Test;
use Dfe\Dynamics365\API\Facade as F;
// 2017-04-23
final class Basic extends TestCase {
	/** @test 2017-04-23 */
	function t00() {}

	/** 2017-07-01 */
	function accounts() {$this->p();}

	/** 2017-06-30 */
	function invalid() {$this->p('dummy');}

	/** 2017-04-23 */
	function metadata() {print_r(F::metadata());}

	/** 2017-07-01 */
	function products() {$this->o(array_filter(F::products(), function(array $p) {return
		df_starts_with($p['name'], 'Stripe')
	;}));}

	/** 2017-06-30 */
	function service() {$this->o((F::service()));}
}