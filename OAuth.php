<?php
namespace Dfe\Dynamics365;
use Dfe\Dynamics365\Settings\General\OAuth as S;
// 2017-06-28
final class OAuth {
	/**
	 * 2017-06-28
	 * @used-by \Dfe\Dynamics365\Button::onFormInitialized()
	 * @used-by \Dfe\Dynamics365\Controller\Adminhtml\OAuth\Index::_execute()
	 * @return array(string => string)
	 */
	static function p() {/** @var S $s */ $s = S::s(); return df_clean([
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
}