<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\API\R as R;
// 2017-04-23
final class Basic extends TestCase {
	/** 2017-04-23 */
	function t00() {}

	/** 2017-06-30 */
	function t01() {echo df_dump(df_json_encode_pretty(R::service()));}

	/** @test 2017-06-30 */
	function t02_invalid() {echo df_dump(df_json_encode_pretty(R::p('dummy')));}
}