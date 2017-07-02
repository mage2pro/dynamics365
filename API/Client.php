<?php
namespace Dfe\Dynamics365\API;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
/**
 * 2017-07-02
 * @see \Dfe\Dynamics365\API\Client\JSON
 * @see \Dfe\Dynamics365\API\Client\XML
 */
abstract class Client {
	/**
	 * 2017-07-02
	 * @used-by p()
	 * @return string
	 */
	abstract protected function accept();

	/**
	 * 2017-07-02
	 * @param string $path
	 * @param string|null $method [optional]
	 * @param array(string => mixed) $p [optional]
	 * @throws DFE
	 */
	final function __construct($path, $method = null, array $p = []) {
		$this->_path = $path;
		$this->_c = new C;
		$this->_c->setMethod($method = $method ?: C::GET);
		C::GET === $method ? $this->_c->setParameterGet($p) : $this->_c->setParameterPost($p);
		$this->_ckey = implode('::', [$path, $method, dfa_hash($p)]);
	}

	/**
	 * 2017-06-30
	 * @throws DFE
	 * @return string
	 */
	final function p() {return df_cache_get_simple($this->_ckey, function() {
		/** @var C $c */
		$c = $this->c();
		$c->setConfig(['timeout' => 120]);
		$c->setHeaders([
			'Accept' => "application/{$this->accept()}"
			,'Authorization' => 'Bearer ' . OAuth::token()
			// 2017-07-03
			// «The current OData version is 4.0, but future versions may allow for new capabilities.
			// To ensure that there is no ambiguity about the OData version
			// that will be applied to your code at that point in the future,
			// you should always include an explicit statement of the current OData version
			// and the Maximum version to apply in your code.
			// Use both OData-Version and OData-MaxVersion headers set to a value of 4.0.»
			// https://msdn.microsoft.com/en-us/library/gg334391.aspx#bkmk_headers
			,'OData-MaxVersion' => '4.0'
			,'OData-Version' => '4.0'
			,'User-Agent' => sprintf('The «Dynamics 365» extension for Magento 2 (https://mage2.pro/c/extensions/dynamics365) used on the %s website', df_domain_current())
		]);
		$c->setUri(df_cc_path(S::s()->url(), 'api/data/v8.2', $this->path()));
		/** @var mixed $r */
		$r = $this->postProcess($c->request()->getBody());
		$this->validate($r);
		return $r;
	});}

	/**
	 * 2017-07-02
	 * @used-by p()
	 * @used-by \Dfe\Dynamics365\API\Client\JSON::validate()
	 * @return C
	 */
	final protected function c() {return $this->_c;}

	/**
	 * 2017-07-02
	 * @used-by p()
	 * @used-by \Dfe\Dynamics365\API\Client\JSON::validate()
	 * @return C
	 */
	final protected function path() {return $this->_path;}

	/**
	 * 2017-07-02
	 * @param string $r
	 * @return string|mixed
	 */
	protected function postProcess($r) {return $r;}

	/**
	 * 2017-07-02
	 * @param mixed $r
	 * @throws DFE
	 */
	protected function validate($r) {}

	/**
	 * 2017-07-02
	 * @used-by __construct()
	 * @used-by c()
	 * @var C
	 */
	private $_c;

	/**
	 * 2017-07-02
	 * @used-by __construct()
	 * @used-by p()
	 * @var string
	 */
	private $_ckey;

	/**
	 * 2017-07-02
	 * @used-by __construct()
	 * @used-by path()
	 * @var string
	 */
	private $_path;
}