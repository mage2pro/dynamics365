<?php
namespace Dfe\Dynamics365\API;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
// 2017-06-30
final class R {
	/**
	 * 2017-06-30
	 * @return array(string => mixed)
	 */
	static function accounts() {return self::p(__FUNCTION__);}

	/**
	 * 2017-06-30
	 * @return array(string => mixed)
	 */
	static function service() {return self::p('');}

	/**
	 * 2017-06-30
	 * @used-by accounts()
	 * @used-by service()
	 * @param string $path
	 * @param string $method [optional]
	 * @param array(string => mixed) $p [optional]
	 * @return array(string => mixed)
	 * @throws DFE
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
			->setUri(df_cc_path(S::s()->url(), 'api/data/v8.2', $path))
		;
		C::GET === $method ? $c->setParameterGet($p) : $c->setParameterPost($p);
		/** @var array(string => mixed) $r */
		$r = df_json_decode($c->request()->getBody());
		/**
		 * 2017-06-30
		 * An error response looks like:
		 *	{
		 *		"error": {
		 *			"code": "",
		 *			"message": "Resource not found for the segment 'dummy'.",
		 *			"innererror": {
		 *				"message": "Resource not found for the segment 'dummy'.",
		 *				"type": "Microsoft.OData.Core.UriParser.ODataUnrecognizedPathException",
		 *				"stacktrace": "<...>"
		 *			}
		 *		}
		 *	}
		 * @var array(string => string|array(string => string))|null $e
		 */
		if ($e = dfa($r, 'error')) {
			// 2017-06-30 It correctly works even if the key does not exist in the array.
			unset($e['innererror']['stacktrace']);
			/** @var string $message */
			$message = dfa($e, 'message');
			/** @var string $req */
			$req = df_zf_http_last_req($c);
			/** @var string $res */
			$res = df_json_encode_pretty($e);
			/** @var DFE $ex */
			$ex = df_error_create(
				"The «{$path}» Dynamics 365 Web API request has failed: «{$message}»."
				."\nThe full error description:\n$res"
				."\nThe full request:\n$req"
			);
			df_log_l(__CLASS__, $ex);
			df_sentry(__CLASS__, $message, ['extra' => ['Request' => $req, 'Response' => $res]]);
			throw $ex;
		}
		return $r;
	}
}