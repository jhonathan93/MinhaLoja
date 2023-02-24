<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Customer
 */

namespace Jhonathan\Customer\Block\Widget;

use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Data\Form\FilterFactory;
use Magento\Framework\View\Element\Html\Date;
use Magento\Framework\Json\EncoderInterface;
use Magento\Customer\Helper\Address;

/**
 * Class Dob
 * @package Jhonathan\Customer\Block\Widget
 */
class Dob extends \Magento\Customer\Block\Widget\Dob {

    /**
     * @param Context $context
     * @param Address $addressHelper
     * @param CustomerMetadataInterface $customerMetadata
     * @param Date $dateElement
     * @param FilterFactory $filterFactory
     * @param array $data
     * @param EncoderInterface|null $encoder
     * @param ResolverInterface|null $localeResolver
     */
    public function __construct(Context $context,
                                Address $addressHelper,
                                CustomerMetadataInterface $customerMetadata,
                                Date $dateElement,
                                FilterFactory $filterFactory,
                                array $data = [],
                                ?EncoderInterface $encoder = null,
                                ?ResolverInterface $localeResolver = null) {
        parent::__construct($context, $addressHelper, $customerMetadata, $dateElement, $filterFactory, $data, $encoder, $localeResolver);
    }

    /**
     * @return string
     */
    public function getMask(): string {
        return '00/00/0000';
    }
}
