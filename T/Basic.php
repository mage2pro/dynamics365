<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\OAuth;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
// 2017-04-23
final class Basic extends TestCase {
	/** 2017-04-23 */
	function t00() {echo df_dump([OAuth::token()]);}

	/** 2017-06-30 */
	function t01() {echo df_dump([OAuth::token()]);}

	/** @test 2017-06-30 */
	function t02() {
		/** @var C $c */
		$c = (new C)
			->setConfig(['timeout' => 120])
			->setHeaders([
				'Accept' => 'application/json'
				,'Authorization' => 'Bearer ' . OAuth::token()
				,'OData-MaxVersion' => '4.0'
				,'OData-Version' => '4.0'
			])
			->setMethod(C::GET)
			->setUri(S::s()->url() . '/api/data/v8.2/accounts')
		;
		$r = df_json_decode($c->request()->getBody());
		echo df_dump($r);
	}
}