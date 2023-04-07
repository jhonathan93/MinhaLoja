<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_CustomerBlock
 */

namespace Jhonathan\CustomerBlock\Helper;

use Jhonathan\Core\Helper\Data\AbstractData;
use Jhonathan\CustomerBlock\Model\Method\Debug;
use Magento\Backend\App\Config;
use Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package Jhonathan\CustomerBlock\Helper
 */
class Data extends AbstractData
{
    /**
     * @var Debug
     */
    public Debug $debug;

    public function __construct(Context $context, Config $config, Debug $debug)
    {
        parent::__construct($context, $this->_getModuleName(), $config);
        $this->debug = $debug;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return parent::isEnabled();
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function content(string $code): mixed
    {
        return parent::content($code);
    }

    /**
     * @param array $data
     * @param bool $forceDebug
     * @return void
     */
    public function logger(array $data, bool $forceDebug): void
    {
        if ($forceDebug === true || (bool)$this->content('logging/enabled') === true) {
            $this->debug->debug($data);
        }
    }
}
