<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander;

use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface;

class DataLayerExpander implements DataLayerExpanderInterface
{
    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface
     */
    protected $integerToDecimalConverter;

    /**
     * @var \Generated\Shared\Transfer\ProductViewTransfer|null
     */
    protected $productViewTransfer;

    /**
     * @param \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface $integerToDecimalConverter
     */
    public function __construct(
        IntegerToDecimalConverterInterface $integerToDecimalConverter
    ) {
        $this->integerToDecimalConverter = $integerToDecimalConverter;
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
        $dataLayer[ModuleConstants::FIELD_NAME] = $this->getName();
        $dataLayer[ModuleConstants::FIELD_CONTENT_TYPE] = $this->getProductAttrStyle();
        $dataLayer[ModuleConstants::FIELD_SKU] = $this->productViewTransfer->getSku();
        $dataLayer[ModuleConstants::FIELD_PRICE] = $this->getPrice();
        $dataLayer[ModuleConstants::FIELD_STOCK] = $this->productViewTransfer->getAvailable() === true
            ? ModuleConstants::IN_STOCK
            : ModuleConstants::OUT_OF_STOCK;

        return $dataLayer;
    }

    /**
     * @return string
     */
    protected function getName(): string
    {
        $productAttributes = $this->productViewTransfer->getAttributes();

        if (count($productAttributes) < 1) {
            return $this->productViewTransfer->getName();
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL_UNTRANSLATED]) &&
            !empty($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL_UNTRANSLATED]))
        {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL_UNTRANSLATED];
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL]) &&
            !empty($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL]))
        {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL];
        }

        return $this->productViewTransfer->getName();
    }

    /**
     * @return float
     */
    protected function getPrice(): float
    {
        return $this->integerToDecimalConverter->convert($this->productViewTransfer->getPrice());
    }

    /**
     * @return string
     */
    protected function getProductAttrStyle(): string
    {
        $productAttributes = $this->productViewTransfer->getAttributes();

        if (count($productAttributes) === 0) {
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
