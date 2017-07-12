<?php
namespace Dfe\Dynamics365;
// 2017-06-26
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Button extends \Df\OAuth\FE\Button {
	/**
	 * 2017-07-11
	 * @override
	 * @see \Df\OAuth\FE\Button::kExpiration()
	 * @used-by \Df\OAuth\FE\Button::token()
	 * @return bool
	 */
	final protected function kExpiration() {return 'expires_in';}

	/**
	 * 2017-07-10
	 * «Request an authorization code -
	 * Authorize access to web applications using OAuth 2.0 and Azure Active Directory»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#request-an-authorization-code
	 * @override
	 * @see \Df\OAuth\FE\Button::pExtra()
	 * @used-by \Df\OAuth\FE\Button::onFormInitialized()
	 * @return array(string => mixed)
	 */
	final protected function pExtra() {return df_clean([
		// 2017-06-27
		// «Provides a hint about the tenant or domain that the user should use to sign in.
		// The value of the `domain_hint` is a registered domain for the tenant.
		// If the tenant is federated to an on-premises directory,
		// AAD redirects to the specified tenant federation server.»
		'domain_hint' => null
		// 2017-06-27
		// «Specifies the method that should be used to send the resulting token back to your app.
		// Can be `query` or `form_post`.»
		// Recommended.
		,'response_mode' => 'form_post'
	]);}
}

