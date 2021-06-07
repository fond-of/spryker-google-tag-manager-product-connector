<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter;

use Spryker\Shared\Money\Exception\InvalidConverterArgumentException;

class IntegerToDecimalConverter implements IntegerToDecimalConverterInterface
{
    public const PRICE_PRECISION = '100';

    /**
     * @param int $value
     *
     * @throws \Spryker\Shared\Money\Exception\InvalidConverterArgumentException
     *
     * @return float
     */
    public function convert($value): float
    {
        if (!is_int($value)) {
            throw new InvalidConverterArgumentException(sprintf(
                'Only integer values allowed for conversion to float. Current type is "%s"',
                gettype($value)
            ));
        }

        return (float)bcdiv((string)$value, static::PRICE_PRECISION, 2);
    }
}
