<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Select
 * @package Mageuni\Whatsapp\Model\Config\Source
 */
class Select implements OptionSourceInterface
{

    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'left', 'label' => __('left')],
            ['value' => 'right', 'label' => __('right')]
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return ['left' => __('left'), 'right' => __('right')];
    }
}
