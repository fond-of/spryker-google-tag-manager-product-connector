<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Model\GoogleTagManagerProductConnectorModel;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Model\GoogleTagManagerProductConnectorModelInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Yves\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConfig getConfig()
 */
class GoogleTagManagerProductConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Yves\GoogleTagManagerProductConnector\Model\GoogleTagManagerProductConnectorModelInterface
     */
    public function createGoogleTagManagerProductConnectorModel(): GoogleTagManagerProductConnectorModelInterface
    {
        return new GoogleTagManagerProductConnectorModel(
            $this->getStore(),
            $this->getMoneyPlugin(),
            $this->getConfig()
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
}
