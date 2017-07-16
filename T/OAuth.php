<?php
namespace Dfe\Dynamics365\T;
use Dfe\Dynamics365\Settings\General as G;
use Zend_Http_Client as C;
// 2017-07-08
final class OAuth extends TestCase {
	/** @test 2017-07-08 */
	function t00() {}

	/**
	 * 2017-07-08
	 * «Discover the OAuth endpoint URL»
	 * https://msdn.microsoft.com/en-us/library/dn531009.aspx#bkmk_oauth_discovery
	 */
	function discovery() {
		/** @var C $c */
		$c = df_zf_http(G::s()->url() . '/XRMServices/2011/Organization.svc')
			->setConfig(['timeout' => 120])
			// 2017-07-08
			// «The discovery process is started by sending an unauthorized HTTP request
			// with the word “Bearer” in the Authorization header.»
			// «The bearer challenge is now optional.
			// Doing a GET without an authorization header yields the same results.»
			->setHeaders(['Authorization' => 'Bearer'])
		;
		echo df_dump($c->request()->getHeaders());
	}
}