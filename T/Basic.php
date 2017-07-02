<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\API\R as R;
// 2017-04-23
final class Basic extends TestCase {
	/** 2017-04-23 */
	function t00() {}

	/** 2017-07-01 */
	function accounts() {echo df_dump(df_json_encode_pretty(R::accounts()));}

	/** 2017-06-30 */
	function invalid() {echo df_dump(df_json_encode_pretty(R::p('dummy')));}

	/** @test 2017-07-01 */
	function pricelevels() {echo df_dump(df_json_encode_pretty(R::pricelevels()));}

	/** 2017-07-01 */
	function productpricelevels() {$this->p();}

	/** 2017-07-01 */
	function products() {echo df_dump(df_json_encode_pretty(array_filter(
		R::products(), function(array $p) {return df_starts_with($p['name'], 'Stripe');}
	)));}

	/** 2017-06-30 */
	function service() {echo df_dump(df_json_encode_pretty(R::service()));}

	/**
	 * 2017-07-01
	 * @param string|null $f [optional]
	 */
	private function p($f = null) {echo df_dump(df_json_encode_pretty(call_user_func([
		R::class, $f ?: df_caller_f()
	])));}
}