<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Model\Method;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package Jhonathan\ViaCep\Model\Method
 */
class Logger {

    /**
     * @var string
     */
    const XML_PATH_LOG_ENABLED = 'jhonathan_viacep/logging/enabled';

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(LoggerInterface $logger,
                                ScopeConfigInterface $scopeConfig) {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param array $data
     * @param bool|null $forceDebug
     * @return void
     */
    public function debug(array $data, bool $forceDebug = null): void {
        if ($forceDebug === true || $this->isDebugOn() === true) {
            $this->logger->debug(var_export($data, true));
        }
    }

    /**
     * @return bool
     */
    private function isDebugOn(): bool {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_LOG_ENABLED);
    }
}
