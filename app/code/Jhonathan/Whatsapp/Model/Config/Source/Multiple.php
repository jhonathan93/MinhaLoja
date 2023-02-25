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
 * Class Multiple
 * @package Mageuni\Whatsapp\Model\Config\Source
 */
class Multiple implements OptionSourceInterface
{

    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 1, 'label' => __('Yes')],
            ['value' => 0, 'label' => __('No')]
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return ['Yes' => __('Yes'), 'No' => __('No')];
    }
}
