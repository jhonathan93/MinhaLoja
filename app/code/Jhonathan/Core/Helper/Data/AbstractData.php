<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Core
 */

namespace Jhonathan\Core\Helper\Data;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Backend\App\ConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Backend\App\Config;

/**
 * Class AbstractData
 * @package Jhonathan\RibbonMarketing\Helper
 */
class AbstractData extends AbstractHelper {

    /**
     * @var string
     */
    private string $module;

    /**
     * @var Config
     */
    protected Config $backendConfig;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @param Context $context
     * @param string $module
     * @param ConfigInterface $config
     */
    public function __construct(Context $context, string $module, ConfigInterface $config) {
        parent::__construct($context);
        $this->config = $config;
        $this->module = $module;
    }

    /**
     * @param $group
     * @param $code
     * @param $storeId
     * @return array|mixed
     */
    public function isEnabled($group = null, $code = null, $storeId = null): mixed {
        return $this->getConfigGeneral($code, $group, $storeId);
    }

    /**
     * @param string $code
     * @param string $group
     * @param null $storeId
     * @return array|mixed
     */
    public function content(string $code, string $group, $storeId = null): mixed {
        return $this->getConfigGeneral($code, $group, $storeId);
    }

    /**
     * @param string $code
     * @param string $group
     * @param null $storeId
     * @return array|mixed
     */
    public function getConfigGeneral(string $code, string $group, $storeId = null): mixed {
        $code = '/' . $code;
        $group = '/' . $group;
        return $this->getConfigValue($this->module . $group . $code, $storeId);
    }

    /**
     * @param $field
     * @param null $scopeValue
     * @param string $scopeType
     * @return array|mixed
     */
    public function getConfigValue($field, $scopeValue = null, string $scopeType = ScopeInterface::SCOPE_STORE): mixed {
        if ($scopeValue === null) {
            if (!$this->backendConfig) {
                $this->backendConfig = $this->config;
            }

            return $this->backendConfig->getValue($field);
        }

        return $this->scopeConfig->getValue($field, $scopeType, $scopeValue);
    }
}
