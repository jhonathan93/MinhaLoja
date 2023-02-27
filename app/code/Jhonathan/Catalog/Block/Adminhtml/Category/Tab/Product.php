<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Block\Adminhtml\Category\Tab;

use Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Edit;
use Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Image;
use Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Salable;
use Jhonathan\Catalog\Helper\Data as HelperData;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Data\Collection;
use Magento\Framework\Registry;

/**
 * Class Product
 * @package Jhonathan\Catalog\Block\Adminhtml\Category\Tab
 */
class Product extends \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
{
    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param ProductFactory $productFactory
     * @param Registry $coreRegistry
     * @param HelperData $helperData
     * @param array $data
     * @param Visibility|null $visibility
     * @param Status|null $status
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        ProductFactory $productFactory,
        Registry $coreRegistry,
        HelperData $helperData,
        array $data = [],
        Visibility $visibility = null,
        Status $status = null
    ) {
        parent::__construct($context, $backendHelper, $productFactory, $coreRegistry, $data, $visibility, $status);
        $this->helperData = $helperData;
    }

    /**
     * @param Collection $collection
     */
    public function setCollection($collection)
    {
        $collection->setFlag('has_stock_status_filter', true);
        $collection = $collection->joinField(
            'qty',
            'cataloginventory_stock_item',
            'qty',
            'product_id=entity_id',
            '{{table}}.stock_id=1',
            'left'
        )->joinTable('cataloginventory_stock_item', 'product_id=entity_id', ['stock_status' => 'is_in_stock'])
            ->addAttributeToSelect('qty')
            ->addAttributeToSelect('thumbnail')
            ->addAttributeToSelect('salable')
            ->addAttributeToSelect('edit')
            ->load();
        parent::setCollection($collection);
    }

    /**
     * @return Extended|$this
     */
    protected function _prepareColumns(): Extended|static
    {
        parent::_prepareColumns();

        if ($this->helperData->isEnabled('general/enabled')) {
            $this->addColumnAfter('qty', [
               'header' => __('Quantity'),
               'index' => 'qty',
           ], 'sku');

            $this->addColumnAfter('salable', [
               'header' => __('Salable'),
               'index' => 'salable',
               'renderer' => Salable::class,
           ], 'qty');

            $this->addColumnAfter('Thumbnail', [
               'header' => __('Miniature'),
               'index' => 'Thumbnail',
               'renderer' => Image::class,
               'align' => 'center',
               'filter' => false,
               'sortable' => false,
               'column_css_class' => 'data-grid-thumbnail-cell'
           ], 'entity_id');

            $this->addColumnAfter('edit', [
               'header' => __('Edit'),
               'index' => 'Edit',
               'renderer' => Edit::class,
           ], 'position');

            $this->sortColumnsByOrder();
        }

        return $this;
    }
}
