<?php

namespace FondOfSpryker\Shared\GoogleTagManagerProductConnector;

interface GoogleTagManagerProductConnectorConstants
{
    public const PAGE_TYPE_PRODUCT = 'product';

    public const PARAM_PRODUCT = 'product';
    public const PARAM_ATTRIBUTE_EAN = 'productEan';
    public const PARAM_ATTRIBUTE_BRAND = 'brand';
    public const PARAM_ATTRIBUTE_NAME_UNTRANSLATED = 'name_untranslated';

    public const FIELD_BRAND = 'productBrand';
    public const FIELD_EAN = 'productEan';
    public const FIELD_NAME = 'productName';
    public const FIELD_SKU = 'productSku';
    public const FIELD_ID = 'productId';
    public const FIELD_IMAGE_URL = 'productImageUrl';
    public const FIELD_PRICE = 'productPrice';
    public const FIELD_PRICE_EXCLUDING_TAX = 'productPriceExcludingTax';
}
