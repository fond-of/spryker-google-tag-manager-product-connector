<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter;

interface IntegerToDecimalConverterInterface
{
    /**
     * @param int $value
     *
     * @return float
     */
    public function convert($value): float;
}
