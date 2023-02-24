<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Jhonathan\Core\Helper\Data\AbstractData;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Backend\App\ConfigInterface;

use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Class Data
 * @package Jhonathan\Whatsapp\Helper
 */
class Data extends AbstractData {

    /**
     * @var string
     */
    const GROUPGENERAL = "general";

    /**
     * @var string
     */
    const GROUPSETTINGS = "settings";

    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;

    /**
     * @param Context $context
     * @param ConfigInterface $config
     */
    public function __construct(Context $context, ConfigInterface $config) {
        parent::__construct($context, $this->_getModuleName(), $config);
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @param string $group
     * @param $code
     * @param $storeId
     * @return array|mixed
     */
    public function isEnabled($group = null, $code = null, $storeId = null): mixed {
        $storeId = $this->getStoreId($storeId);
        return parent::isEnabled(self::GROUPGENERAL, 'enabled', $storeId);
    }

    /**
     * @param string $code
     * @param null $storeId
     * @return array|mixed
     */
    public function getContent(string $code, $storeId = null): mixed {
        $storeId = $this->getStoreId($storeId);
        return parent::Content($code, self::GROUPSETTINGS, $storeId);
    }

    /**
     * @param $storeId
     * @return false|int
     */
    public function getStoreId($storeId): bool|int {
        try {
            if (is_null($storeId)) {
                $storeManager = $this->objectManager->create(StoreManagerInterface::class);
                return $storeManager->getStore()->getWebsiteId();
            }
            return $storeId;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function _getModuleName(): string {
        return parent::_getModuleName();
    }

    /**
     * @return LoggerInterface
     */
    public function logger(): LoggerInterface {
        return $this->_logger;
    }
}
