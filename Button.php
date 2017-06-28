<?php
namespace Dfe\Dynamics365;
use Df\Framework\Form\ElementI;
use Magento\Framework\Data\Form\Element\AbstractElement as AE;
use Magento\Backend\Block\Widget\Button as W;
// 2017-06-26
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Button extends AE implements ElementI {
	/**
	 * 2017-06-27
	 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
	 * @override
	 * @see \Magento\Framework\Data\Form\Element\AbstractElement::getElementHtml()
	 * @used-by \Magento\Framework\Data\Form\Element\AbstractElement::getDefaultHtml()
	 * @return string
	 */
	function getElementHtml() {return df_block(W::class, [
		'id' => $this->getHtmlId(), 'label' => __('Authenticate')
	])->toHtml();}

	/**
	 * 2017-06-27
	 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
	 * @override
	 * @see \Df\Framework\Form\ElementI::onFormInitialized()
	 * @used-by \Df\Framework\Plugin\Data\Form\Element\AbstractElement::afterSetForm()
	 */
	function onFormInitialized() {
		/**
		 * 2017-06-27
		 * This code removes the «[store view]» sublabel, similar to
		 * @see \Magento\MediaStorage\Block\System\Config\System\Storage\Media\Synchronize::render()
		 */
		$this->_data = dfa_unset($this->_data, 'scope', 'can_use_website_value', 'can_use_default_value');
		// 2017-06-27
		// OpenID Connect protocol: https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-openid-connect-code#send-the-sign-in-request
		// OAuth 2.0 auth code grant: https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-oauth-code#request-an-authorization-code
		// «common» is a special tenant identifier value to request a tenant-independent token:
		$isOpenID = false;  /** @var bool $isOpenID */
		$url = 'https://login.microsoftonline.com/common/oauth2/authorize?' . http_build_query(df_clean([
			// 2017-06-27
			// 1) OAuth 2.0 auth code grant: optional.
			// «Provides a hint about the tenant or domain that the user should use to sign in.
			// The value of the `domain_hint` is a registered domain for the tenant.
			// If the tenant is federated to an on-premises directory,
			// AAD redirects to the specified tenant federation server.»
			// 2) OpenID Connect protocol: not used.
			'domain_hint' => null
			// 2017-06-27
			// 1) OAuth 2.0 auth code grant: optional.
			// 2) OpenID Connect protocol: optional.
			// «Can be used to pre-fill the username/email address field of the sign-in page for the user,
			// if you know their username ahead of time.
			// Often apps use this parameter during reauthentication,
			// having already extracted the username from a previous sign-in using the preferred_username claim.»
			,'login_hint' => null
			// 2017-06-27
			// 1) OAuth 2.0 auth code grant: not used.
			// 2) OpenID Connect protocol: required.
			// «A value included in the request, generated by the app,
			// that is included in the resulting id_token as a claim.
			// The app can then verify this value to mitigate token replay attacks.
			// The value is typically a randomized, unique string or GUID
			// that can be used to identify the origin of the request.»
            ,'nonce' => !$isOpenID ? null : df_uid()
			// 2017-06-27
			// 1) OAuth 2.0 auth code grant:
			// «Indicate the type of user interaction that is required.
			// Valid values are:
			// 1.1) `login`: The user should be prompted to reauthenticate.
			// 1.2) `consent`: User consent has been granted, but needs to be updated.
			// The user should be prompted to consent.
			// 1.3) `admin_consent`: An administrator should be prompted to consent
			// on behalf of all users in their organization.»
			// 2) OpenID Connect protocol:
			// «Indicates the type of user interaction that is required.
			// Currently, the only valid values are `login`, `none`, and `consent`.
			// 2.1) `prompt=login` forces the user to enter their credentials on that request,
			// negating single-sign on.
			// 2.2) `prompt=none` is the opposite - it ensures that the user is not presented
			// with any interactive prompt whatsoever.
			// If the request cannot be completed silently via single-sign on, the endpoint returns an error.
			// 2.3) `prompt=consent` triggers the OAuth consent dialog after the user signs in,
			// asking the user to grant permissions to the app.»
			,'prompt' => 'consent'
			// 2017-06-27
			// Recommended.
			// 1) OAuth 2.0 auth code grant:
			// «Specifies the method that should be used to send the resulting token back to your app.
			// Can be `query` or `form_post`.»
			// 2) OpenID Connect protocol:
			// «Specifies the method that should be used to send the resulting authorization_code
			// back to your app.
			// Supported values are `form_post` for HTTP form post or `fragment` for URL fragment.
			// For web applications, we recommend using `response_mode=form_post`
			// to ensure the most secure transfer of tokens to your application.»
            ,'response_mode' => 'form_post'
			// 2017-06-27
			// Note 1.
			// 1.1) OAuth 2.0 auth code grant: «Must include `code` for the authorization code flow.»
			// 1.2) OpenID Connect protocol: «Must include `id_token` for OpenID Connect sign-in.
			// It may also include other response_types, such as code.»
			// Required.
			// Note 2.
			// As I understand from the example below, the value should be space-separared
			// https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-openid-connect-code#get-access-tokens
			// The «scope» parameter uses the same format.
			,'response_type' => $isOpenID ? 'id_token' : 'code'
			// 2017-06-27
			// 1) OAuth 2.0 auth code grant: not used.
			// 2) OpenID Connect protocol: required.
			// «A space-separated list of scopes.
			// For OpenID Connect, it must include the scope `openid`,
			// which translates to the "Sign you in" permission in the consent UI.
			// You may also include other scopes in this request for requesting consent.»
            ,'scope' => !$isOpenID ? null : 'openid'
			// 2017-06-27
			// 1) OAuth 2.0 auth code grant: recommended.
			// 2) OpenID Connect protocol: recommended.
			// «A value included in the request that is also returned in the token response.
			// A randomly generated unique value is typically used
			// for preventing cross-site request forgery attacks.
			// The state is also used to encode information about the user's state in the app
			// before the authentication request occurred, such as the page or view they were on.»
            ,'state' => df_current_url()
		] + OAuth::p()));
		df_fe_init($this, __CLASS__, [], ['url' => $url]);
	}
}

