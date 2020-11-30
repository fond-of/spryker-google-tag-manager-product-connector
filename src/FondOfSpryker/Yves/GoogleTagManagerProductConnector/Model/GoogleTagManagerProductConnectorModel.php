<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Model;

use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants as ModuleConstants;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductImageTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;

class GoogleTagManagerProductConnectorModel implements GoogleTagManagerProductConnectorModelInterface
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
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     */
    public function __construct(Store $store, MoneyPluginInterface $moneyPlugin)
    {
        $this->store = $store;
        $this->moneyPlugin = $moneyPlugin;
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getBrand(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);
        $currentLocale = $this->store->getCurrentLocale();

        if (isset($itemTransfer->getAbstractAttributes()[ModuleConstants::ABSTRACT_ATTRIBUTES_UNLOCALIZED][ModuleConstants::PARAM_ATTRIBUTE_BRAND])) {
            return [
                ModuleConstants::FIELD_BRAND => $itemTransfer->getAbstractAttributes()[ModuleConstants::ABSTRACT_ATTRIBUTES_UNLOCALIZED][ModuleConstants::PARAM_ATTRIBUTE_BRAND],
            ];
        }

        if (isset($itemTransfer->getAbstractAttributes()[$currentLocale][ModuleConstants::PARAM_ATTRIBUTE_BRAND])) {
            return [
                ModuleConstants::FIELD_BRAND => $itemTransfer->getAbstractAttributes()[$currentLocale][ModuleConstants::PARAM_ATTRIBUTE_BRAND],
            ];
        }

        return [];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getEan(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);
        $currentLocale = $this->store->getCurrentLocale();
        $productAttributesUnlocalized = $itemTransfer->getAbstractAttributes()[ModuleConstants::ABSTRACT_ATTRIBUTES_UNLOCALIZED];
        $productAttributesLocalized = $itemTransfer->getAbstractAttributes()[$currentLocale];

        if (isset($productAttributesUnlocalized[ModuleConstants::PARAM_ATTRIBUTE_EAN])) {
            return [
                ModuleConstants::FIELD_EAN => $productAttributesUnlocalized[ModuleConstants::PARAM_ATTRIBUTE_EAN],
            ];
        }

        if (isset($productAttributesLocalized[ModuleConstants::PARAM_ATTRIBUTE_EAN])) {
            return [
                ModuleConstants::FIELD_EAN => $productAttributesLocalized[ModuleConstants::PARAM_ATTRIBUTE_EAN],
            ];
        }

        return [];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getImageUrl(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        $imageTransfer = function (ItemTransfer $itemTransfer) {
            foreach ($itemTransfer->getImages() as $imageTransfer) {
                return $imageTransfer;
            }
        };

        if ($imageTransfer instanceof ProductImageTransfer) {
            return [ModuleConstants::FIELD_IMAGE_URL => $imageTransfer->getExternalUrlSmall()];
        }

        if ($imageTransfer instanceof ProductImageStorageTransfer) {
            return [ModuleConstants::FIELD_IMAGE_URL => $imageTransfer->getExternalUrlSmall()];
        }

        return [];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getName(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);
        $productAttributesUnlocalized = $itemTransfer->getAbstractAttributes()[ModuleConstants::ABSTRACT_ATTRIBUTES_UNLOCALIZED];

        if (isset($productAttributesUnlocalized[ModuleConstants::PARAM_ATTRIBUTE_NAME_UNTRANSLATED])) {
            return [ModuleConstants::FIELD_NAME => $productAttributesUnlocalized[ModuleConstants::PARAM_ATTRIBUTE_NAME_UNTRANSLATED]];
        }

        return [ModuleConstants::FIELD_NAME => $itemTransfer->getName()];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getQuantity(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        if ($itemTransfer->getQuantity() > 0) {
            return [ModuleConstants::FIELD_QUANTITY => $itemTransfer->getQuantity()];
        }

        return [];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getUrl(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);
        $currentLocale = $this->store->getCurrentLocale();
        $productAttributesLocalized = $itemTransfer->getAbstractAttributes()[$currentLocale];

        if (!isset($productAttributesLocalized[ModuleConstants::PARAM_ATTRIBUTE_URL_KEY])) {
            return [];
        }

        $urlKey = $productAttributesLocalized[ModuleConstants::PARAM_ATTRIBUTE_URL_KEY];

        return [];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getId(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        return [ModuleConstants::FIELD_ID => $itemTransfer->getIdProductAbstract()];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getSku(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        return [ModuleConstants::FIELD_ID => $itemTransfer->getSku()];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getPrice(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        return [
        ModuleConstants::FIELD_PRICE => $this->moneyPlugin
            ->convertIntegerToDecimal(
                $itemTransfer->getUnitPrice()
            ),
        ];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getPriceExcludingTax(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        if ($itemTransfer->getUnitNetPrice() !== null) {
            return [
            ModuleConstants::FIELD_PRICE_EXCLUDING_TAX => $this->moneyPlugin
                ->convertIntegerToDecimal($itemTransfer->getUnitNetPrice()),
            ];
        }

        $netPrice = $this->moneyPlugin->convertIntegerToDecimal($itemTransfer->getUnitPrice() - $itemTransfer->getUnitTaxAmount());

        return [
            ModuleConstants::FIELD_PRICE_EXCLUDING_TAX => $netPrice,
        ];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getTax(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        return [
            ModuleConstants::FIELD_TAX => $this->moneyPlugin
                ->convertIntegerToDecimal($itemTransfer->getUnitTaxAmount()),
        ];
    }

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getTaxRate(string $page, array $params): array
    {
        $itemTransfer = (new ItemTransfer())->fromArray($params, true);

        return [
            ModuleConstants::FIELD_TAX_RATE => $itemTransfer->getTaxRate(),
        ];
    }
}
