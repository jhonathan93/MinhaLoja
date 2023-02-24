<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Block\Adminhtml\Category\Tab;

use Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Salable;
use Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Image;
use Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer\Edit;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Framework\Data\Collection;

/**
 * Class Product
 * @package Jhonathan\Catalog\Block\Adminhtml\Category\Tab
 */
class Product extends \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
{

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

        return $this;
    }
}
