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
		 * This code removes the [store view] sublabel.
		 * Similar to @see \Magento\MediaStorage\Block\System\Config\System\Storage\Media\Synchronize::render()
		 */
		$this->_data = dfa_unset($this->_data, 'scope', 'can_use_website_value', 'can_use_default_value');
		df_fe_init($this, __CLASS__);
	}
}

