<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Customer
 */

namespace Jhonathan\ViaCep\Block\Widget;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Magento\Customer\Helper\Address;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Zip
 * @package Jhonathan\ViaCep\Block\Zip
 */
class Zip extends AbstractWidget
{

    /**
     * @param Context $context
     * @param Address $addressHelper
     * @param CustomerMetadataInterface $customerMetadata
     * @param array $data
     */
    public function __construct(
        Context $context,
        Address $addressHelper,
        CustomerMetadataInterface $customerMetadata,
        array $data = []
    ) {
        parent::__construct($context, $addressHelper, $customerMetadata, $data);
    }

    /**
     * Sets the template
     * @return void
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->setTemplate('Jhonathan_ViaCep::widget/zip.phtml');
    }

    /**
     * @param string $attributeCode
     * @return string
     */
    public function getStoreLabel(string $attributeCode): string
    {
        $attribute = $this->_getAttribute($attributeCode);
        return $attribute ? __($attribute->getStoreLabel()) : 'CEP';
    }
}
