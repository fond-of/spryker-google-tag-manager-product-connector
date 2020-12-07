<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorBridge;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Money\Plugin\MoneyPlugin;

class GoogleTagManagerProductConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const STORE = 'STORE';
    public const PLUGIN_MONEY = 'PLUGIN_MONEY';
    public const CLIENT_TAX_PRODUCT_CONNECTOR = 'CLIENT_TAX_PRODUCT_CONNECTOR';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addStore($container);
        $container = $this->addMoneyPlugin($container);
        $container = $this->addTaxProductConnectorClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container->set(static::STORE, static function () {
            return Store::getInstance();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addMoneyPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_MONEY, static function () {
            return new MoneyPlugin();
        });

        return $container;
    }

    /**
     * @param Container $container
     * @return Container
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException
     */
    protected function addTaxProductConnectorClient(Container $container): Container
    {
        $container->set(static::CLIENT_TAX_PRODUCT_CONNECTOR, static function(Container $container) {
            return new GoogleTagManagerProductConnectorToTaxProductConnectorBridge(
                $container->getLocator()->taxProductConnector()->client()
            );
        });

        return $container;
    }
}
