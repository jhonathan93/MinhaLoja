<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Block\Adminhtml\Grid;

use Jhonathan\Whatsapp\Block\Adminhtml\Grid\Renderer\Mask;
use Jhonathan\Whatsapp\Helper\Data as HelperData;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Exception\LocalizedException;

use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

/**
 * Class MultiSelect
 * @package Jhonathan\Whatsapp\Block\Adminhtml
 */
class MultiSelect extends AbstractFieldArray
{

    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param Context $context
     * @param HelperData $helperData
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct($context, $data, $secureRenderer);
        $this->helperData = $helperData;
    }

    /**
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn(
            'title',
            [
            'label' => __('Title'),
            'class' => 'required-entry']
        );

        $this->addColumn(
            'code',
            [
            'label' => __('Country code'),
            'style' => 'max-width: 60px;',
            'class' => 'required-entry']
        );

        $this->addColumn(
            'number',
            [
            'label' => __('Number'),
            'renderer' => $this->setMaskField(),
            'class' => 'required-entry']
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * @return BlockInterface|null
     */
    private function setMaskField(): ?BlockInterface
    {
        try {
            return $this->getLayout()->createBlock(Mask::class, '');
        } catch (LocalizedException $e) {
            $this->helperData->logger(['error' => $e->getMessage()], true);
            return null;
        }
    }
}

//https://magecomp.com/blog/add-dynamic-row-multi-select-system-configuration-magento-2/
