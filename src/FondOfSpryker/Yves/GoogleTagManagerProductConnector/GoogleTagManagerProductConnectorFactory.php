<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpander;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig getConfig()
 */
class GoogleTagManagerProductConnectorFactory extends AbstractFactory
{
    /**
     * @return DataLayerExpanderInterface
     */
    public function createDataLayerExpander(): DataLayerExpanderInterface
    {
        return new DataLayerExpander(
            $this->getStore(),
            $this->getMoneyPlugin(),
            $this->getTaxProductConnectorClient()
        );
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(GoogleTagManagerProductConnectorDependencyProvider::STORE);
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function getMoneyPlugin(): MoneyPluginInterface
    {
        return $this->getProvidedDependency(GoogleTagManagerProductConnectorDependencyProvider::PLUGIN_MONEY);
    }

    /**
     * @return GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getTaxProductConnectorClient(): GoogleTagManagerProductConnectorToTaxProductConnectorInterface
    {
        return $this->getProvidedDependency(GoogleTagManagerProductConnectorDependencyProvider::CLIENT_TAX_PRODUCT_CONNECTOR);
    }
}
