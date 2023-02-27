<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer;

use Jhonathan\Catalog\Helper\Data as HelperData;
use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\InventoryConfigurationApi\Exception\SkuIsNotAssignedToStockException;
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;

/**
 * Class Salable
 * @package Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer
 */
class Salable extends AbstractRenderer
{

    /**
     * @var GetSalableQuantityDataBySku
     */
    private GetSalableQuantityDataBySku $getSalableQuantityDataBySku;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $_productRepository;

    /**
     * @var StockStateInterface
     */
    protected StockStateInterface $_stockState;

    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param HelperData $helperData
     * @param GetSalableQuantityDataBySku $getSalableQuantityDataBySku
     * @param StockStateInterface $stockState
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        HelperData $helperData,
        GetSalableQuantityDataBySku $getSalableQuantityDataBySku,
        StockStateInterface $stockState,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_productRepository = $productRepository;
        $this->helperData = $helperData;
        $this->getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
        $this->_stockState = $stockState;
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
                $qty = $this->getSalableQuantityDataBySku->execute($product->getSku());
                if (array_key_exists(0, $qty)) {
                    if ($qty[0]['qty'] > 0) {
                        return $qty[0]['qty'];
                    }
                }
            }

            return 0;
        } catch (LocalizedException | NoSuchEntityException | SkuIsNotAssignedToStockException $e) {
            $this->helperData->logger(['error' => $e->getMessage(), 'ID' => $productId], true);
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
