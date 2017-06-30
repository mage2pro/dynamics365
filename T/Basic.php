<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\OAuth;
use Dfe\Dynamics365\Settings\General\OAuth as S;
// 2017-04-23
final class Basic extends TestCase {
	/** @test 2017-04-23 */
	function t01() {echo df_dump([OAuth::token()]);}
}