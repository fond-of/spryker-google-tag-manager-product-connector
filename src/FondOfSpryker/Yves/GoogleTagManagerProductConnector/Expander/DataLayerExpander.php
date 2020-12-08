<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander;

use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;

class DataLayerExpander implements DataLayerExpanderInterface
{
    /**
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @var \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    protected $taxProductConnectorClient;

    /**
     * @var \Generated\Shared\Transfer\ProductViewTransfer|null
     */
    protected $productViewTransfer;

    /**
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     * @param \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface $taxProductConnectorClient
     */
    public function __construct(
        MoneyPluginInterface $moneyPlugin,
        GoogleTagManagerProductConnectorToTaxProductConnectorInterface $taxProductConnectorClient
    ) {
        $this->moneyPlugin = $moneyPlugin;
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

        $var = [
            ModuleConstants::PARAM_PRODUCT => $this->productViewTransfer->toArray(),
            ModuleConstants::PARAM_PRODUCT_ABSTRACT => $twigVariableBag[ModuleConstants::PARAM_PRODUCT_ABSTRACT]->toArray(),
        ];

        $dataLayer[ModuleConstants::FIELD_ID] = $this->productViewTransfer->getIdProductAbstract();
        $dataLayer[ModuleConstants::FIELD_NAME] = $this->getName($twigVariableBag);
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
        return $this->moneyPlugin->convertIntegerToDecimal($this->productViewTransfer->getPrice());
    }

    /**
     * @param array $twigVariableBag
     *
     * @return float
     */
    protected function getPriceExcludingTax(array $twigVariableBag): float
    {
        return $this->moneyPlugin->convertIntegerToDecimal(
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

        return $this->moneyPlugin->convertIntegerToDecimal($taxAmount);
    }
}
