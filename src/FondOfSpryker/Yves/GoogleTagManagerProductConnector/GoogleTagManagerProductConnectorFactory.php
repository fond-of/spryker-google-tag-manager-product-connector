<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpander;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig getConfig()
 */
class GoogleTagManagerProductConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface
     */
    public function createDataLayerExpander(): DataLayerExpanderInterface
    {
        return new DataLayerExpander($this->getIntegerToDecimalConverter());
    }

    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface
     */
    public function getIntegerToDecimalConverter(): IntegerToDecimalConverterInterface
    {
        return $this->getProvidedDependency(GoogleTagManagerProductConnectorDependencyProvider::CONVERTER_INTERGER_TO_DECIMAL);
    }
}
