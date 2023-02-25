<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Block\Adminhtml\Grid\Renderer;

use Magento\Framework\View\Element\Template;

/**
 * Class Mask
 * @package Jhonathan\Whatsapp\Block\Adminhtml\Grid\Renderer
 * @method getColumn()
 * @method getInputId()
 * @method getInputName()
 */
class Mask extends Template
{

    /**
     * @var string
     */
    const INPUT = '<input type="text" id="{{id}}" name="{{name}}" class="{{class}}" size="{{siz}}" style="{{style}}" />';

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        $column = $this->getColumn();

        $input = $this->replaceHtml('{{id}}', $this->getInputId(), self::INPUT);
        $input = $this->replaceHtml('{{name}}', $this->getInputName(), $input);

        if (isset($column['class'])) {
            $input = $this->replaceHtml('{{class}}', $column['class'], $input);
        } else {
            $input = $this->replaceHtml('{{class}}', 'input-text', $input);
        }

        if (isset($column['style'])) {
            $input = $this->replaceHtml('{{style}}', $column['style'], $input);
        } else {
            $input = $this->replaceHtml('style="{{style}}"', '', $input);
        }

        if (isset($column['size'])) {
            $input = $this->replaceHtml('{{siz}}', $column['size'], $input);
        } else {
            $input = $this->replaceHtml('size="{{siz}}"', '', $input);
        }

        $input .= '
            <script type="text/javascript">
                require(["jquery", "js_mask"], ($) => {
                   $("#' . $this->getInputId() . '").mask("(00) 00000-0000");
                });
            </script>
        ';

        return $input;
    }

    /**
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return array|string|string[]
     */
    protected function replaceHtml(string $search, string $replace, string $subject): array|string
    {
        return str_replace($search, $replace, $subject);
    }
}
