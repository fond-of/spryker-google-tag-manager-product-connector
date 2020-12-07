<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;

class DataLayerExpander implements DataLayerExpanderInterface
{
    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @var GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    protected $taxProductConnectorClient;

    /**
     * @var null|ProductViewTransfer
     */
    protected $productViewTransfer;

    /**
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     * @param \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig $config
     */
    public function __construct(
        Store $store,
        MoneyPluginInterface $moneyPlugin,
        GoogleTagManagerProductConnectorToTaxProductConnectorInterface $taxProductConnectorClient
    ) {
        $this->store = $store;
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

        if (!$this->productViewTransfer) {
            return $dataLayer;
        }

        $dataLayer[ModuleConstants::FIELD_ID] = $this->productViewTransfer->getIdProductAbstract();
        $dataLayer[ModuleConstants::FIELD_NAME] = $this->getName($twigVariableBag);
        $dataLayer[ModuleConstants::FIELD_EAN] = $this->getAttrEan();
        $dataLayer[ModuleConstants::FIELD_BRAND] = $this->getAttrBrand();
        $dataLayer[ModuleConstants::FIELD_SKU] = $this->productViewTransfer->getSku();
        $dataLayer[ModuleConstants::FIELD_IMAGE_URL] = $this->getImageUrl();
        $dataLayer[ModuleConstants::FIELD_PRICE] = $this->getPrice();
        $dataLayer[ModuleConstants::FIELD_PRICE_EXCLUDING_TAX] = $this->getPriceExcludingTax();

        return $dataLayer;
    }

    /**
     * @return string
     */
    public function getAttrBrand(): string
    {
        if (isset($this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_BRAND])) {
            return $this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_BRAND];
        }

        return '';
    }

    /**
     * @return string
     */
    public function getAttrEan(): string
    {
        if (isset($this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_EAN])) {
            return $this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_EAN];
        }

        return '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (isset($this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_NAME_UNTRANSLATED])) {
            return $this->productViewTransfer->getAttributes()[ModuleConstants::PARAM_ATTRIBUTE_NAME_UNTRANSLATED];
        }

        return $this->productViewTransfer->getName();
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        if (isset($this->productViewTransfer->getImageSets()['BASEIMAGE'])) {
            foreach ($this->productViewTransfer->getImageSets()['BASEIMAGE'] as $transfer) {
                return $transfer->getExternalUrlSmall();
            }
        }

        return '';
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->moneyPlugin->convertIntegerToDecimal($this->productViewTransfer->getPrice());
    }

    /**
     * @return int
     */
    public function getPriceExcludingTax(): int
    {
        $productAbstractTransfer = (new ProductAbstractTransfer())
            ->fromArray($this->productViewTransfer->toArray(), true);

        return $this->moneyPlugin->convertIntegerToDecimal(
            $this->taxProductConnectorClient->getNetPriceForProduct($productAbstractTransfer)
                ->getNetPrice()
        );
    }
}
