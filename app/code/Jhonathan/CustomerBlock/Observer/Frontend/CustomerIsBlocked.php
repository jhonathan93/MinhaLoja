<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_CustomerBlock
 */

namespace Jhonathan\CustomerBlock\Observer\Frontend;

use Jhonathan\CustomerBlock\Helper\Data;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

use Magento\Framework\Message\ManagerInterface;

/**
 * Class CustomerIsBlocked
 * @package Jhonathan\CustomerBlock\Model\Config\Source
 */
class CustomerIsBlocked implements ObserverInterface
{

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @var Data
     */
    private Data $helperData;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param Session $customerSession
     * @param ManagerInterface $messageManager
     * @param Data $helperData
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        Session $customerSession,
        ManagerInterface $messageManager,
        Data $helperData
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->helperData = $helperData;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        if ($this->helperData->isEnabled()) {
            /** @var $customer Customer */
            $customer = $observer->getData('customer');

            try {
                $customer = $this->customerRepository->getById($customer->getId());
                $attribute = $customer->getCustomAttribute('is_blocked');

                if (!is_null($attribute)) {
                    $this->helperData->logger(["customer" => ['email' => $customer->getEmail(), 'is_blocked' => (int)$attribute->getValue()]], false);
                    if ((int)$attribute->getValue()) {
                        $this->messageManager->addWarningMessage($this->helperData->content('settings/message'));
                        $this->customerSession->logout();
                    }
                }
            } catch (LocalizedException | NoSuchEntityException $e) {
                $this->helperData->logger(["error" => $e->getMessage()], true);
            }
        }
    }
}
