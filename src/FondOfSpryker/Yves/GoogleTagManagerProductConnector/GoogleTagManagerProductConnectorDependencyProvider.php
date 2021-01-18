<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverter;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorBridge;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class GoogleTagManagerProductConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_TAX_PRODUCT_CONNECTOR = 'CLIENT_TAX_PRODUCT_CONNECTOR';
    public const CONVERTER_INTERGER_TO_DECIMAL = 'CONVERTER_INTERGER_TO_DECIMAL';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addIntegerToDecimalConverter($container);
        $container = $this->addTaxProductConnectorClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addTaxProductConnectorClient(Container $container): Container
    {
        $container->set(static::CLIENT_TAX_PRODUCT_CONNECTOR, static function (Container $container) {
            return new GoogleTagManagerProductConnectorToTaxProductConnectorBridge(
                $container->getLocator()->taxProductConnector()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addIntegerToDecimalConverter(Container $container): Container
    {
        $self = $this;

        $container->set(static::CONVERTER_INTERGER_TO_DECIMAL, static function () use ($self) {
            return $self->getIntegerToDecimalConverter();
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface
     */
    protected function getIntegerToDecimalConverter(): IntegerToDecimalConverterInterface
    {
        return new IntegerToDecimalConverter();
    }
}
