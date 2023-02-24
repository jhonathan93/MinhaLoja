<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer;

use Jhonathan\Catalog\Model\Method\Logger as Debug;
use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;
use Magento\InventorySalesApi\Api\IsProductSalableInterface;

/**
 * Class Salable
 * @package Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer
 */
class Salable extends AbstractRenderer
{
    /**
     * @var GetProductSalableQtyInterface
     */
    protected GetProductSalableQtyInterface $_salableQty;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $_productRepository;

    /**
     * @var IsProductSalableInterface
     */
    protected IsProductSalableInterface $_isProductSalable;

    /**
     * @var StockStateInterface
     */
    protected StockStateInterface $_stockState;

    /**
     * @var Debug
     */
    protected Debug $_debug;

    /**
     * @param Context $context
     * @param GetProductSalableQtyInterface $salableQty
     * @param ProductRepositoryInterface $productRepository
     * @param IsProductSalableInterface $isProductSalable
     * @param StockStateInterface $stockState
     * @param Debug $debug
     * @param array $data
     */
    public function __construct(
        Context $context,
        GetProductSalableQtyInterface $salableQty,
        ProductRepositoryInterface $productRepository,
        IsProductSalableInterface $isProductSalable,
        StockStateInterface $stockState,
        Debug $debug,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_salableQty = $salableQty;
        $this->_productRepository = $productRepository;
        $this->_isProductSalable = $isProductSalable;
        $this->_stockState = $stockState;
        $this->_debug = $debug;
    }

    /**
     * @param $productId
     * @return float|int|string
     */
    protected function getStockItem($productId): float|int|string
    {
        try {
            $product = $this->_productRepository->getById($productId);

            if ($this->_stockState->getStockQty($productId, $product->getStoreid()) > 0) {
                if ($this->_isProductSalable->execute($product->getSku(), $product->getStoreId())) {
                    $Qty = $this->_salableQty->execute($product->getSku(), $product->getStoreId());

                    if ($Qty > 0) {
                        return $Qty;
                    } else {
                        return 0;
                    }
                }
            }

            return 0;
        } catch (LocalizedException | InputException $e) {
            $this->_debug->debug(['error' => $e->getMessage()], true);
            return 'Error';
        }
    }

    /**
     * @param DataObject $row
     * @return float|int|string
     */
    public function Render(DataObject $row): float|int|string
    {
        return $this->getStockItem($row->getData('entity_id'));
    }
}
