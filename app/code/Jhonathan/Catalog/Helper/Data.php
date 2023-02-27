<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Helper;

use Jhonathan\Core\Helper\Data\AbstractData;
use Magento\Backend\App\Config;
use Magento\Framework\App\Helper\Context;
use Jhonathan\Catalog\Model\Method\Debug;

/**
 * Class AbstractData
 * @package Jhonathan\Catalog\Helper
 */
class Data extends AbstractData
{
    /**
     * @var Debug
     */
    public Debug $debug;

    /**
     * @param Context $context
     * @param Config $config
     * @param Debug $debug
     */
    public function __construct(Context $context, Config $config, Debug $debug)
    {
        parent::__construct($context, parent::_getModuleName(), $config);
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
