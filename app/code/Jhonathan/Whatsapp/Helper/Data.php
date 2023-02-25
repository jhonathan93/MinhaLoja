<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Helper;

use Jhonathan\Core\Helper\Data\AbstractData;
use Jhonathan\ViaCep\Model\Method\Debug;
use Magento\Backend\App\Config;
use Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package Jhonathan\Whatsapp\Helper
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
     * @param string $code
     * @return mixed
     */
    public function isEnabled(string $code): mixed
    {
        return parent::isEnabled($code);
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getContent(string $code): mixed
    {
        return parent::Content($code);
    }

    /**
     * @return string
     */
    public function _getModuleName(): string
    {
        return parent::_getModuleName();
    }

    /**
     * @param array $data
     * @param bool $forceDebug
     * @return void
     */
    public function logger(array $data, bool $forceDebug): void
    {
        if ($forceDebug === true) {
            $this->debug->debug($data);
        }
    }
}
