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
namespace Dfe\Dynamics365\Controller\OAuth;
/**
 * 2017-06-27
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * We get a response like:
 * 	{
 * 		"code": <a string of 611 caracters>,
 * 		"session_state": "4be3f979-ebcd-4846-9898-6cf007756456"
 * 	}
 * https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#successful-response
 */
class Index extends \Df\OAuth\ReturnT {
	/**
	 * 2017-06-27
	 * @override
	 * @see \Df\OAuth\ReturnT::_execute()
	 * @used-by \Df\OAuth\ReturnT::execute()
	 */
	final protected function _execute() {
		/**
		 * 2017-06-28
		 * @var string $code
		 * A string of 611 caracters.
		 * «The authorization code that the application requested.
		 * The application can use the authorization code to request an access token for the target resource.»
		 */
		$code = df_request('code');
		/**
		 * 2017-06-28
		 * @var string $state
		 * A string like «4be3f979-ebcd-4846-9898-6cf007756456».
		 * «The authorization code that the application requested.
		 * The application can use the authorization code to request an access token for the target resource.»
		 */
		$sessionState = df_request('session_state');
		df_log_l($this, [$code, $sessionState]);
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
}