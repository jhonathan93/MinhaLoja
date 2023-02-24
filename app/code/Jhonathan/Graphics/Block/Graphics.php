<?php

/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Graphics
 */

namespace Jhonathan\Graphics\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Graphics
 * @package Jhonathan\Graphics\Block
 */
class Graphics extends Template {

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = []) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getHelloWorldTxt(): string {
        return 'Hello world!';
    }
}
