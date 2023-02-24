<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Whatsapp
 */

namespace Jhonathan\Whatsapp\Block\Adminhtml\Grid;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Jhonathan\Whatsapp\Block\Adminhtml\Grid\Renderer\Mask;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Backend\Block\Template\Context;
use Jhonathan\Whatsapp\Model\Method\Logger;

use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class MultiSelect
 * @package Jhonathan\Whatsapp\Block\Adminhtml
 */
class MultiSelect extends AbstractFieldArray {

    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @param Context $context
     * @param Logger $logger
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(Context $context,
                                Logger $logger,
                                array $data = [],
                                ?SecureHtmlRenderer $secureRenderer = null) {
        parent::__construct($context, $data, $secureRenderer);
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    protected function _prepareToRender(): void {
        $this->addColumn('title', array(
            'label' => __('Title'),
            'class' => 'required-entry')
        );

        $this->addColumn('code', array(
            'label' => __('Country code'),
            'style' => 'max-width: 60px;',
            'class' => 'required-entry')
        );

        $this->addColumn('number', array(
            'label' => __('Number'),
            'renderer' => $this->setMaskField(),
            'class' => 'required-entry')
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * @return BlockInterface|null
     */
    private function setMaskField(): ?BlockInterface {
        try {
            return $this->getLayout()->createBlock(Mask::class, '');
        } catch (LocalizedException $e) {
            $this->logger->debug(['error' => $e->getMessage()], true);
            return null;
        }
    }
}

//https://magecomp.com/blog/add-dynamic-row-multi-select-system-configuration-magento-2/
