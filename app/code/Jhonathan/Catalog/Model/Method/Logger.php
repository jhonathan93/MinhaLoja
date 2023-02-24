<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\Catalog\Model\Method;

use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package Jhonathan\Catalog\Model\Method
 */
class Logger {

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @param array $data
     * @param bool|null $forceDebug
     * @return void
     */
    public function debug(array $data, bool $forceDebug = null): void {
        if ($forceDebug === true) {
            $this->logger->debug(var_export($data, true));
        }
    }
}
