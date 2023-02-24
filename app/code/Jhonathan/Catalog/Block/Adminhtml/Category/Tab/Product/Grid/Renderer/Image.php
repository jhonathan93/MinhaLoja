<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_Catalog
 */

namespace Jhonathan\Catalog\Block\Adminhtml\Category\Tab\Product\Grid\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Jhonathan\Catalog\Model\Method\Logger as Debug;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Backend\Block\Context;
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
     * @var Debug
     */
    protected Debug $_debug;

    /**
     * @param Context $context
     * @param ImageHelper $imageHelper
     * @param ProductRepositoryInterface $productRepositoryInterface
     * @param Url $url
     * @param Debug $debug
     * @param array $data
     */
    public function __construct(
        Context $context,
        ImageHelper $imageHelper,
        ProductRepositoryInterface $productRepositoryInterface,
        Url $url,
        Debug $debug,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_imageHelper = $imageHelper;
        $this->_productRepositoryInterface = $productRepositoryInterface;
        $this->_url = $url;
        $this->_debug = $debug;
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
            $this->_debug->debug(['error' => $e->getMessage()], true);
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
