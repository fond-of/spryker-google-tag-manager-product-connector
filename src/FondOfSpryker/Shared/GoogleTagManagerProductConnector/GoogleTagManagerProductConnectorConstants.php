<?php

namespace FondOfSpryker\Shared\GoogleTagManagerProductConnector;

interface GoogleTagManagerProductConnectorConstants
{
    public const PAGE_TYPE_PRODUCT = 'product';
    public const PARAM_PRODUCT_ABSTRACT = 'productAbstract';

    public const PARAM_PRODUCT = 'product';
    public const PARAM_ATTRIBUTE_EAN = 'productEan';
    public const PARAM_ATTRIBUTE_BRAND = 'brand';
    public const PARAM_ATTRIBUTE_NAME_UNTRANSLATED = 'name_untranslated';
    public const PARAM_PRODUCT_ATTR_STYLE_UNTRANSLATED = 'style_untranslated';
    public const PARAM_PRODUCT_ATTR_STYLE = 'style';

    public const FIELD_NAME = 'productName';
    public const FIELD_SKU = 'productSku';
    public const FIELD_ID = 'productId';
    public const FIELD_PRICE = 'productPrice';
    public const FIELD_CONTENT_TYPE = 'contentType';
}
