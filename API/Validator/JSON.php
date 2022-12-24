<?php
namespace Dfe\Dynamics365\API\Validator;
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
 * @used-by \Dfe\Dynamics365\API\Client\JSON::responseValidatorC()
 */
final class JSON extends \Df\API\Response\Validator {
	/**
	 * 2017-07-06
	 * @override
	 * @see \Df\API\IException::long()
	 * @used-by \Df\API\Client::_p()
	 */
	function long():string {
		$e = $this->r('error'); /** @var array(string => mixed) $e */
		# 2017-06-30 It correctly works even if the key does not exist in the array.
		unset($e['innererror']['stacktrace']); /** 2022-11-27 @see dfa_deep_unset() */
		return df_json_encode($e);
	}

	/**
	 * 2017-07-06
	 * @override
	 * @see \Df\API\IException::short()
	 * @used-by \Df\API\Client::_p()
	 */
	function short():string {return $this->r('error/message');}

	/**
	 * 2017-07-06
	 * @override
	 * @see \Df\API\Response\Validator::valid()
	 * @used-by \Df\API\Client::_p()
	 */
	function valid():bool {return !$this->r('error');}
}