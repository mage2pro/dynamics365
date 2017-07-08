<?php
namespace Dfe\Dynamics365\Settings\General;
use Magento\Framework\App\ScopeInterface as S;
use Magento\Store\Model\Store;
// 2017-04-23
/** @method static OAuth s() */
final class OAuth extends \Df\Config\Settings {
	/**
	 * 2017-06-29
	 * @used-by \Dfe\Dynamics365\Button::getCommentText()
	 * @used-by \Dfe\Dynamics365\Button::getElementHtml()
	 * @return bool
	 */
	function authenticatedB() {return dfc($this, function() {return !!$this->refreshToken(df_scope());});}

	/**
	 * 2017-04-23
	 * @used-by \Dfe\Dynamics365\Button::onFormInitialized()
	 * @return string
	 */
	function clientId() {return $this->v();}

	/**
	 * 2017-04-23
	 * @return string
	 */
	function clientPassword() {return $this->p();}

	/**
	 * 2017-07-08 `My Dynamics 365 instance is self-hosted («on-premises»)`
	 * @used-by url_auth()
	 * @used-by url_token()
	 * @return string
	 */
	function on_premises() {return $this->b();}

	/**
	 * 2017-06-29
	 * 2017-07-02
	 * We do not encrypt the refresh token in the database,
	 * because it is used only with the @see clientPassword(),
	 * which is encrypted in the database.
	 * @see \Dfe\Dynamics365\API\OAuth::apiToken()
	 * @used-by \Dfe\Dynamics365\Button::getCommentText()
	 * @used-by \Dfe\Dynamics365\API\OAuth::token()
	 * @param null|string|int|S|Store|array(string, int) $s [optional]
	 * @return string|null
	 */
	function refreshToken($s = null) {return $this->v(null, $s);}

	/**
	 * 2017-06-29
	 * @see \Magento\Store\Model\ScopeInterface::SCOPE_STORES
	 * @see \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITES
	 * @param string $v
	 * @param string $scope		«default», «websites», or «stores»
	 * @param int $scopeId		E.g.: «0»
	 */
	function refreshTokenSave($v, $scope, $scopeId) {df_cfg_save(
		"{$this->prefix()}/refreshToken", $v, $scope, $scopeId
	);}

	/**
	 * 2017-07-08 «On-premises Token Endpoint»
	 * @used-by \Dfe\Dynamics365\Button::onFormInitialized()
	 * @return string
	 */
	function url_auth() {return $this->on_premises() ? $this->v() : self::$SAAS_URL_BASE . 'authorize';}

	/**
	 * 2017-07-08 «On-premises Token Endpoint»
	 * @used-by \Dfe\Dynamics365\API\OAuth::apiToken()
	 * @return string
	 */
	function url_token() {return $this->on_premises() ? $this->v() : self::$SAAS_URL_BASE . 'token';}

	/**
	 * 2017-04-23
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @used-by refreshTokenSave()
	 * @return string
	 */
	protected function prefix() {return 'df_dynamics365/general/oauth';}

	/**
	 * 2017-07-08
	 * @used-by url_auth()
	 * @used-by url_token()
	 * @var string
	 */
	private static $SAAS_URL_BASE = 'https://login.microsoftonline.com/common/oauth2/';
}