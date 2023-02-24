<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Block\Adminhtml;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;

/**
 * Class Mask
 * @package Jhonathan\Whatsapp\Block\Adminhtml
 */
class Mask extends Field {

    /**
     * Color constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = []) {
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string {
        $html = $element->getElementHtml();

        $html .= '<script type="text/javascript">
            require(["jquery", "js_mask"], ($) => {
               $("#' . $element->getHtmlId() . '").mask("(00) 00000-0000");
            });
        </script>';

        return $html;
    }
}
