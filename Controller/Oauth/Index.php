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
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Index extends \Df\OAuth\ReturnT {
	/**
	 * 2017-06-27
	 * @override
	 * @see \Df\OAuth\ReturnT::_execute()
	 */
	final protected function _execute() {}
}