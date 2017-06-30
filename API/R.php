<?php
namespace Dfe\Dynamics365\API;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
// 2017-06-30
final class R {
	/**
	 * 2017-06-30
	 * @param string $path
	 * @param string $method [optional]
	 * @param array(string => mixed) $p [optional]
	 * @return array(string => mixed)
	 */
	static function p($path, $method = C::GET, array $p = []) {
		/** @var C $c */
		$c = (new C)
			->setConfig(['timeout' => 120])
			->setHeaders([
				'Accept' => 'application/json'
				,'Authorization' => 'Bearer ' . OAuth::token()
				,'OData-MaxVersion' => '4.0'
				,'OData-Version' => '4.0'
			])
			->setMethod($method)
			->setUri(S::s()->url() . $path)
		;
		C::GET === $method ? $c->setParameterGet($p) : $c->setParameterPost($p);
		return df_json_decode($c->request()->getBody());
	}
}