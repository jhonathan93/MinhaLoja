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
use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Session;

/**
 * Class Taxvat
 * @package Jhonathan\Customer\Block\Widget
 */
class Taxvat extends \Magento\Customer\Block\Widget\Taxvat {

    /**
     * @var Session
     */
    protected $_session;

    /**
     * @param Context $context
     * @param Address $addressHelper
     * @param CustomerMetadataInterface $customerMetadata
     * @param Session $session
     * @param array $data
     */
    public function __construct(Context $context,
                                Address $addressHelper,
                                CustomerMetadataInterface $customerMetadata,
                                Session $session,
                                array $data = []) {
        parent::__construct($context, $addressHelper, $customerMetadata, $data);
        $this->_session = $session;
    }

    /**
     * @return string
     */
    public function getMask(): string {
        if ($this->_session->isLoggedIn()) {
            $doc = $this->_session->getCustomer()->getData('taxvat');
            if (is_null($doc)) {
                return '000.000.000-00';
            } else {
                return preg_replace('/[0-9]/', '0', $doc);
            }
        }
        return '000.000.000-00';
    }
}
