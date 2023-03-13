<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ProgressBar
 */

namespace Jhonathan\ProgressBar\Block\Frontend;

use Jhonathan\ProgressBar\Helper\Data;
use Magento\Catalog\Model\ResourceModel\Url;
use Magento\Checkout\Block\Cart;
use Magento\Customer\Model\Session;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Progress
 * @package Jhonathan\ProgressBar\Block\Frontend
 */
class Progress extends Cart
{
    /**
     * @var string
     */
    const PROGRESS_TEXT = "Total no carrinho {{value1}}! Faltam {{value2}} para FRETE GRÁTIS";

    /**
     * @var Data
     */
    private Data $helperData;

    /**
     * @var PriceCurrencyInterface
     */
    private PriceCurrencyInterface $currency;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param Url $catalogUrlBuilder
     * @param \Magento\Checkout\Helper\Cart $cartHelper
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param Data $helperData
     * @param PriceCurrencyInterface $currency
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        Url $catalogUrlBuilder,
        \Magento\Checkout\Helper\Cart $cartHelper,
        \Magento\Framework\App\Http\Context $httpContext,
        Data $helperData,
        PriceCurrencyInterface $currency,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $catalogUrlBuilder, $cartHelper, $httpContext, $data);
        $this->helperData = $helperData;
        $this->currency = $currency;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        return [
            'percent' => $this->getPercent(),
            'text' => $this->getProgressText(),
        ];
    }

    /**
     * @return float
     */
    private function calculate(): float
    {
        $quote = $this->getQuote();
        $subTotal = $quote->getSubtotal();
        if (true && !is_null($quote->getAppliedRuleIds())) {
            $subTotal = $quote->getSubtotalWithDiscount();
        }

        return $subTotal;
    }

    /**
     * @return float|int
     */
    private function getPercent(): float|int
    {
        $value = 0;
        if ($this->helperData->getValueFreeShipping() > 0) {
            $value = $this->calculate() / $this->helperData->getValueFreeShipping() * 100;
            if ($value > 100) {
                $value = 100;
            }
        }
        return $value;
    }

    /**
     * @return string
     */
    private function getProgressText(): string
    {
        if ($this->calculate() > $this->helperData->getValueFreeShipping()) {
            return 'Parabéns Você ganhou entrega FRETE GRÁTIS';
        } else {
            $text = str_replace('{{value1}}', $this->currency->format($this->calculate(), false, 2), self::PROGRESS_TEXT);
            return str_replace('{{value2}}', $this->currency->format($this->helperData->getValueFreeShipping() - $this->calculate(), false, 2), $text);
        }
    }
}
