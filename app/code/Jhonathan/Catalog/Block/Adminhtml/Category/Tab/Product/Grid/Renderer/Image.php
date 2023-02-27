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
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Framework\DataObject;

use Magento\Framework\Exception\NoSuchEntityException;

use Magento\Framework\Url;

/**
 * Class Image
 * @package Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer
 */
class Image extends AbstractRenderer
{

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $_productRepositoryInterface;

    /**
     * @var ImageHelper
     */
    protected ImageHelper $_imageHelper;

    /**
     * @var Url
     */
    protected Url $_url;

    /**
     * @var HelperData
     */
    private HelperData $helperData;

    /**
     * @param Context $context
     * @param ImageHelper $imageHelper
     * @param ProductRepositoryInterface $productRepositoryInterface
     * @param Url $url
     * @param HelperData $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        ImageHelper $imageHelper,
        ProductRepositoryInterface $productRepositoryInterface,
        Url $url,
        HelperData $helperData,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_imageHelper = $imageHelper;
        $this->_productRepositoryInterface = $productRepositoryInterface;
        $this->_url = $url;
        $this->helperData = $helperData;
    }

    /**
     * @param DataObject $row
     * @return string
     */
    public function render(DataObject $row): string
    {
        try {
            $product = $this->_productRepositoryInterface->getById($row->getData('entity_id'));
            $imageUrl = $this->_imageHelper->init($product, 'product_listing_thumbnail')->getUrl();
            $url = $this->getProductUrl($product->getId());
            return '<a href="' . $url . '" target="_blank">
                        <img src="' . $imageUrl . '" width="150" alt="' . $product->getName() . '" title="' . $product->getName() . '"/>
                    </a>';
        } catch (NoSuchEntityException $e) {
            $this->helperData->logger(['error' => $e->getMessage()], true);
            return 'Error';
        }
    }

    /**
     * @param int $productId
     * @return string|null
     */
    private function getProductUrl(int $productId): ?string
    {
        return $this->_url->getUrl('catalog/product/view', ['id' => $productId, '_nosid' => false]);
    }
}
