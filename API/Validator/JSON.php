<?php
namespace Dfe\Dynamics365\API\Validator;
use Df\API\Client;
use Df\Core\Exception as DFE;
// 2017-07-05
/** @used-by \Dfe\Dynamics365\API\Client\JSON::responseValidatorC() */
final class JSON implements \Df\API\Response\IValidator {
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
	 * @see \Df\API\Response\IValidator::validate()
	 * @used-by \Df\API\Client::p()
	 * @param Client $c
	 * @param mixed $r
	 * @throws DFE
	 */
	function validate(Client $c, $r) {
		/* @var array(string => string|array(string => string))|null $e  */
		if ($e = dfa($r, 'error')) {
			// 2017-06-30 It correctly works even if the key does not exist in the array.
			unset($e['innererror']['stacktrace']);
			/** @var string $message */
			$message = dfa($e, 'message');
			/** @var string $req */
			$req = df_zf_http_last_req($c->c());
			/** @var string $res */
			$res = df_json_encode_pretty($e);
			/** @var DFE $ex */
			$ex = df_error_create(
				"The «{$c->path()}» Dynamics 365 Web API request has failed: «{$message}»."
				."\nThe full error description:\n$res"
				."\nThe full request:\n$req"
			);
			df_log_l(__CLASS__, $ex);
			df_sentry(__CLASS__, $message, ['extra' => ['Request' => $req, 'Response' => $res]]);
			throw $ex;
		}
	}
}