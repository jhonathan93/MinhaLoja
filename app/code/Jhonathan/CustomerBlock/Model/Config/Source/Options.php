<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_CustomerBlock
 */

namespace Jhonathan\CustomerBlock\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Options
 * @package Jhonathan\CustomerBlock\Model\Config\Source
 */
class Options extends AbstractSource
{

    /**
     * @return array[]
     */
    public function getAllOptions(): array
    {
        $this->_options = [
            ['label' => __('Yes'), 'value'=> 1],
            ['label' => __('No'), 'value'=> 0]
        ];

        return $this->_options;
    }
}
