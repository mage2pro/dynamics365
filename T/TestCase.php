<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\API\R as R;
/**
 * 2017-04-23
 * @see \Dfe\Dynamics365\T\Basic
 */
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-07-01
	 * @param string|null $f [optional]
	 */
	final protected function p($f = null) {echo df_dump(df_json_encode_pretty(call_user_func([
		R::class, $f ?: df_caller_f()
	])));}
}