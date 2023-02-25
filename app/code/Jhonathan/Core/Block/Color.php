<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Core
 */

namespace Jhonathan\Core\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Color
 * @package Jhonathan\Core\Block
 */
class Color extends Field
{

    /**
     * Color constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = $element->getElementHtml();
        $value = $element->getData("value");

        $html .=
            '<script type="text/javascript">
                require(["jquery", "jquery/colorpicker/js/colorpicker"], ($) => {
                    $(document).ready(() => {
                        let $el = $("#' . $element->getHtmlId() . '");
                        $el.css("backgroundColor", "' . $value . '");
    
                        $el.ColorPicker({
                            color: "' . $value . '",
                            onChange: function (hsb, hex) {
                                $el.css("backgroundColor", "#" + hex).val("#" + hex);
                            }
                        });
                    });
                });
            </script>';
        return $html;
    }
}
