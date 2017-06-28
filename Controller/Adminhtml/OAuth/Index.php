<?php
/**
 * 2017-06-27
 * We can use «OAuth» namespace instead of «Oauth», because @see \Magento\Framework\App\Router\ActionList::get()
 * uses @see strtolower for the controller names:
 *	$fullPath = str_replace(
 *		'_', '\\', strtolower($module . '\\controller' . $area . '\\' . $namespace . '\\' . $action)
 *	);
 * https://github.com/magento/magento2/blob/2.2.0-RC1.1/lib/internal/Magento/Framework/App/Router/ActionList.php#L100-L109
 */
namespace Dfe\Dynamics365\Controller\Adminhtml\OAuth;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\OAuth;
use Dfe\Dynamics365\Settings\General\OAuth as S;
use Zend_Http_Client as C;
/**
 * 2017-06-27
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * A successful response looks like:
 * 	{
 * 		"code": <a string of 611 caracters>,
 * 		"session_state": "4be3f979-ebcd-4846-9898-6cf007756456"
 * 	}
 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response
 * 2017-06-28
 * An error response looks like:
 *	{
 *		"error": "invalid_resource",
 *		"error_description": "AADSTS50001: The application named fuck was not found in the tenant named 339d1fa5-ce36-49af-b239-2e18f779a1cd.  This can happen if the application has not been installed by the administrator of the tenant or consented to by any user in the tenant.  You might have sent your authentication request to the wrong tenant.\r\nTrace ID: 4c2c9284-979c-4d9f-9cfc-744293fa2c00\r\nCorrelation ID: 6bb133f9-1940-4e98-994a-c697bc8bcd48\r\nTimestamp: 2017-06-28 00:14:23Z",
 *		"state": "https://localhost.com:900/store/Zudra5uW/admin/system_config/edit/section/df_dynamics365/"
 *	}
 */
class Index extends \Df\OAuth\ReturnT {
	/**
	 * 2017-06-27
	 * @override
	 * @see \Df\OAuth\ReturnT::_execute()
	 * @used-by \Df\OAuth\ReturnT::execute()
	 * @throws DFE
	 */
	final protected function _execute() {
		$this->checkResponse();
		/**
		 * 2017-06-28
		 * @var string $state
		 * A string like «4be3f979-ebcd-4846-9898-6cf007756456».
		 * «The authorization code that the application requested.
		 * The application can use the authorization code to request an access token for the target resource.»
		 */
		$sessionState = df_request('session_state');
		df_log_l($this, $_REQUEST);
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
			->setParameterPost(OAuth::p() + [
				'client_secret' => S::s()->clientPassword()
				// 2017-06-28
				// Required
				// 1) «The `authorization_code` that you acquired in the previous section».
				// «Use the authorization code to request an access token»: https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#use-the-authorization-code-to-request-an-access-token
				// 2) «The authorization code that the application requested.
				// The application can use the authorization code
				// to request an access token for the target resource.»
				// «Successful response»: https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response
				// 3) My note: a string of 611 caracters.
				,'code' => df_request('code')
				// 2017-06-28
				// Required.
				// «Must be `authorization_code` for the authorization code flow».
				,'grant_type' => 'authorization_code'
			])
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
		$this->checkResponse($r);
		df_log_l($this, $r);
	}

	/**
	 * 2017-06-28
	 * «A value included in the request that is also returned in the token response.»
	 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#request-an-authorization-code
	 * @override
	 * @see \Df\OAuth\ReturnT::redirectUrlKey()
	 * @used-by \Df\OAuth\ReturnT::execute()
	 * @return string
	 */
	protected function redirectUrlKey() {return 'state';}

	/**
	 * 2017-06-28
	 * @used-by _execute()
	 * @param array(string => mixed)|null $r [optional]
	 * @throws DFE
	 */
	private function checkResponse($r = null) {
		if (is_null($r)) {
			$r = df_request();
		}
		if ($error = dfa($r, 'error')) {
			df_error_html("[<b>$error</b>] %s", nl2br(dfa($r, 'error_description')));
		}
	}
}