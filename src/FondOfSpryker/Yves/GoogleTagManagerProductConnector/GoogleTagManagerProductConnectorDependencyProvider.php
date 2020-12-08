<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToStoreClientBridge;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorBridge;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Money\Plugin\MoneyPlugin;

class GoogleTagManagerProductConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_STORE = 'CLIENT_STORE';
    public const PLUGIN_MONEY = 'PLUGIN_MONEY';
    public const CLIENT_TAX_PRODUCT_CONNECTOR = 'CLIENT_TAX_PRODUCT_CONNECTOR';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addStoreClient($container);
        $container = $this->addMoneyPlugin($container);
        $container = $this->addTaxProductConnectorClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStoreClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORE, static function (Container $container) {
            return new GoogleTagManagerProductConnectorToStoreClientBridge(
                $container->getLocator()->store()->client()
            );
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
}
