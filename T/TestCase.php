<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\API\Facade as F;
/**
 * 2017-04-23
 * @see \Dfe\Dynamics365\T\Basic
 */
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-07-03
	 * @used-by p()
	 * @used-by \Dfe\Dynamics365\T\Basic::products()
	 * @used-by \Dfe\Dynamics365\T\Basic::service()
	 * @used-by \Dfe\Dynamics365\T\Price::productpricelevels()
	 * @param array(string => mixed) $r
	 */
	final protected function o(array $r) {echo df_json_encode_pretty($r);}

	/**
	 * 2017-07-01
	 * @param string|null $f [optional]
	 */
	final protected function p($f = null) {$this->o((call_user_func([F::class, $f ?: df_caller_f()])));}
}