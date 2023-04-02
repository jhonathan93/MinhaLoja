<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ProgressBar
 */

namespace Jhonathan\ProgressBar\Helper;

use Jhonathan\Core\Helper\Data\AbstractData;
use Jhonathan\ProgressBar\Model\Method\Debug;
use Magento\Backend\App\Config;
use Magento\Framework\App\Helper\Context;

/**
 * class ProgressBar
 * @package Jhonathan\ProgressBar\Model
 */
class Data extends AbstractData
{
    /**
     * @var Debug
     */
    private Debug $debug;

    /**
     * @param Context $context
     * @param Config $config
     * @param Debug $debug
     */
    public function __construct(Context $context, Config $config, Debug $debug)
    {
        parent::__construct($context, $this->_getModuleName(), $config);
        $this->debug = $debug;
    }

    /**
     * @return bool
     */
    public function IsFreShippingActive(): bool
    {
        return (bool)$this->getAnyConfigValue('carriers/freeshipping/active');
    }

    /**
     * @return string
     */
    public function getValueFreeShipping(): string
    {
        return (string)$this->getAnyConfigValue('carriers/freeshipping/free_shipping_subtotal');
    }

    /**
     * @return array
     */
    public function getColors(): array
    {
        return [
            'text' => $this->content('settings/text_color'),
            'color1' => $this->content('settings/color1'),
            'color2' => $this->content('settings/color2')
        ];
    }

    /**
     * @param array $data
     * @param bool $forceDebug
     * @return void
     */
    public function logger(array $data, bool $forceDebug): void
    {
        if ($forceDebug === true || (bool)$this->isEnabled('logging/enabled') === true) {
            $this->debug->debug($data);
        }
    }
}
