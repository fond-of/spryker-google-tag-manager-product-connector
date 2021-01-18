<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander;

use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;

class DataLayerExpander implements DataLayerExpanderInterface
{
    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface
     */
    protected $integerToDecimalConverter;

    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    protected $taxProductConnectorClient;

    /**
     * @var \Generated\Shared\Transfer\ProductViewTransfer|null
     */
    protected $productViewTransfer;

    /**
     * @param \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface $integerToDecimalConverter
     * @param \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface $taxProductConnectorClient
     */
    public function __construct(
        IntegerToDecimalConverterInterface $integerToDecimalConverter,
        GoogleTagManagerProductConnectorToTaxProductConnectorInterface $taxProductConnectorClient
    ) {
        $this->integerToDecimalConverter = $integerToDecimalConverter;
        $this->taxProductConnectorClient = $taxProductConnectorClient;
    }

    /**
     * @param array $twigVariableBag
     *
     * @return void
     */
    protected function setProductViewTransfer(array $twigVariableBag): void
    {
        $this->productViewTransfer = $twigVariableBag[ModuleConstants::PARAM_PRODUCT];
    }

    /**
     * @param string $page
     * @param array $twigVariableBag
     * @param array $dataLayer
     *
     * @return array
     */
    public function expand(string $page, array $twigVariableBag, array $dataLayer): array
    {
        $this->setProductViewTransfer($twigVariableBag);

        $dataLayer[ModuleConstants::FIELD_ID] = $this->productViewTransfer->getIdProductAbstract();
        $dataLayer[ModuleConstants::FIELD_NAME] = $this->getName($twigVariableBag);
        $dataLayer[ModuleConstants::FIELD_CONTENT_TYPE] = $this->getProductAttrStyle();
        $dataLayer[ModuleConstants::FIELD_SKU] = $this->productViewTransfer->getSku();
        $dataLayer[ModuleConstants::FIELD_PRICE] = $this->getPrice();
        $dataLayer[ModuleConstants::FIELD_PRICE_EXCLUDING_TAX] = $this->getPriceExcludingTax($twigVariableBag);
        $dataLayer[ModuleConstants::FIELD_TAX_RATE] = $this->getTaxRate($twigVariableBag);
        $dataLayer[ModuleConstants::FIELD_TAX_AMOUNT] = $this->getTaxAmount($twigVariableBag);

        return $dataLayer;
    }

    /**
     * @return string
     */
    protected function getName(): string
    {
        if (isset($this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_NAME_UNTRANSLATED])) {
            return $this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_NAME_UNTRANSLATED];
        }

        return $this->productViewTransfer->getName();
    }

    /**
     * @return int
     */
    protected function getPrice(): float
    {
        return $this->integerToDecimalConverter->convert($this->productViewTransfer->getPrice());
    }

    /**
     * @param array $twigVariableBag
     *
     * @return float
     */
    protected function getPriceExcludingTax(array $twigVariableBag): float
    {
        return $this->integerToDecimalConverter->convert(
            $this->taxProductConnectorClient
                ->getNetPriceForProduct($twigVariableBag[ModuleConstants::PARAM_PRODUCT_ABSTRACT])
                ->getNetPrice()
        );
    }

    /**
     * @param array $twigVariableBag
     *
     * @return float
     */
    protected function getTaxRate(array $twigVariableBag): float
    {
        return $this->taxProductConnectorClient
            ->getNetPriceForProduct($twigVariableBag[ModuleConstants::PARAM_PRODUCT_ABSTRACT])
            ->getTaxRate();
    }

    /**
     * @param array $twigVariableBag
     *
     * @return float
     */
    protected function getTaxAmount(array $twigVariableBag): float
    {
        $taxAmount = $this->taxProductConnectorClient
            ->getTaxAmountForProduct($twigVariableBag[ModuleConstants::PARAM_PRODUCT_ABSTRACT])
            ->getTaxAmount();

        return $this->integerToDecimalConverter->convert($taxAmount);
    }

    /**
     * @param array $product
     *
     * @return string
     */
    protected function getProductAttrStyle(): string
    {
        $productAttributes = $this->productViewTransfer->getAttributes();

        if (!$productAttributes || count($productAttributes) === 0) {
            return '';
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE_UNTRANSLATED])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE_UNTRANSLATED];
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE];
        }

        return '';
    }
}
