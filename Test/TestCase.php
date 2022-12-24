<?php
namespace Dfe\Dynamics365\Test;
use Dfe\Dynamics365\API\Facade as F;
/**
 * 2017-04-23
 * @see \Dfe\Dynamics365\Test\Basic
 * @see \Dfe\Dynamics365\Test\OAuth
 * @see \Dfe\Dynamics365\Test\Price
 */
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-07-03
	 * @used-by self::p()
	 * @used-by \Dfe\Dynamics365\Test\Basic::products()
	 * @used-by \Dfe\Dynamics365\Test\Basic::service()
	 * @used-by \Dfe\Dynamics365\Test\Price::productpricelevels()
	 * @param array(string => mixed) $r
	 */
	final protected function o(array $r):void {print_r(df_json_encode($r));}

	/**
	 * 2017-07-01
	 * @used-by \Dfe\Dynamics365\Test\Basic::accounts()
	 * @used-by \Dfe\Dynamics365\Test\Basic::invalid()
	 * @used-by \Dfe\Dynamics365\Test\Price::pricelevels()
	 */
	final protected function p(string $f = ''):void {$this->o((call_user_func([F::class, $f ?: df_caller_f()])));}
}