<?php
namespace Dfe\Dynamics365\API\Client;
use Df\Core\Exception as DFE;
# 2017-07-02
final class JSON extends \Dfe\Dynamics365\API\Client {
	/**
	 * 2017-07-06
	 * @override
	 * @see \Df\API\Client::_construct()
	 * @used-by \Df\API\Client::__construct()
	 */
	final protected function _construct() {parent::_construct(); $this->resJson();}

	/**
	 * 2017-07-02
	 * 2017-07-03
	 * «Every request should include the Accept header value of application/json,
	 * even when no response body is expected.
	 * Any error returned in the response will be returned as JSON.
	 * While your code should work even if this header isn’t included,
	 * we recommend including it as a best practice.»
	 * https://msdn.microsoft.com/en-us/library/gg334391.aspx#bkmk_headers
	 * @override
	 * @see \Dfe\Dynamics365\API\Client::accept()
	 * @used-by \Dfe\Dynamics365\API\Client::headers()
	 * @return string
	 */
	protected function accept() {return 'json';}

	/**
	 * 2017-07-05
	 * @override
	 * @see \Df\API\Client::responseValidatorC()
	 * @used-by \Df\API\Client::_p()
	 */
	protected function responseValidatorC():string {return \Dfe\Dynamics365\API\Validator\JSON::class;}
}
