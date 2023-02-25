<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Model\Method;

use Psr\Log\LoggerInterface;

/**
 * Class Debug
 * @package Jhonathan\ViaCep\Model\Method
 */
class Debug
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger,
    ) {
        $this->logger = $logger;
    }

    /**
     * @param array $data
     * @return void
     */
    public function debug(array $data): void
    {
        $this->logger->debug(var_export($data, true));
    }
}
