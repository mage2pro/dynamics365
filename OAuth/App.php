<?php
namespace Dfe\Dynamics365\OAuth;
use Df\Core\Exception as DFE;
use Dfe\Dynamics365\Settings\General as G;
use Dfe\Dynamics365\Settings\General\OAuth as S;
// 2017-06-28
final class App extends \Df\OAuth\App {
	/**
	 * 2017-06-28
	 * @override
	 * @see \Df\OAuth\App::pCommon()
	 * @used-by \Df\OAuth\App::requestToken()
	 * @used-by \Df\OAuth\FE\Button::onFormInitialized()
	 * @return array(string => string)
	 */
	function pCommon() {return parent::pCommon() + [
		/**
		 * 2017-06-27
		 * Note 1.
		 * «The `App ID URI` of the web API (secured resource).
		 * To find the `App ID URI` of the web API, in the Azure Portal,
		 * click `Active Directory`, click the directory,
		 * click the application and then click `Configure`.»
		 * Optional.
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
		'resource' => G::s()->url()
	];}
	
	/**
	 * 2017-07-10
	 * @override
	 * @see \Df\OAuth\App::ss()
	 * @used-by urlAuth()
	 * @used-by urlToken()
	 * @used-by \Df\OAuth\App::getAndSaveTheRefreshToken()
	 * @used-by \Df\OAuth\App::pCommon()
	 * @used-by \Df\OAuth\App::requestToken()
	 * @used-by \Df\OAuth\App::token()
	 * @used-by \Df\OAuth\FE\Button::s()
	 * @return S
	 */
	function ss() {return S::s();}

	/**
	 * 2017-07-10
	 * @override
	 * @see \Df\OAuth\App::urlAuth()
	 * @used-by \Df\OAuth\FE\Button::onFormInitialized()
	 * @return string
	 */
	function urlAuth() {return $this->ss()->url_auth();}

	/**
	 * 2017-07-11
	 * @override
	 * @see \Df\OAuth\App::urlToken()
	 * @used-by \Df\OAuth\App::requestToken()
	 * @return string
	 */
	protected function urlToken() {return $this->ss()->url_token();}
}