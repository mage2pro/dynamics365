<?php
namespace Dfe\Dynamics365;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
// 2017-06-28
final class OAuth {
	/**
	 * 2017-06-30
	 * @param string $path
	 * @param string $method [optional]
	 * @param array(string => mixed) $p [optional]
	 * @return array(string => mixed)
	 */
	static function r($path, $method = C::GET, array $p = []) {
		/** @var C $c */
		$c = (new C)
			->setConfig(['timeout' => 120])
			->setHeaders([
				'Accept' => 'application/json'
				,'Authorization' => 'Bearer ' . self::token()
				,'OData-MaxVersion' => '4.0'
				,'OData-Version' => '4.0'
			])
			->setMethod($method)
			->setUri(S::s()->url() . $path)
		;
		C::GET === $method ? $c->setParameterGet($p) : $c->setParameterPost($p);
		return df_json_decode($c->request()->getBody());
	}

	/**
	 * 2017-06-29
	 * Note 1.
	 * «An OAuth 2.0 refresh token.
	 * The app can use this token to acquire additional access tokens
	 * after the current access token expires.
	 * Refresh tokens are long-lived,
	 * and can be used to retain access to resources for extended periods of time.»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response-1
	 * Note 2.
	 * «Refresh tokens do not have specified lifetimes.
	 * Typically, the lifetimes of refresh tokens are relatively long.
	 * However, in some cases, refresh tokens expire, are revoked,
	 * or lack sufficient privileges for the desired action.
	 * Your application needs to expect and handle errors
	 * returned by the token issuance endpoint correctly.»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#refreshing-the-access-tokens
	 * Note 3 (mine). It is string of 824 caracters.
	 * @var string $refreshToken
	 * @param string $code
	 * @return string
	 * @throws DFE
	 */
	static function tokenR($code) {return self::apiToken([
		// 2017-06-28
		// Required
		// 1) «The `authorization_code` that you acquired in the previous section».
		// «Use the authorization code to request an access token»: https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#use-the-authorization-code-to-request-an-access-token
		// 2) «The authorization code that the application requested.
		// The application can use the authorization code
		// to request an access token for the target resource.»
		// «Successful response»: https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response
		// 3) My note: a string of 611 caracters.
		'code' => $code
		// 2017-06-28
		// Required.
		// «Must be `authorization_code` for the authorization code flow».
		,'grant_type' => 'authorization_code'
	])['refresh_token'];}

	/**
	 * 2017-06-28
	 * @used-by apiToken()
	 * @used-by \Dfe\Dynamics365\Button::onFormInitialized()
	 * @return array(string => string)
	 */
	static function tokenP() {/** @var S $s */ $s = S::s(); return df_clean([
		// 2017-06-27
		// 1) OAuth 2.0 auth code grant:
		// «The Application Id assigned to your app when you registered it with Azure AD.
		// You can find this in the Azure Portal.
		// Click `Active Directory`, click the directory, choose the application, and click `Configure`.»
		// 2) OpenID Connect protocol:
		// «The Application Id assigned to your app when you registered it with Azure AD.
		// You can find this in the Azure Portal.
		// Click `Azure Active Directory`, click `App Registrations`, choose the application
		// and locate the Application Id on the application page.»
		// Required.
		// «How to grant Magento 2 the permissions to access the Dynamics 365 web API?»
		// https://mage2.pro/t/3825
		'client_id' => $s->clientId()
		/**
		 * 2017-06-27
		 * Note 1.
		 * 1.1) OAuth 2.0 auth code grant: recommended.
		 * 1.2) OpenID Connect protocol: recommended.
		 * «The `redirect_uri` of your app,
		 * where authentication responses can be sent and received by your app.
		 * It must exactly match one of the `redirect_uris` you registered in the portal,
		 * except it must be url encoded.»
		 * Note 2.
		 * It uses the same algorithm as in @see \Df\Sso\FE\CustomerReturn::url()
		 * https://github.com/mage2pro/dynamics365/blob/0.0.5/etc/adminhtml/system.xml#L102
		 * https://github.com/mage2pro/dynamics365/blob/0.0.5/etc/adminhtml/system.xml#L105
		 * https://github.com/mage2pro/core/blob/2.7.23/Sso/FE/CustomerReturn.php#L28-L30
		 */
		,'redirect_uri' => df_url_backend_ns(df_route(__CLASS__, 'oauth', true))
		/**
		 * 2017-06-27   
		 * Note 1.
		 * 1.1) OAuth 2.0 auth code grant: optional.
		 * «The `App ID URI` of the web API (secured resource).
		 * To find the `App ID URI` of the web API, in the Azure Portal,
		 * click `Active Directory`, click the directory,
		 * click the application and then click `Configure`.»
		 * 1.2) OpenID Connect protocol: not used.
		 * Note 2.
		 * «How to find out the `App ID URI` of your Microsoft Azure Active Directory application?»
		 * https://mage2.pro/t/4108
		 * For my application it looks like:
		 * «https://mage2pro.onmicrosoft.com/cec9314d-df39-4163-b3ce-9cee8a393cf0»
		 * 2017-06-28
		 * Note 1.
		 * The documentation says the parameter is optional, but if I omit it,
		 * the «Use the authorization code to request an access token» step
		 * leads to the «AADSTS50001: Resource identifier is not provided» error:
		 * @see \Dfe\Dynamics365\Controller\Adminhtml\OAuth\Index::_execute()
		 * Note 2.
		 * The `App ID URI` also does not work for me,
		 * it leads to the «AADSTS90009: Application <...> is requesting a token for itself» error.
		 * Note 3.
		 * It looks like it should be the root URL of the Dynamics 365 frontend:
		 * http://sharpshooting.github.io/authentication/2015/03/24/oauth2-on-dynamics-crm-online.html
		 * Where is my Dynamics 365 frontend located? https://mage2.pro/t/3737
		 */
		,'resource' => $s->url()
	]);}

