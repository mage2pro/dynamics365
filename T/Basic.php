<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\API\R as R;
// 2017-04-23
final class Basic extends TestCase {
	/** @test 2017-04-23 */
	function t00() {}

	/** 2017-07-01 */
	function accounts() {$this->p();}

	/** 2017-06-30 */
	function invalid() {$this->p('dummy');}

	/** 2017-04-23 */
	function metadata() {xdebug_break(); echo R::metadata();}

	/** 2017-07-01 */
	function products() {echo df_dump(df_json_encode_pretty(array_filter(
		R::products(), function(array $p) {return df_starts_with($p['name'], 'Stripe');}
	)));}

	/** 2017-06-30 */
	function service() {echo df_dump(df_json_encode_pretty(R::service()));}
}