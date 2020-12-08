<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpander;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
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
        return new DataLayerExpander(
            $this->getMoneyPlugin(),
            $this->getTaxProductConnectorClient()
        );
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function getMoneyPlugin(): MoneyPluginInterface
    {
        return $this->getProvidedDependency(GoogleTagManagerProductConnectorDependencyProvider::PLUGIN_MONEY);
    }

    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Dependency\GoogleTagManagerProductConnectorToTaxProductConnectorInterface
     */
    public function getTaxProductConnectorClient(): GoogleTagManagerProductConnectorToTaxProductConnectorInterface
    {
        return $this->getProvidedDependency(GoogleTagManagerProductConnectorDependencyProvider::CLIENT_TAX_PRODUCT_CONNECTOR);
    }
}
