<?php
namespace Dfe\Dynamics365\Test;
use Dfe\Dynamics365\API\Facade as F;
# 2017-04-23
final class Basic extends TestCase {
	/** 2017-04-23 @test */
	function t00():void {}

	/** 2017-07-01 */
	function accounts():void {$this->p();}

	/** 2017-06-30 */
	function invalid():void {$this->p('dummy');}

	/** 2017-04-23 */
	function metadata():void {print_r(F::metadata());}

	/** 2017-07-01 */
	function products():void {$this->o(array_filter(F::products(), function(array $p) {return
		df_starts_with($p['name'], 'Stripe')
	;}));}

	/** 2017-06-30 */
	function service():void {$this->o((F::service()));}
}