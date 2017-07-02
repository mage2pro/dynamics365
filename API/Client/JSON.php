<?php
namespace Dfe\Dynamics365\API\Client;
use Df\Core\Exception as DFE;
// 2017-07-02
final class JSON extends \Dfe\Dynamics365\API\Client {
	/**
	 * 2017-07-02
	 * 2017-07-03
	 * «Every request should include the Accept header value of application/json,
	 * even when no response body is expected.
	 * Any error returned in the response will be returned as JSON.
	 * While your code should work even if this header isn’t included,
	 * we recommend including it as a best practice.»
	 * https://msdn.microsoft.com/en-us/library/gg334391.aspx#Anchor_2
	 * @override
	 * @see \Dfe\Dynamics365\API\Client::accept()
	 * @used-by \Dfe\Dynamics365\API\Client::p()
	 * @return string
	 */
	protected function accept() {return 'json';}

	/**
	 * 2017-07-02
	 * @override
	 * @see \Dfe\Dynamics365\API\Client::postProcess()
	 * @used-by \Dfe\Dynamics365\API\Client::p()
	 * @param string $response
	 * @return string|mixed
	 */
	protected function postProcess($response) {return df_json_decode($response);}

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
	 * @override
	 * @see \Dfe\Dynamics365\API\Client::validate()
	 * @used-by \Dfe\Dynamics365\API\Client::p()
	 * @param mixed $r
	 * @throws DFE
	 */
	protected function validate($r) {
		/* @var array(string => string|array(string => string))|null $e  */
		if ($e = dfa($r, 'error')) {
			// 2017-06-30 It correctly works even if the key does not exist in the array.
			unset($e['innererror']['stacktrace']);
			/** @var string $message */
			$message = dfa($e, 'message');
			/** @var string $req */
			$req = df_zf_http_last_req($this->c());
			/** @var string $res */
			$res = df_json_encode_pretty($e);
			/** @var DFE $ex */
			$ex = df_error_create(
				"The «{$this->path()}» Dynamics 365 Web API request has failed: «{$message}»."
				."\nThe full error description:\n$res"
				."\nThe full request:\n$req"
			);
			df_log_l(__CLASS__, $ex);
			df_sentry(__CLASS__, $message, ['extra' => ['Request' => $req, 'Response' => $res]]);
			throw $ex;
		}
	}
}
