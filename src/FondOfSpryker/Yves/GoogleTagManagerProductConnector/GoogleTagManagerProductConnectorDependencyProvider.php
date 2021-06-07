<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverter;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Converter\IntegerToDecimalConverterInterface;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class GoogleTagManagerProductConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CONVERTER_INTERGER_TO_DECIMAL = 'CONVERTER_INTERGER_TO_DECIMAL';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addIntegerToDecimalConverter($container);

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
