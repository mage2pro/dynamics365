<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\OAuth as O;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
// 2017-04-23
final class Basic extends TestCase {
	/** 2017-04-23 */
	function t00() {}

	/** @test 2017-06-30 */
	function t01() {echo df_dump(O::r('/api/data/v8.2/accounts'));}
}