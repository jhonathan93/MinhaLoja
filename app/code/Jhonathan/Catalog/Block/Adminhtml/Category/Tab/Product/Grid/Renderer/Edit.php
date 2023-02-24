<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Backend\Helper\Data as BackendHelper;
use Magento\Backend\Block\Context;
use Magento\Framework\DataObject;

/**
 * Class Edit
 * @package Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer
 */
class Edit extends AbstractRenderer
{

    /**
     * @var BackendHelper
     */
    protected BackendHelper $_backendHelper;

    /**
     * @param Context $context
     * @param BackendHelper $backendHelper
     * @param array $data
     */
    public function __construct(Context $context, BackendHelper $backendHelper, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_backendHelper = $backendHelper;
    }

    /**
     * @param DataObject $row
     * @return string
     */
    public function render(DataObject $row): string
    {
        $url = $this->_backendHelper->getUrl('catalog/product/edit', ['id' => $row->getData("entity_id")]);
        return '<a href="' . $url . '" target="_blank"><span>' . __('Edit') . '</span></a>';
    }
}