	/**
	 * 2017-06-28
	 * @used-by apiToken()
	 * @used-by \Dfe\Dynamics365\Controller\Adminhtml\OAuth\Index::_execute()
	 * @param array(string => mixed)|null $r [optional]
	 * @throws DFE
	 */
	static function validateResponse($r = null) {
		if (is_null($r)) {
			$r = df_request();
		}
		if ($error = dfa($r, 'error')) {
			df_error_html("[<b>$error</b>] %s", nl2br(dfa($r, 'error_description')));
		}
	}

	/**
	 * 2017-06-30
	 * @used-by token()
	 * @used-by tokenR()
	 * @param array(string => string) $key
	 * @return array(string => mixed)
	 * @throws DFE
	 */
	private static function apiToken(array $key) {
		// 2017-06-28
		// «Now that you've acquired an authorization code and have been granted permission by the user,
		// you can redeem the code for an access token to the desired resource,
		// by sending a POST request to the `/token` endpoint.»
		// «Use the authorization code to request an access token»:
		// https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#use-the-authorization-code-to-request-an-access-token
		/** @var C $c */
		$c = (new C)
			->setConfig(['timeout' => 120])
			->setHeaders(['accept' => 'application/json'])
			->setMethod(C::POST)
			->setParameterPost(self::tokenP() + $key + [
				'client_secret' => S::s()->clientPassword()

			])
			// 2017-06-30
			// @todo Whether it works for an on-premises Dynamics 365 instance?
			// I do not have an on-premises instance, so I am unable to test it... :-(
			// «OAuth authorization endpoints» https://msdn.microsoft.com/en-us/library/dn531009.aspx#Anchor_7
			->setUri('https://login.microsoftonline.com/common/oauth2/token')
		;
		/**
		 * 2017-06-28
		 * A successful response looks like:
		 *	{
		 *		"token_type": "Bearer",
		 *		"scope": "user_impersonation",
		 *		"expires_in": "3600",
		 *		"ext_expires_in": "0",
		 *		"expires_on": "1498666110",
		 *		"not_before": "1498662210",
		 *		"resource": "https://mage2.crm.dynamics.com",
		 *		"access_token": <a string of 446 caracters>,
		 *		"refresh_token": <a string of 824 caracters>,
		 *		"id_token": <a string of 697 caracters>
		 *	}
		 * An error response looks like:
		 *	{
		 *		"error": "invalid_resource",
		 *		"error_description": "AADSTS50001: Resource identifier is not provided.\r\nTrace ID: b4546deb-82b7-410a-b79d-191380244200\r\nCorrelation ID: 0dcc3112-7b8d-4010-9e06-60f046132fea\r\nTimestamp: 2017-06-28 14:35:58Z",
		 *		"error_codes": [
		 *			50001
		 *		],
		 *		"timestamp": "2017-06-28 14:35:58Z",
		 *		"trace_id": "b4546deb-82b7-410a-b79d-191380244200",
		 *		"correlation_id": "0dcc3112-7b8d-4010-9e06-60f046132fea"
		 *	}
		 * @var array(string => mixed) $r
		 */
		$r = df_json_decode($c->request()->getBody());
		self::validateResponse($r);
		return $r;
	}

	/**
	 * 2017-06-29
	 * Note 1.
	 * «The requested access token.
	 * The app can use this token to authenticate to the secured resource, such as a web API.»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response-1
	 * Note 2.
	 * «Access Tokens are short-lived
	 * and must be refreshed after they expire to continue accessing resources.
	 * You can refresh the access_token by submitting another POST request to the `/token` endpoint,
	 * but this time providing the `refresh_token` instead of the `code`.»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#refreshing-the-access-tokens
	 * Note 3 (mine). It is string of 446 caracters.
	 * Note 4.
	 * «Azure AD returns an access token upon a successful response.
	 * To minimize network calls from the client application and their associated latency,
	 * the client application should cache access tokens for the token lifetime
	 * that is specified in the OAuth 2.0 response.
	 * To determine the token lifetime, use either the `expires_in` or `expires_on` parameter values.
	 * If a web API resource returns an `invalid_token` error code,
	 * this might indicate that the resource has determined that the token is expired.
	 * If the client and resource clock times are different (known as a "time skew"),
	 * the resource might consider the token to be expired
	 * before the token is cleared from the client cache.
	 * If this occurs, clear the token from the cache, even if it is still within its calculated lifetime.»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response-1
	 * @used-by r()
	 * @return string
	 * @throws DFE
	 */
	private static function token() {
		/** @var string|null $r */
		static $r;
		/** @var int $expiration */
		static $expiration;
		if ($r && time() > $expiration) {
			$r = null;
		}
		if (!$r) {
			/** @var array(string => mixed) $a */
			$a = self::apiToken(['grant_type' => 'refresh_token', 'refresh_token' => S::s()->refreshToken()]);
			$r = $a['access_token'];
			$expiration = time() + round(0.8 * $a['expires_in']);
		}
		return $r;
	}
}