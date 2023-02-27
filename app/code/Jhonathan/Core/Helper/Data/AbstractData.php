<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Core
 */

namespace Jhonathan\Core\Helper\Data;

use Magento\Backend\App\Config;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AbstractData
 * @package Jhonathan\Core\Helper\Data
 */
class AbstractData extends AbstractHelper
{

    /**
     * @var string
     */
    private string $module;

    /**
     * @var Config
     */
    protected Config $backendConfig;

    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;

    /**
     * @param Context $context
     * @param string $module
     * @param Config $config
     */
    public function __construct(Context $context, string $module, Config $config)
    {
        parent::__construct($context);
        $this->module = strtolower($module);
        $this->backendConfig = $config;
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function isEnabled(string $code): mixed
    {
        return $this->getConfigGeneral($code, $this->getStoreId());
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function content(string $code): mixed
    {
        return $this->getConfigGeneral($code, $this->getStoreId());
    }

    /**
     * @param string $code
     * @param int|null $storeId
     * @return mixed
     */
    public function getConfigGeneral(string $code, int $storeId = null): mixed
    {
        return $this->getConfigValue($this->module . '/' . $code, $storeId);
    }

    /**
     * @param $field
     * @param null $scopeValue
     * @param string $scopeType
     * @return array|mixed
     */
    public function getConfigValue($field, $scopeValue = null, string $scopeType = ScopeInterface::SCOPE_STORE): mixed
    {
        if ($scopeValue === null) {
            return $this->backendConfig->getValue($field);
        }

        return $this->scopeConfig->getValue($field, $scopeType, $scopeValue);
    }

    /**
     * @return int|null
     */
    public function getStoreId(): ?int
    {
        try {
            /** @var StoreManagerInterface $storeManager */
            $storeManager = $this->objectManager->create(StoreManagerInterface::class);
            return $storeManager->getStore()->getWebsiteId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
